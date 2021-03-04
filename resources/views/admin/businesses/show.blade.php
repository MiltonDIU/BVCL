@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.business.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.businesses.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.business.fields.id') }}
                        </th>
                        <td>
                            {{ $business->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.business.fields.name') }}
                        </th>
                        <td>
                            {{ $business->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.business.fields.summary') }}
                        </th>
                        <td>
                            {!! $business->summary !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.business.fields.business_category') }}
                        </th>
                        <td>
@if(Gate::check('service_status_access') )
   @foreach($business->business_categories as $key => $business_category)
<a class="badge badge-info" href="{{ route('admin.business-categories.show', $business_category->id) }}">
    <span >{{ $business_category->name }}</span>
</a>
   @endforeach
    @else
        @foreach($business->business_categories as $key => $business_category)
                <span class="badge badge-info">{{ $business_category->name }}</span>
        @endforeach
@endif




</td>
</tr>
<tr>
<th>
   {{ trans('cruds.business.fields.user') }}
</th>
<td>
   @can('profile_show')
       <a class="btn btn-xs btn-primary" href="{{ route('admin.profiles.show', $business->user->id) }}">
          Go to  {{ $business->user->name ?? '' }} Profile
       </a>

       @endcan
</td>
</tr>
<tr>
<th>
   {{ trans('cruds.business.fields.location') }}
</th>
<td>
   {{ $business->location }}
</td>
</tr>
</tbody>
</table>
<div class="form-group">
<a class="btn btn-default" href="{{ route('admin.businesses.index') }}">
{{ trans('global.back_to_list') }}
</a>
</div>
</div>
</div>
</div>



@endsection
