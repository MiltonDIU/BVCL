<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyQuestionRequest;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Answer;
use App\Models\Question;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QuestionsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('question_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $questions = Question::all();

        return view('admin.questions.index', compact('questions'));
    }

    public function create()
    {
        abort_if(Gate::denies('question_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.questions.create');
    }

    public function store(StoreQuestionRequest $request)
    {

        $question = Question::create($request->all());
        if (!empty($request->answers)){
            $data=array();
            $i=0;
            foreach ($request->answers as $answer){
                $data1['title']=$request->answers[$i];
                $data1['mark']=$request->marks[$i];
                $data1['question_id']=$question->id;
                $data1['is_active']=1;
                $i++;
                array_push($data,$data1);
            }
            Answer::insert($data);
        }
        return redirect()->route('admin.questions.index');
    }

    public function edit(Question $question)
    {
        abort_if(Gate::denies('question_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $answers = Answer::where('question_id',$question->id)->where('is_active','1')->get();
        return view('admin.questions.edit', compact('question','answers'));
    }

    public function update(UpdateQuestionRequest $request, Question $question)
    {
        $question->update($request->all());
        if (!empty($request->answers)){
            $data=array();
            $i=0;
            foreach ($request->answers as $answer){
                $data1['title']=$request->answers[$i];
                $data1['mark']=$request->marks[$i];
                $data1['question_id']=$question->id;
                $data1['is_active']=1;
                $i++;
                array_push($data,$data1);
            }
            Answer::insert($data);
        }
        return redirect()->route('admin.questions.index');
    }

    public function show(Question $question)
    {
        abort_if(Gate::denies('question_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $question->load('questionAnswers');

        return view('admin.questions.show', compact('question'));
    }

    public function destroy(Question $question)
    {
        abort_if(Gate::denies('question_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $question->delete();

        return back();
    }

    public function massDestroy(MassDestroyQuestionRequest $request)
    {
        Question::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
