<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTrainingApplyRequest;
use App\Http\Requests\StoreTrainingApplyRequest;
use App\Http\Requests\UpdateTrainingApplyRequest;
use App\Models\Training;
use App\Models\TrainingApply;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrainingApplyController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('training_apply_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $trainingApplies = TrainingApply::with(['training', 'user'])->get();

        return view('admin.trainingApplies.index', compact('trainingApplies'));
    }

    public function create()
    {
        abort_if(Gate::denies('training_apply_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $trainings = Training::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.trainingApplies.create', compact('trainings', 'users'));
    }

    public function store(StoreTrainingApplyRequest $request)
    {
        $data = $request->all();
        $data['who_give_permission']=auth()->id();
        $trainingApply = TrainingApply::create($data);


        return redirect()->route('admin.training-applies.index');
    }

    public function edit(TrainingApply $trainingApply)
    {
        abort_if(Gate::denies('training_apply_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $trainings = Training::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $trainingApply->load('training', 'user');

        return view('admin.trainingApplies.edit', compact('trainings', 'users', 'trainingApply'));
    }

    public function update(UpdateTrainingApplyRequest $request, TrainingApply $trainingApply)
    {
        $trainingApply->update($request->all());
        return redirect()->route('admin.training-applies.index');
    }

    public function show(TrainingApply $trainingApply)
    {
        abort_if(Gate::denies('training_apply_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $trainingApply->load('training', 'user');

        return view('admin.trainingApplies.show', compact('trainingApply'));
    }

//    public function destroy(TrainingApply $trainingApply)
//    {
//        abort_if(Gate::denies('training_apply_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
//
//        $trainingApply->delete();
//
//        return back();
//    }
//
//    public function massDestroy(MassDestroyTrainingApplyRequest $request)
//    {
//        TrainingApply::whereIn('id', request('ids'))->delete();
//
//        return response(null, Response::HTTP_NO_CONTENT);
//    }


}
