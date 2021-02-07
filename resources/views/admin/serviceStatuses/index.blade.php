@extends('layouts.admin')
@section('content')
    @can('service_status_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.service-statuses.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.serviceStatus.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.serviceStatus.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-ServiceStatus">
                    <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.serviceStatus.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.serviceStatus.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.serviceStatus.fields.slug') }}
                        </th>
                        <th>
                            {{ trans('cruds.serviceStatus.fields.is_active') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($serviceStatuses as $key => $serviceStatus)
                        <tr data-entry-id="{{ $serviceStatus->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $serviceStatus->id ?? '' }}
                            </td>
                            <td>
                                {{ $serviceStatus->name ?? '' }}
                            </td>
                            <td>
                                {{ $serviceStatus->slug ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\ServiceStatus::IS_ACTIVE_RADIO[$serviceStatus->is_active] ?? '' }}
                            </td>
                            <td>
                                @can('service_status_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.service-statuses.show', $serviceStatus->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('service_status_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.service-statuses.edit', $serviceStatus->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('service_status_delete')
                                    <form action="{{ route('admin.service-statuses.destroy', $serviceStatus->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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



@endsection
@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
                @can('service_status_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.service-statuses.massDestroy') }}",
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
            let table = $('.datatable-ServiceStatus:not(.ajaxTable)').DataTable({ buttons: dtButtons })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })

    </script>
@endsection
