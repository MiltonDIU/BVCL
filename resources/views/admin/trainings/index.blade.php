@extends('layouts.admin')
@section('content')
    @can('training_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.trainings.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.training.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.training.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Training">
                    <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.training.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.training.fields.is_active') }}
                        </th>
                        <th>
                            {{ trans('cruds.training.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.training.fields.duration') }}
                        </th>
                        <th>
                            {{ trans('cruds.training.fields.start_date') }}
                        </th>

                        <th>
                            {{ trans('cruds.training.fields.user') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($trainings as $key => $training)
                        <tr data-entry-id="{{ $training->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $training->id ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Training::IS_ACTIVE_SELECT[$training->is_active] ?? '' }}
                            </td>
                            <td>
                                {{ $training->title ?? '' }}
                            </td>
                            <td>
                                {{ $training->duration ?? '' }}
                            </td>
                            <td>
                                {{ $training->start_date ?? '' }}
                            </td>
                            <td>
                                @foreach($training->users as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>

                                @can('attendance_access')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.trainings.attendance',$training->id) }}">
                                        {{ trans('global.attendance') }}
                                    </a>
                                @endcan

                                @can('training_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.trainings.show', $training->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('training_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.trainings.edit', $training->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('training_delete')
                                    <form action="{{ route('admin.trainings.destroy', $training->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan
                                    @can('training_apply')
                                        <form action="{{ route('admin.trainings.apply', $training->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="training_id" value="{{ $training->id }}">
                                            @if(\App\Models\Training::isApplied($training->id,auth()->id())==false)
                                                <input type="submit" class="btn btn-xs btn-dark" value="{{ trans('global.apply') }}">
                                            @else
                                                {{ trans('global.alreadyApply') }}
                                            @endif

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
                @can('training_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.trainings.massDestroy') }}",
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
            let table = $('.datatable-Training:not(.ajaxTable)').DataTable({ buttons: dtButtons })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })

    </script>
@endsection
