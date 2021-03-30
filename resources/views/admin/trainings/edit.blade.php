@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.training.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.trainings.update", [$training->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required">{{ trans('cruds.training.fields.is_active') }}</label>
                    <select class="form-control {{ $errors->has('is_active') ? 'is-invalid' : '' }}" name="is_active" id="is_active" required>
                        <option value disabled {{ old('is_active', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Models\Training::IS_ACTIVE_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('is_active', $training->is_active) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('is_active'))
                        <div class="invalid-feedback">
                            {{ $errors->first('is_active') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.training.fields.is_active_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="title">{{ trans('cruds.training.fields.title') }}</label>
                    <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $training->title) }}" required>
                    @if($errors->has('title'))
                        <div class="invalid-feedback">
                            {{ $errors->first('title') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.training.fields.title_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="description">{{ trans('cruds.training.fields.description') }}</label>
                    <textarea class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{!! old('description', $training->description) !!}</textarea>
                    @if($errors->has('description'))
                        <div class="invalid-feedback">
                            {{ $errors->first('description') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.training.fields.description_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="duration">{{ trans('cruds.training.fields.duration') }}</label>
                    <input class="form-control {{ $errors->has('duration') ? 'is-invalid' : '' }}" type="text" name="duration" id="duration" value="{{ old('duration', $training->duration) }}" required>
                    @if($errors->has('duration'))
                        <div class="invalid-feedback">
                            {{ $errors->first('duration') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.training.fields.duration_helper') }}</span>
                </div>



<div class="form-group">
                    <label class="required" for="start_date">{{ trans('cruds.training.fields.start_date') }}</label>
                    <input class="form-control date {{ $errors->has('start_date') ? 'is-invalid' : '' }}" type="text" name="start_date" id="start_date" value="{{ old('start_date', $training->start_date) }}" required>
                    @if($errors->has('start_date'))
                        <div class="invalid-feedback">
                            {{ $errors->first('start_date') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.training.fields.start_date_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="end_date">{{ trans('cruds.training.fields.end_date') }}</label>
                    <input class="form-control date {{ $errors->has('end_date') ? 'is-invalid' : '' }}" type="text" name="end_date" id="end_date" value="{{ old('end_date', $training->end_date) }}" required>
                    @if($errors->has('end_date'))
                        <div class="invalid-feedback">
                            {{ $errors->first('end_date') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.training.fields.end_date_helper') }}</span>
                </div>



                <div class="form-group">
                    <label for="outcome">{{ trans('cruds.training.fields.outcome') }}</label>
                    <textarea class="form-control ckeditor {{ $errors->has('outcome') ? 'is-invalid' : '' }}" name="outcome" id="outcome">{!! old('outcome', $training->outcome) !!}</textarea>
                    @if($errors->has('outcome'))
                        <div class="invalid-feedback">
                            {{ $errors->first('outcome') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.training.fields.outcome_helper') }}</span>
                </div>



                <div class="form-group">
                    <label class="required" for="users">{{ trans('cruds.training.fields.user') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('users') ? 'is-invalid' : '' }}" name="users[]" id="users" multiple required>
                        @foreach($users as $id => $user)
                            <option value="{{ $id }}" {{ (in_array($id, old('users', [])) || $training->users->contains($id)) ? 'selected' : '' }}>{{ $user }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('users'))
                        <div class="invalid-feedback">
                            {{ $errors->first('users') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.training.fields.user_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="users">Class Schedule</label>
                    <div class="row">

                        <div class="col-lg-12">
                            @foreach($training->days as $id => $day)
                            <div id="inputFormRow">
                                <div class="input-group mb-3">
                                    <select class="form-control m-input {{ $errors->has('day_id') ? 'is-invalid' : '' }} col-md-4" name="day_id[]" id="day_id" required>
                                        <option value disabled {{ old('day_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                        @foreach($days as $key => $label)
                                            <option value="{{ $key }}" {{ $day->pivot->day_id ==  $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <input class="form-control m-input timepicker {{ $errors->has('begin_time') ? 'is-invalid' : '' }} col-md-4" type="text" name="begin_time[]" id="begin_time" value="{{isset($day)?$day->pivot->begin_time:null}}" required>
                                    <input class="form-control m-input timepicker {{ $errors->has('close_time') ? 'is-invalid' : '' }} col-md-4" type="text" name="close_time[]" id="close_time" value="{{isset($day)?$day->pivot->close_time:null}}">
                                    <div class="input-group-append">
                                        <button id="removeRow" type="button" class="btn btn-danger">-</button>
                                    </div>
                                </div>
                            </div>
                          @endforeach
                            <div id="newRow"></div>
                            <button id="addRow" type="button" class="btn btn-info">+</button>
                        </div>
                    </div>

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
                                        xhr.open('POST', '/admin/trainings/ckmedia', true);
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
                                        data.append('crud_id', '{{ $training->id ?? 0 }}');
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

    <script type="text/javascript">
        // add row
        $("#addRow").click(function () {
            var html = '';
            html += '<div id="inputFormRow">';
            html += '<div class="input-group mb-3">';
            html +='    <select class="form-control m-input  col-md-4" name="day_id[]" id="day_id" required="">\n' +
                '        <option value="" disabled="" selected="">Please select</option>\n' +
                '        <option value="1">Saturday</option>\n' +
                '        <option value="2">Sunday</option>\n' +
                '        <option value="3">Monday</option>\n' +
                '        <option value="4">Tuesday</option>\n' +
                '        <option value="5">Wednesday</option>\n' +
                '        <option value="6">Thursday</option>\n' +
                '        <option value="7">Friday</option>\n' +
                '    </select>';
            html += '<input class="form-control m-input timepicker col-md-4" type="text" name="begin_time[]" required>';
            html += '<input class="form-control m-input timepicker col-md-4" type="text" name="close_time[]" required>';
            html += '<div class="input-group-append">';
            html += '<button id="removeRow" type="button" class="btn btn-danger">-</button>';
            html += '</div>';
            html += '</div>';

            $('#newRow').append(html);
        });

        // remove row
        $(document).on('click', '#removeRow', function () {
            $(this).closest('#inputFormRow').remove();
        });
    </script>
@endsection
