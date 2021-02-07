@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.businessCategory.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.business-categories.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.businessCategory.fields.id') }}
                        </th>
                        <td>
                            {{ $businessCategory->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.businessCategory.fields.name') }}
                        </th>
                        <td>
                            {{ $businessCategory->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.businessCategory.fields.short_name') }}
                        </th>
                        <td>
                            {{ $businessCategory->short_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.businessCategory.fields.is_active') }}
                        </th>
                        <td>
                            {{ App\Models\BusinessCategory::IS_ACTIVE_RADIO[$businessCategory->is_active] ?? '' }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.business-categories.index') }}">
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
                @includeIf('admin.businessCategories.relationships.businessCategoryBusinesses', ['businesses' => $businessCategory->businessCategoryBusinesses])
            </div>
        </div>
    </div>

@endsection
