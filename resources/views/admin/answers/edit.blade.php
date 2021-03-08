@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.answer.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.answers.update", [$answer->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="question_id">{{ trans('cruds.answer.fields.question') }}</label>
                    <select class="form-control select2 {{ $errors->has('question') ? 'is-invalid' : '' }}" name="question_id" id="question_id" required>
                        @foreach($questions as $id => $question)
                            <option value="{{ $id }}" {{ (old('question_id') ? old('question_id') : $answer->question->id ?? '') == $id ? 'selected' : '' }}>{{ $question }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('question'))
                        <div class="invalid-feedback">
                            {{ $errors->first('question') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.answer.fields.question_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="title">{{ trans('cruds.answer.fields.title') }}</label>
                    <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $answer->title) }}" required>
                    @if($errors->has('title'))
                        <div class="invalid-feedback">
                            {{ $errors->first('title') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.answer.fields.title_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="mark">{{ trans('cruds.answer.fields.mark') }}</label>
                    <input class="form-control {{ $errors->has('mark') ? 'is-invalid' : '' }}" type="number" name="mark" id="mark" value="{{ old('mark', $answer->mark) }}" step="1" required>
                    @if($errors->has('mark'))
                        <div class="invalid-feedback">
                            {{ $errors->first('mark') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.answer.fields.mark_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required">{{ trans('cruds.answer.fields.is_active') }}</label>
                    @foreach(App\Models\Answer::IS_ACTIVE_RADIO as $key => $label)
                        <div class="form-check {{ $errors->has('is_active') ? 'is-invalid' : '' }}">
                            <input class="form-check-input" type="radio" id="is_active_{{ $key }}" name="is_active" value="{{ $key }}" {{ old('is_active', $answer->is_active) === (string) $key ? 'checked' : '' }} required>
                            <label class="form-check-label" for="is_active_{{ $key }}">{{ $label }}</label>
                        </div>
                    @endforeach
                    @if($errors->has('is_active'))
                        <div class="invalid-feedback">
                            {{ $errors->first('is_active') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.answer.fields.is_active_helper') }}</span>
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
