<div class="card">
    <div class="card-header">
        {{ trans('cruds.assessment.title_singular') }} {{ trans('global.list') }}
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-userAssessments">
                <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.assessment.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.assessment.fields.user') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.email') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($assessments as $key => $assessment)
                    <tr data-entry-id="{{ $assessment->id }}">
                        <td>

                        </td>
                        <td>
                            {{ $assessment->id ?? '' }}
                        </td>
                        <td>
                            {{ $assessment->user->name ?? '' }}
                        </td>
                        <td>
                            {{ $assessment->user->email ?? '' }}
                        </td>

                        <td>
                            @can('assessment_show')
                                <a class="btn btn-xs btn-primary" href="{{ route('admin.assessments.show', $assessment->id) }}">
                                    {{ trans('global.view') }}
                                </a>
                            @endcan

                            @can('assessment_edit')
                                <a class="btn btn-xs btn-info" href="{{ route('admin.assessments.edit', $assessment->id) }}">
                                    {{ trans('global.edit') }}
                                </a>
                            @endcan

                            @can('assessment_delete')
                                <form action="{{ route('admin.assessments.destroy', $assessment->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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

{{--@section('scripts')--}}
{{--    @parent--}}
{{--    <script>--}}
{{--        $(function () {--}}
{{--            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)--}}
{{--                @can('assessment_delete')--}}
{{--            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'--}}
{{--            let deleteButton = {--}}
{{--                text: deleteButtonTrans,--}}
{{--                url: "{{ route('admin.assessments.massDestroy') }}",--}}
{{--                className: 'btn-danger',--}}
{{--                action: function (e, dt, node, config) {--}}
{{--                    var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {--}}
{{--                        return $(entry).data('entry-id')--}}
{{--                    });--}}

{{--                    if (ids.length === 0) {--}}
{{--                        alert('{{ trans('global.datatables.zero_selected') }}')--}}

{{--                        return--}}
{{--                    }--}}

{{--                    if (confirm('{{ trans('global.areYouSure') }}')) {--}}
{{--                        $.ajax({--}}
{{--                            headers: {'x-csrf-token': _token},--}}
{{--                            method: 'POST',--}}
{{--                            url: config.url,--}}
{{--                            data: { ids: ids, _method: 'DELETE' }})--}}
{{--                            .done(function () { location.reload() })--}}
{{--                    }--}}
{{--                }--}}
{{--            }--}}
{{--            dtButtons.push(deleteButton)--}}
{{--            @endcan--}}

{{--            $.extend(true, $.fn.dataTable.defaults, {--}}
{{--                orderCellsTop: true,--}}
{{--                order: [[ 1, 'desc' ]],--}}
{{--                pageLength: 100,--}}
{{--            });--}}
{{--            let table = $('.datatable-userAssessments:not(.ajaxTable)').DataTable({ buttons: dtButtons })--}}
{{--            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){--}}
{{--                $($.fn.dataTable.tables(true)).DataTable()--}}
{{--                    .columns.adjust();--}}
{{--            });--}}

{{--        })--}}

{{--    </script>--}}
{{--@endsection--}}