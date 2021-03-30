@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.attendance.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.attendances.update", [$attendance->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="training_id">{{ trans('cruds.attendance.fields.training') }}</label>
                    <select class="form-control select2 {{ $errors->has('training') ? 'is-invalid' : '' }}" name="training_id" id="training_id" required>
                        @foreach($trainings as $id => $training)
                            <option value="{{ $id }}" {{ (old('training_id') ? old('training_id') : $attendance->training->id ?? '') == $id ? 'selected' : '' }}>{{ $training }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('training'))
                        <div class="invalid-feedback">
                            {{ $errors->first('training') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.attendance.fields.training_helper') }}</span>
                </div>
                <div class="form-group">
                    <label>{{ trans('cruds.attendance.fields.present') }}</label>
                    @foreach(App\Models\Attendance::PRESENT_RADIO as $key => $label)
                        <div class="form-check {{ $errors->has('present') ? 'is-invalid' : '' }}">
                            <input class="form-check-input" type="radio" id="present_{{ $key }}" name="present" value="{{ $key }}" {{ old('present', $attendance->present) === (string) $key ? 'checked' : '' }}>
                            <label class="form-check-label" for="present_{{ $key }}">{{ $label }}</label>
                        </div>
                    @endforeach
                    @if($errors->has('present'))
                        <div class="invalid-feedback">
                            {{ $errors->first('present') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.attendance.fields.present_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="user">{{ trans('cruds.attendance.fields.user') }}</label>
                    <input class="form-control {{ $errors->has('user') ? 'is-invalid' : '' }}" type="text" name="user" id="user" value="{{ old('user', $attendance->user) }}">
                    @if($errors->has('user'))
                        <div class="invalid-feedback">
                            {{ $errors->first('user') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.attendance.fields.user_helper') }}</span>
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
