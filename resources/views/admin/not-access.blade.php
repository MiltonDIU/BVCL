@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ URL::previous() }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>


                      <div class="row mb-2">
                          <div class="col-lg-12">
                              <div class="alert alert-success" role="alert">
                                  {!! $message !!}
                              </div>
                          </div>
                      </div>




            </div>
        </div>
    </div>


@endsection
