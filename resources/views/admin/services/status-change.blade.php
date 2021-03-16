@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.service.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.service.service-status-change") }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="name"><h4>{{ trans('cruds.service.name_of_service') }}  {{$service->name}}</h4></label>
                    <input type="hidden" name="service_id" id="service_id" value="{{$service->id}}">
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.service.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="service_status_id">{{ trans('cruds.service.fields.service_status') }}</label>
                    <select class="form-control select2 {{ $errors->has('service_status') ? 'is-invalid' : '' }}" name="service_status_id" id="service_status_id" required>


    @foreach($service_statuses as $id => $service_status)
        <option value="{{ $id }}" {{ (old('service_status_id') ? old('service_status_id') : $service->service_status->id ?? '') == $id ? 'selected' : '' }}>{{ $service_status }}</option>
    @endforeach

                    </select>
                    @if($errors->has('service_status'))
                        <div class="invalid-feedback">
                            {{ $errors->first('service_status') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.service.fields.service_status_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="content">{{ trans('cruds.serviceHistory.fields.comments') }}</label>
                    <textarea class="form-control ckeditor {{ $errors->has('comments') ? 'is-invalid' : '' }}" name="comments" id="comments">{!! old('comments') !!}</textarea>
                    @if($errors->has('comments'))
                        <div class="invalid-feedback">
                            {{ $errors->first('comments') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.serviceHistory.fields.comments_helper') }}</span>
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
                                        xhr.open('POST', '/admin/services/ckmedia', true);
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
                                        data.append('crud_id', '{{ $service->id ?? 0 }}');
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

    <script>
        Dropzone.options.documentDropzone = {
            url: '{{ route('admin.services.storeMedia') }}',
            maxFilesize: 5, // MB
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 5
            },
            success: function (file, response) {
                $('form').find('input[name="document"]').remove()
                $('form').append('<input type="hidden" name="document" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="document"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                    @if(isset($service) && $service->document)
                var file = {!! json_encode($service->document) !!}
                        this.options.addedfile.call(this, file)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="document" value="' + file.file_name + '">')
                this.options.maxFiles = this.options.maxFiles - 1
                @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }
    </script>
@endsection
