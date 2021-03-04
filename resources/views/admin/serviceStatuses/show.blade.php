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


    <div class="card">
        <div class="card-header">
            {{ trans('global.relatedData') }}
        </div>
        <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
            <li class="nav-item">
                <a class="nav-link" href="#business_category_businesses" role="tab" data-toggle="tab">
                    {{ trans('cruds.business.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="business_category_businesses">
                @includeIf('admin.serviceStatuses.relationships.serviceStatusServices', ['services' => $serviceStatus->serviceStatusServices])
            </div>
        </div>
    </div>

@endsection
