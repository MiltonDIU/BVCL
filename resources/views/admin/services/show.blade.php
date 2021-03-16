@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.service.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.services.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.service.fields.id') }}
                        </th>
                        <td>
                            {{ $service->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.service.fields.user') }}
                        </th>
                        <td>

                            @can('profile_show')
                                <a class="btn btn-xs btn-primary" href="{{ route('admin.profiles.show', $service->user->id) }}">
                                    Go to  {{ $service->user->name ?? '' }} Profile
                                </a>

                            @endcan
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.service.fields.service_status') }}
                        </th>
                        <td>

                            @if(Gate::check('service_status_show') )
                                    <a class="badge badge-info" href="{{ route('admin.service-statuses.show', $service->service_status->id) }}">
                                        {{ $service->service_status->name ?? '' }}
                                    </a>
                            @else
                                    <span class="badge badge-info">    {{ $service->service_status->name ?? '' }}</span>
                            @endif



                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.service.fields.name') }}
                        </th>
                        <td>
                            {{ $service->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.service.fields.description') }}
                        </th>
                        <td>
                            {!! $service->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.service.fields.document') }}
                        </th>
                        <td>
                            @if($service->document)
                                <a href="{{ $service->document->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.services.index') }}">
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
                <a class="nav-link" href="#service_service_histories" role="tab" data-toggle="tab">
                    {{ trans('cruds.serviceHistory.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="service_service_histories">
                @includeIf('admin.services.relationships.serviceServiceHistories', ['serviceHistories' => $service->serviceHistories])
            </div>
        </div>
    </div>

@endsection
