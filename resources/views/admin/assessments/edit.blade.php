@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.assessment.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.assessments.update", [$assessment->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="user_id">{{ trans('cruds.assessment.fields.user') }}</label>
                    <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                        @foreach($users as $id => $user)
                            <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $assessment->user->id ?? '') == $id ? 'selected' : '' }}>{{ $user }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('user'))
                        <div class="invalid-feedback">
                            {{ $errors->first('user') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.assessment.fields.user_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="questions">{{ trans('cruds.assessment.fields.question') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('questions') ? 'is-invalid' : '' }}" name="questions[]" id="questions" multiple required>
                        @foreach($questions as $id => $question)
                            <option value="{{ $id }}" {{ (in_array($id, old('questions', [])) || $assessment->questions->contains($id)) ? 'selected' : '' }}>{{ $question }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('questions'))
                        <div class="invalid-feedback">
                            {{ $errors->first('questions') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.assessment.fields.question_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="answers">{{ trans('cruds.assessment.fields.answer') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('answers') ? 'is-invalid' : '' }}" name="answers[]" id="answers" multiple required>
                        @foreach($answers as $id => $answer)
                            <option value="{{ $id }}" {{ (in_array($id, old('answers', [])) || $assessment->answers->contains($id)) ? 'selected' : '' }}>{{ $answer }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('answers'))
                        <div class="invalid-feedback">
                            {{ $errors->first('answers') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.assessment.fields.answer_helper') }}</span>
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
