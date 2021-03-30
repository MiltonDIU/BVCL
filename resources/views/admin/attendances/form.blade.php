@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.attendance.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.attendances.store") }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="training_id">{{$trainings->title}}</label>

                </div>

                <hr>
                <div class="form-group ">
                    <div class="col-lg-3">
                    <label>{{}}</label>
                        </div>

                            @foreach(App\Models\Attendance::PRESENT_RADIO as $key => $label)
                                <div class="form-check {{ $errors->has('present') ? 'is-invalid' : '' }}">
                                    <input class="form-check-input" type="radio" id="present_{{ $key }}" name="present" value="{{ $key }}" {{ old('present', '1') === (string) $key ? 'checked' : '' }}>
                                    <label class="form-check-label" for="present_{{ $key }}">{{ $label }}</label>
                                </div>
                            @endforeach
                    <span class="help-block">{{ trans('cruds.attendance.fields.present_helper') }}</span>
                </div>



                <div class="row">
                    <div class="col-lg-12">
                        <div id="inputFormRow">
                            <div class="input-group mb-3">
                                <input type="text" name="user_id[]" class="form-control m-input" placeholder="Answer title" autocomplete="off">
                                <input type="text" name="training_id[]" class="form-control m-input" placeholder="Answer title" autocomplete="off">
                            </div>
                        </div>
                        <div id="newRow"></div>
                        <button id="addRow" type="button" class="btn btn-info">+</button>
                    </div>
                </div>






                <div class="form-group">
                    <label for="user">{{ trans('cruds.attendance.fields.user') }}</label>
                    <input class="form-control {{ $errors->has('user') ? 'is-invalid' : '' }}" type="text" name="user" id="user" value="{{ old('user', '') }}">
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
