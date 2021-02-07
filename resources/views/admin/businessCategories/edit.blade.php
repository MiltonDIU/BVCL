@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.businessCategory.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.business-categories.update", [$businessCategory->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.businessCategory.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $businessCategory->name) }}" required>
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.businessCategory.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="short_name">{{ trans('cruds.businessCategory.fields.short_name') }}</label>
                    <input class="form-control {{ $errors->has('short_name') ? 'is-invalid' : '' }}" type="text" name="short_name" id="short_name" value="{{ old('short_name', $businessCategory->short_name) }}">
                    @if($errors->has('short_name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('short_name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.businessCategory.fields.short_name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required">{{ trans('cruds.businessCategory.fields.is_active') }}</label>
                    @foreach(App\Models\BusinessCategory::IS_ACTIVE_RADIO as $key => $label)
                        <div class="form-check {{ $errors->has('is_active') ? 'is-invalid' : '' }}">
                            <input class="form-check-input" type="radio" id="is_active_{{ $key }}" name="is_active" value="{{ $key }}" {{ old('is_active', $businessCategory->is_active) === (string) $key ? 'checked' : '' }} required>
                            <label class="form-check-label" for="is_active_{{ $key }}">{{ $label }}</label>
                        </div>
                    @endforeach
                    @if($errors->has('is_active'))
                        <div class="invalid-feedback">
                            {{ $errors->first('is_active') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.businessCategory.fields.is_active_helper') }}</span>
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
