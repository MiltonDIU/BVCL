@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.serviceStatus.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.service-statuses.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.serviceStatus.fields.id') }}
                        </th>
                        <td>
                            {{ $serviceStatus->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.serviceStatus.fields.name') }}
                        </th>
                        <td>
                            {{ $serviceStatus->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.serviceStatus.fields.slug') }}
                        </th>
                        <td>
                            {{ $serviceStatus->slug }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.serviceStatus.fields.is_active') }}
                        </th>
                        <td>
                            {{ App\Models\ServiceStatus::IS_ACTIVE_RADIO[$serviceStatus->is_active] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.serviceStatus.fields.message') }}
                        </th>
                        <td>
                            {!! $serviceStatus->message !!}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.service-statuses.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>



@endsection
