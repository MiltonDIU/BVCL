@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.assessment.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.assessments.store") }}" enctype="multipart/form-data">
                @csrf
{{--                <div class="form-group">--}}
{{--                    <label class="required" for="user_id">{{ trans('cruds.assessment.fields.user') }}</label>--}}
{{--                    <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>--}}
{{--                        @foreach($users as $id => $user)--}}
{{--                            <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $user }}</option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
{{--                    @if($errors->has('user'))--}}
{{--                        <div class="invalid-feedback">--}}
{{--                            {{ $errors->first('user') }}--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                    <span class="help-block">{{ trans('cruds.assessment.fields.user_helper') }}</span>--}}
{{--                </div>--}}
                @foreach($questions as $id => $question)
                <div class="form-group">
                    <label class="required" for="questions">{{ trans('cruds.assessment.fields.question') }}</label>
                        <h3>{{ $question->title }}</h3>
                    @foreach($question->answers as $answer)
                        <input type="radio" value="{{$answer->id}}" name="{{$question->id}}" >
                        {{$answer->title}}
                        @endforeach
                    @if($errors->has('questions'))
                        <div class="invalid-feedback">
                            {{ $errors->first('questions') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.assessment.fields.question_helper') }}</span>
                </div>
                @endforeach
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>



@endsection
