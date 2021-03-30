@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.trainingApply.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.training-applies.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.trainingApply.fields.id') }}
                        </th>
                        <td>
                            {{ $trainingApply->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.trainingApply.fields.training') }}
                        </th>
                        <td>
                            {{ $trainingApply->training->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.trainingApply.fields.user') }}
                        </th>
                        <td>
                            {{ $trainingApply->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.trainingApply.fields.is_status') }}
                        </th>
                        <td>
                            {{ App\Models\TrainingApply::IS_STATUS_SELECT[$trainingApply->is_status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.trainingApply.fields.who_give_permission') }}
                        </th>
                        <td>
                            {{ $trainingApply->who_give_permission }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.training-applies.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>



@endsection
