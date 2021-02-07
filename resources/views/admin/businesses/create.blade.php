@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.business.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.businesses.store") }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.business.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.business.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="summary">{{ trans('cruds.business.fields.summary') }}</label>
                    <textarea class="form-control ckeditor {{ $errors->has('summary') ? 'is-invalid' : '' }}" name="summary" id="summary">{!! old('summary') !!}</textarea>
                    @if($errors->has('summary'))
                        <div class="invalid-feedback">
                            {{ $errors->first('summary') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.business.fields.summary_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="business_categories">{{ trans('cruds.business.fields.business_category') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('business_categories') ? 'is-invalid' : '' }}" name="business_categories[]" id="business_categories" multiple required>
                        @foreach($business_categories as $id => $business_category)
                            <option value="{{ $id }}" {{ in_array($id, old('business_categories', [])) ? 'selected' : '' }}>{{ $business_category }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('business_categories'))
                        <div class="invalid-feedback">
                            {{ $errors->first('business_categories') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.business.fields.business_category_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="location">{{ trans('cruds.business.fields.location') }}</label>
                    <input class="form-control {{ $errors->has('location') ? 'is-invalid' : '' }}" type="text" name="location" id="location" value="{{ old('location', '') }}">
                    @if($errors->has('location'))
                        <div class="invalid-feedback">
                            {{ $errors->first('location') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.business.fields.location_helper') }}</span>
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

@section('scripts')
    <script>
        $(document).ready(function () {
            function SimpleUploadAdapter(editor) {
                editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
                    return {
                        upload: function() {
                            return loader.file
                                .then(function (file) {
                                    return new Promise(function(resolve, reject) {
                                        // Init request
                                        var xhr = new XMLHttpRequest();
                                        xhr.open('POST', '/admin/businesses/ckmedia', true);
                                        xhr.setRequestHeader('x-csrf-token', window._token);
                                        xhr.setRequestHeader('Accept', 'application/json');
                                        xhr.responseType = 'json';

                                        // Init listeners
                                        var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                                        xhr.addEventListener('error', function() { reject(genericErrorText) });
                                        xhr.addEventListener('abort', function() { reject() });
                                        xhr.addEventListener('load', function() {
                                            var response = xhr.response;

                                            if (!response || xhr.status !== 201) {
                                                return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                                            }

                                            $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                                            resolve({ default: response.url });
                                        });

                                        if (xhr.upload) {
                                            xhr.upload.addEventListener('progress', function(e) {
                                                if (e.lengthComputable) {
                                                    loader.uploadTotal = e.total;
                                                    loader.uploaded = e.loaded;
                                                }
                                            });
                                        }

                                        // Send request
                                        var data = new FormData();
                                        data.append('upload', file);
                                        data.append('crud_id', '{{ $business->id ?? 0 }}');
                                        xhr.send(data);
                                    });
                                })
                        }
                    };
                }
            }

            var allEditors = document.querySelectorAll('.ckeditor');
            for (var i = 0; i < allEditors.length; ++i) {
                ClassicEditor.create(
                    allEditors[i], {
                        extraPlugins: [SimpleUploadAdapter]
                    }
                );
            }
        });
    </script>

@endsection
