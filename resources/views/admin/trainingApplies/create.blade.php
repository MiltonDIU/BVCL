@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.trainingApply.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.training-applies.store") }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="training_id">{{ trans('cruds.trainingApply.fields.training') }}</label>
                    <select class="form-control select2 {{ $errors->has('training') ? 'is-invalid' : '' }}" name="training_id" id="training_id">
                        @foreach($trainings as $id => $training)
                            <option value="{{ $id }}" {{ old('training_id') == $id ? 'selected' : '' }}>{{ $training }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('training'))
                        <div class="invalid-feedback">
                            {{ $errors->first('training') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.trainingApply.fields.training_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="user_id">{{ trans('cruds.trainingApply.fields.user') }}</label>
                    <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                        @foreach($users as $id => $user)
                            <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $user }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('user'))
                        <div class="invalid-feedback">
                            {{ $errors->first('user') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.trainingApply.fields.user_helper') }}</span>
                </div>
                <div class="form-group">
                    <label>{{ trans('cruds.trainingApply.fields.is_status') }}</label>
                    <select class="form-control {{ $errors->has('is_status') ? 'is-invalid' : '' }}" name="is_status" id="is_status">
                        <option value disabled {{ old('is_status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Models\TrainingApply::IS_STATUS_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('is_status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('is_status'))
                        <div class="invalid-feedback">
                            {{ $errors->first('is_status') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.trainingApply.fields.is_status_helper') }}</span>
                </div>
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>



@endsection
