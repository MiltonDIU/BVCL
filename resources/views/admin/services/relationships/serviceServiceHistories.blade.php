<div class="card">
    <div class="card-header">
        {{ trans('cruds.serviceHistory.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-serviceServiceHistories">
                <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.serviceHistory.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.serviceHistory.fields.user') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.email') }}
                    </th>
                    <th>
                        {{ trans('cruds.serviceHistory.fields.service') }}
                    </th>
                    <th>
                        {{ trans('cruds.serviceHistory.fields.document') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($serviceHistories as $key => $serviceHistory)
                    <tr data-entry-id="{{ $serviceHistory->id }}">
                        <td>

                        </td>
                        <td>
                            {{ $serviceHistory->id ?? '' }}
                        </td>
                        <td>
                            {{ $serviceHistory->user->name ?? '' }}
                        </td>
                        <td>
                            {{ $serviceHistory->user->email ?? '' }}
                        </td>
                        <td>
                            {{ $serviceHistory->service->name ?? '' }}
                        </td>
                        <td>
                            @foreach($serviceHistory->document as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endforeach
                        </td>
                        <td>
                            @can('service_history_show')
                                <a class="btn btn-xs btn-primary" href="{{ route('admin.service-histories.show', $serviceHistory->id) }}">
                                    {{ trans('global.view') }}
                                </a>
                            @endcan

                            @can('service_history_edit')
                                <a class="btn btn-xs btn-info" href="{{ route('admin.service-histories.edit', $serviceHistory->id) }}">
                                    {{ trans('global.edit') }}
                                </a>
                            @endcan

                            @can('service_history_delete')
                                <form action="{{ route('admin.service-histories.destroy', $serviceHistory->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
                @can('service_history_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.service-histories.massDestroy') }}",
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
            let table = $('.datatable-serviceServiceHistories:not(.ajaxTable)').DataTable({ buttons: dtButtons })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })

    </script>
@endsection
