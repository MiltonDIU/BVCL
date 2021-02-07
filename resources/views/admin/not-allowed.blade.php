@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.profile.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ URL::previous() }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
              <h3>Not allowed to edit this page</h3>
               
            </div>
        </div>
    </div>


@endsection
