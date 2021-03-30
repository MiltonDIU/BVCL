<div class="card">
    <div class="card-header">
        {{ trans('cruds.trainingApply.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-trainingTrainingApplies">
                <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.trainingApply.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.trainingApply.fields.training') }}
                    </th>
                    <th>
                        {{ trans('cruds.training.fields.title') }}
                    </th>
                    <th>
                        {{ trans('cruds.trainingApply.fields.user') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.email') }}
                    </th>
                    <th>
                        {{ trans('cruds.trainingApply.fields.is_status') }}
                    </th>
                    <th>
                        {{ trans('cruds.trainingApply.fields.who_give_permission') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($trainingApplies as $key => $trainingApply)
                    <tr data-entry-id="{{ $trainingApply->id }}">
                        <td>

                        </td>
                        <td>
                            {{ $trainingApply->id ?? '' }}
                        </td>
                        <td>
                            {{ $trainingApply->training->title ?? '' }}
                        </td>
                        <td>
                            {{ $trainingApply->training->title ?? '' }}
                        </td>
                        <td>
                            {{ $trainingApply->user->name ?? '' }}
                        </td>
                        <td>
                            {{ $trainingApply->user->email ?? '' }}
                        </td>
                        <td>
                            {{ App\Models\TrainingApply::IS_STATUS_SELECT[$trainingApply->is_status] ?? 'Pending' }}
                        </td>
                        <td>
                            {{ $trainingApply->who_give_permission ?\App\Models\TrainingApply::whoApproved($trainingApply->who_give_permission):'Not define' }}
                        </td>
                        <td>

                            @can('training_approved')
                                <form action="{{ route('admin.trainings.approved', $trainingApply->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;border: 1px solid gray;padding: 2px;
line-height: 30px;box-shadow: 0px 1px palegreen;">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="id" value="{{ $trainingApply->id }}">
                                    <select class="{{ $errors->has('is_status') ? 'is-invalid' : '' }}" name="is_status" id="is_status" required>
                                        <option value disabled {{ old('is_status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                        @foreach(App\Models\TrainingApply::IS_STATUS_SELECT as $key => $label)
                                            <option value="{{ $key }}" {{ old('is_status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <input type="submit" class="btn btn-xs btn-dark" value="{{ trans('global.apply') }}">
                                </form>
                            @endcan

                            @can('training_apply_show')
                                <a class="btn btn-xs btn-primary" href="{{ route('admin.training-applies.show', $trainingApply->id) }}">
                                    {{ trans('global.view') }}
                                </a>
                            @endcan

                            @can('training_apply_edit')
                                <a class="btn btn-xs btn-info" href="{{ route('admin.training-applies.edit', $trainingApply->id) }}">
                                    {{ trans('global.edit') }}
                                </a>
                            @endcan

                            @can('training_apply_delete')
                                <form action="{{ route('admin.training-applies.destroy', $trainingApply->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                </form>
                            @endcan

                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
                @can('training_apply_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.training-applies.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                        return $(entry).data('entry-id')
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}')

                        return
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                            headers: {'x-csrf-token': _token},
                            method: 'POST',
                            url: config.url,
                            data: { ids: ids, _method: 'DELETE' }})
                            .done(function () { location.reload() })
                    }
                }
            }
            dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [[ 1, 'desc' ]],
                pageLength: 100,
            });
            let table = $('.datatable-trainingTrainingApplies:not(.ajaxTable)').DataTable({ buttons: dtButtons })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })

    </script>
@endsection
