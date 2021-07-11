<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyTrainingRequest;
use App\Http\Requests\StoreTrainingRequest;
use App\Http\Requests\TrainingApplyRequest;
use App\Http\Requests\UpdateTrainingRequest;
use App\Models\Attendance;
use App\Models\Day;
use App\Models\Training;
use App\Models\TrainingApply;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class TrainingController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('training_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (auth()->user()->is_admin) {
            $trainings = Training::with(['users'])->get();
        } else {
            $trainings =  Training::with(['users'])->where('is_active','2')->get();
        }

        return view('admin.trainings.index', compact('trainings'));
    }

    public function create()
    {
        abort_if(Gate::denies('training_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::whereHas('roles', function ($query) {
            $query->where('id','!=',config('panel.registration_default_role'));
        })->get()->pluck('name', 'id');

        $days = Day::all()->pluck('name', 'id');

        if(count($users)==0){
            return redirect(route('admin.users.create'));
        }

        return view('admin.trainings.create', compact('users','days'));
    }

    public function store(StoreTrainingRequest $request)
    {
        $training = Training::create($request->all());
        $training->users()->sync($request->input('users', []));

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $training->id]);
        }

        $day_ids = $request->input('day_id');
        $begin_time = $request->input('begin_time');
        $close_time = $request->input('close_time');
        if ($day_ids){
            foreach ($day_ids as $key => $day_id) {
                $training->days()->attach($day_id, array('begin_time' => $begin_time[$key], 'close_time' => $close_time[$key]));
            }
        }
        return redirect()->route('admin.trainings.index');
    }

    public function edit(Training $training)
    {
        abort_if(Gate::denies('training_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id');

        $training->load('users');
        $training->load('days');
        $days = Day::all()->pluck('name', 'id');
        return view('admin.trainings.edit', compact('users', 'training','days'));
    }

    public function update(UpdateTrainingRequest $request, Training $training)
    {
        $training->update($request->all());
        $training->users()->sync($request->input('users', []));
        $day_ids = $request->input('day_id');
        $begin_time = $request->input('begin_time');
        $close_time = $request->input('close_time');
        $syncDay = 1;
        $syncData = array();
        if ($day_ids){
            foreach ($day_ids as $key => $day_id) {
                $syncData[$syncDay] = array('day_id' => $day_id, 'begin_time' => $begin_time[$syncDay - 1], 'close_time' => $close_time[$syncDay - 1]);
                $syncDay++;
            }
        }

        $training->days()->sync($syncData);
        return redirect()->route('admin.trainings.index');
    }

    public function show(Training $training)
    {
        abort_if(Gate::denies('training_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $training->load('users');

        return view('admin.trainings.show', compact('training'));
    }

    public function destroy(Training $training)
    {
        abort_if(Gate::denies('training_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $training->delete();

        return back();
    }

    public function massDestroy(MassDestroyTrainingRequest $request)
    {
        Training::whereIn('id', request('ids'))->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('training_create') && Gate::denies('training_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $model         = new Training();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function apply(TrainingApplyRequest $request){
        abort_if(Gate::denies('training_apply'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data = $request->only('training_id');
        $data['user_id']=auth()->id();
        TrainingApply::create($data);
        return redirect()->route('admin.trainings.index');
    }
    public function approved(Request $request){
        abort_if(Gate::denies('training_approved'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $trainingApply = TrainingApply::where('id',$request->input('id'))->first();
        $data = $request->all();
        $data['who_give_permission']=auth()->id();
        $trainingApply->update($data);
        return redirect()->back();
    }

    public function attendance($id){
        abort_if(Gate::denies('attendance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (auth()->user()->is_admin) {
            $trainings = Training::where('id',$id)->first();
        } else {
            $trainings =  Training::where('id',$id)->where('is_active','1')->first();
        }
        return view('admin.trainings.attendance', compact('trainings'));
    }




    public function attendanceStore(Request $request){

            $data['training_id'] = $request->input('training_id');
            $data['event_date'] = $request->input('event_date');

            $attendances = Attendance::where('training_id',$request->input('training_id'))->where('event_date',date('Y-m-d'))->get();



            if ($attendances){
                foreach ($attendances as $attendance)
                $attendance->delete();
            }
            foreach ( $request->input('user_id') as $user){
              $data['user_id']=$user;
              Attendance::create($data);
            }
            return redirect()->back();

    }
}
