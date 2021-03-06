<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyServiceRequest;
use App\Http\Requests\ServiceAssignToRequest;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use App\Models\ServiceHistory;
use App\Models\ServiceStatus;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class ServiceController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('service_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (auth()->user()->is_admin) {
            $services = Service::with(['user', 'service_status', 'media'])->get();
        } else {
            $services = Service::with(['user', 'service_status', 'media'])
                ->where('user_id',auth()->id())
                ->orWhereHas('assigns', function ($query) {
                    $query->where('user_id',auth()->id());
                })->get();
        }

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        abort_if(Gate::denies('service_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

      $service_statuses = ServiceStatus::all()->pluck('name', 'id');
      if(count($service_statuses)==0){
    return redirect(route('admin.service-statuses.create'));
}

        return view('admin.services.create');
    }

    public function store(StoreServiceRequest $request)
    {
        $data  = $request->all();
        $data['user_id']=auth()->id();
        $data['service_status_id']=1;
        $service = Service::create($data);

        if ($request->input('document', false)) {
            $service->addMedia(storage_path('tmp/uploads/' . $request->input('document')))->toMediaCollection('document');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $service->id]);
        }

        return redirect()->route('admin.services.index');
    }

    public function edit(Service $service)
    {
        abort_if(Gate::denies('service_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (!auth()->user()->is_admin) {
            $services = Service::whereHas('assigns', function ($query) {
                $query->where('user_id',auth()->id());
            })->where('id',$service->id)->get();


            if ((auth()->id()!=$service->user_id) and (count($services)==0)){
                return redirect('not-allowed');
            }
        }

//        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $service_statuses = ServiceStatus::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $service->load( 'service_status');

        return view('admin.services.edit', compact( 'service_statuses', 'service'));
    }

    public function update(UpdateServiceRequest $request, Service $service)
    {
        if (!auth()->user()->is_admin) {
            $services = Service::whereHas('assigns', function ($query) {
                $query->where('user_id',auth()->id());
            })->where('id',$service->id)->get();
            if ((auth()->id()!=$service->user_id) and (count($services)==0)){
                return redirect('not-allowed');
            }
        }
        $data  = $request->all();
        $service->update($data);
        if ($request->input('document', false)) {
            if (!$service->document || $request->input('document') !== $service->document->file_name) {
                if ($service->document) {
                    $service->document->delete();
                }

                $service->addMedia(storage_path('tmp/uploads/' . $request->input('document')))->toMediaCollection('document');
            }
        } elseif ($service->document) {
            $service->document->delete();
        }

        return redirect()->route('admin.services.index');
    }

    public function show(Service $service)
    {
        abort_if(Gate::denies('service_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (!auth()->user()->is_admin) {

            $services = Service::whereHas('assigns', function ($query) {
                    $query->where('user_id',auth()->id());
                })->where('id',$service->id)->get();


            if ((auth()->id()!=$service->user_id) and (count($services)==0)){
                return redirect('not-allowed');
            }
        }

        $service->load('user', 'service_status','serviceHistories');
        return view('admin.services.show', compact('service'));
    }

    public function destroy(Service $service)
    {
        abort_if(Gate::denies('service_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (!auth()->user()->is_admin) {
            if (auth()->id()!=$service->user_id){
                return redirect('not-allowed');
            }
        }
        $service->delete();

        return back();
    }

    public function massDestroy(MassDestroyServiceRequest $request)
    {
        Service::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('service_create') && Gate::denies('service_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Service();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function assignTo($id)
    {
        abort_if(Gate::denies('service_assign_to'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $service = Service::find($id);
        $assigns = User::whereHas('roles', function ($query) {
            $query->where('id','!=',config('panel.registration_default_role'));
        })->get()->pluck('name', 'id');
        $service_statuses = ServiceStatus::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('admin.services.assign-to',compact('service','assigns','service_statuses'));
    }

    public function assignToPost(ServiceAssignToRequest $request)
    {
        $service = Service::find($request->service_id);
        $data['service_status_id']  = $request->service_status_id;
        if (!auth()->user()->is_admin) {
            $services = Service::whereHas('assigns', function ($query) {
                $query->where('user_id',auth()->id());
            })->where('id',$service->id)->get();


            if ((auth()->id()!=$service->user_id) and (count($services)==0)){
                return redirect('not-allowed');
            }
        }
        $service->update($data);
        $service->assigns()->sync($request->input('assigns', []));
        $data['user_id'] =  auth()->id();
        $data['service_id'] =  $service->id;
        $data['content'] =  $request->comments;
        ServiceHistory::create($data);
        return redirect()->route('admin.services.index');

    }
    public function serviceStatus($id)
    {

        abort_if(Gate::denies('service_status_change'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $service = Service::find($id);
        $service_statuses = ServiceStatus::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.services.status-change',compact('service','service_statuses'));
    }
    public function serviceStatusChange(Request $request)
    {
        $service = Service::find($request->service_id);
        $data['service_status_id']  = $request->service_status_id;
        if (!auth()->user()->is_admin) {
            $services = Service::whereHas('assigns', function ($query) {
                $query->where('user_id',auth()->id());
            })->where('id',$service->id)->get();

            if ((auth()->id()!=$service->user_id) and (count($services)==0)){
                return redirect('not-allowed');
            }
        }
        $service->update($data);
        $data['user_id'] =  auth()->id();
        $data['service_id'] =  $service->id;
        $data['content'] =  $request->comments;
        ServiceHistory::create($data);
        return redirect()->route('admin.services.index');

    }

    public function comments($id)
    {

        abort_if(Gate::denies('service_status_change'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $service = Service::find($id);
        return view('admin.services.comments',compact('service'));
    }
    public function serviceComments(Request $request)
    {
        $service = Service::find($request->service_id);
        if (!auth()->user()->is_admin) {
            $services = Service::whereHas('assigns', function ($query) {
                $query->where('user_id',auth()->id());
            })->where('id',$service->id)->get();


            if ((auth()->id()!=$service->user_id) and (count($services)==0)){
                return redirect('not-allowed');
            }
        }
        $data['user_id'] =  auth()->id();
        $data['service_id'] =  $service->id;
        $data['content'] =  $request->comments;
        ServiceHistory::create($data);
        return redirect()->route('admin.services.index');
    }
    public function history($id)
    {
        abort_if(Gate::denies('service_history'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $service = Service::with('serviceHistories')->find($id);
        return view('admin.services.history',compact('service'));
    }
}
