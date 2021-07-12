<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAssessmentRequest;
use App\Http\Requests\StoreAssessmentRequest;
use App\Models\Assessment;
use App\Models\Question;
use App\Models\Site;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AssessmentController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('assessment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (auth()->user()->is_admin) {
            $assessments = Assessment::with(['user'])->get();
        } else {
            $assessments = Assessment::with(['user'])->where('user_id',auth()->id())->get();
        }
        return view('admin.assessments.index', compact('assessments'));
    }

    public function create()
    {
        abort_if(Gate::denies('assessment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $questions = Question::with('answers')->where('is_active','1')->get();
        if (count($questions)==0){
            $message = "Currently not access this page, Please Contact <strong>".Site::config()->site_email."</strong>";
            return view('admin.not-access',compact('message'));
        }
        return view('admin.assessments.create', compact('questions'));
    }

    public function store(StoreAssessmentRequest $request)
    {
        $data['content'] = json_encode($request->except('_token'));
        $data['user_id']=auth()->id();
        $assessment = Assessment::create($data);
        return redirect()->route('admin.assessments.show',$assessment->id);

    }

    public function show(Assessment $assessment)
    {
        abort_if(Gate::denies('assessment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $questions = json_decode($assessment->content);
        return view('admin.assessments.show', compact('assessment','questions'));
    }
    public function destroy(Assessment $assessment)
    {
        abort_if(Gate::denies('assessment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $assessment->delete();

        return back();
    }
    public function massDestroy(MassDestroyAssessmentRequest $request)
    {
        Assessment::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
