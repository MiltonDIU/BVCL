@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.profile.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("profile.my-profile.update", [auth()->id()]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="title">{{ trans('cruds.user.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" required>
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label class="required" for="title">{{ trans('cruds.user.fields.email') }}</label>
                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" disabled required>
                    @if($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label class="required"  for="mobile">{{ trans('cruds.profile.fields.mobile') }}</label>
                    <input class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}" type="text" name="mobile" id="mobile" required value="{{ old('mobile', auth()->user()->profile!=null?auth()->user()->profile->mobile:"") }}">
                    @if($errors->has('mobile'))
                        <div class="invalid-feedback">
                            {{ $errors->first('mobile') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.profile.fields.mobile_helper') }}</span>
                </div>
                <div class="required" class="form-group">
                    <label>{{ trans('cruds.profile.fields.gender') }}</label>
                    @foreach(App\Models\Profile::GENDER_RADIO as $key => $label)
                        <div class="form-check {{ $errors->has('gender') ? 'is-invalid' : '' }}">
                            <input class="form-check-input" type="radio" id="gender_{{ $key }}" name="gender" value="{{ $key }}" {{ old('gender', auth()->user()->profile!=null?auth()->user()->profile->gender:"") === (string) $key ? 'checked' : '' }}>
                            <label class="form-check-label" for="gender_{{ $key }}">{{ $label }}</label>
                        </div>
                    @endforeach
                    @if($errors->has('gender'))
                        <div class="invalid-feedback">
                            {{ $errors->first('gender') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.profile.fields.gender_helper') }}</span>
                </div>


                <div class="form-group">
                    <label class="required" for="country_id">{{ trans('cruds.profile.fields.country') }}</label>
                    <select class="form-control select2 {{ $errors->has('country') ? 'is-invalid' : '' }}" name="country_id" id="country_id" required>
                        @foreach($countries as $id => $country)
                            <option value="{{ $id }}" {{(((auth()->user()->profile)?auth()->user()->profile->country->id:'')===$id)?'selected' :''}}>{{ $country }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('country'))
                        <div class="invalid-feedback">
                            {{ $errors->first('country') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.profile.fields.country_helper') }}</span>
                </div>


                <div class="form-group">
                    <label class="required" for="reference_name">{{ trans('cruds.profile.fields.reference_name') }}</label>
                    <input class="form-control {{ $errors->has('reference_name') ? 'is-invalid' : '' }}" required type="text" name="reference_name" id="reference_name" value="{{ old('reference_name', auth()->user()->profile!=null?auth()->user()->profile->reference_name:"") }}">
                    @if($errors->has('reference_name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('reference_name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.profile.fields.reference_name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="reference_mobile">{{ trans('cruds.profile.fields.reference_mobile') }}</label>
                    <input class="form-control {{ $errors->has('reference_mobile') ? 'is-invalid' : '' }}" type="text" name="reference_mobile" id="reference_mobile" value="{{ old('reference_mobile', auth()->user()->profile!=null?auth()->user()->profile->reference_mobile:"") }}">
                    @if($errors->has('reference_mobile'))
                        <div class="invalid-feedback">
                            {{ $errors->first('reference_mobile') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.profile.fields.reference_mobile_helper') }}</span>
                </div>


                <div class="form-group">
                    <label for="avatar">{{ trans('cruds.profile.fields.avatar') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('avatar') ? 'is-invalid' : '' }}" id="avatar-dropzone">
                    </div>
                    @if($errors->has('avatar'))
                        <div class="invalid-feedback">
                            {{ $errors->first('avatar') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.profile.fields.avatar_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="about">{{ trans('cruds.profile.fields.about') }}</label>
                    <textarea class="form-control ckeditor {{ $errors->has('about') ? 'is-invalid' : '' }}" name="about" id="about">{!! old('about', auth()->user()->profile!=null?auth()->user()->profile->about:"") !!}</textarea>
                    @if($errors->has('about'))
                        <div class="invalid-feedback">
                            {{ $errors->first('about') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.profile.fields.about_helper') }}</span>
                </div>



                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.update') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        Dropzone.options.avatarDropzone = {
            url: '{{ route('admin.profiles.storeMedia') }}',
            maxFilesize: 1, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 1,
                width: 1020,
                height: 1020
            },
            success: function (file, response) {
                $('form').find('input[name="avatar"]').remove()
                $('form').append('<input type="hidden" name="avatar" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="avatar"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                    @if(isset(auth()->user()->profile) && auth()->user()->profile->avatar)
                var file = {!! json_encode(auth()->user()->profile->avatar) !!}
                        this.options.addedfile.call(this, file)
                this.options.thumbnail.call(this, file, file.preview)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="avatar" value="' + file.file_name + '">')
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
                                        xhr.open('POST', '/admin/profiles/ckmedia', true);
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
                                        data.append('crud_id', '{{1 ?? 0 }}');
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
