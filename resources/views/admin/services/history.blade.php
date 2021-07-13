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





                <section class="history">
                    <h2 class="history__title">Name of Service: {{$service->name}}</h2>
                    <p class="history__text">Service Description: {!! $service->description !!}</p>


          <div class="history__tree tree" style="float: left">
              @if(count($service->serviceHistories)>0)
              <span class="tree__central-line"></span>
              <span class="tree__big-point">History</span>

@foreach($service->serviceHistories as $key=> $history)
              <span class="tree__small-point {{(($key)/2==0)?"tree__small-point--middle-indent":""}}">
                  <span class="tree__event-block">
                       @if($history->user->profile)
                          <a href="{{ $history->user->profile->avatar->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $history->user->profile->avatar->getUrl('thumb') }}">
                                    </a>
                      @endif
                      <h3 class="tree__event-title">{{$history->user->name}}
{{--                          {!! (($key+1)/2==0)?"tree__small-point--middle-indent":""  !!}--}}
                      </h3>
                      <p class="tree__event-data">{{ "(".$history->created_at->diffForHumans().")" }}</p>
                      <p class="tree__event-text">{!! $history->content !!}</p>
                  </span>
              </span>
@endforeach
                  @else
                  <h4>No history of this service found</h4>

@endif


          </div>
                </section>




            </div>
        </div>
    </div>



@endsection

@push('style')
    <style>
        history {
            display: flex;
            flex-flow: column nowrap;
            justify-content: flex-start;
            align-items: center;
            margin: 3em auto;
            width: 100%;
            color: #3d3d3d;
            margin-bottom: 130px!important;
        }

        .history__title {
            position: relative;
            margin: 0.25em 0;
            width: 100%;
            font-size: 2.4em;
            font-weight: 300;
            line-height: 1;
            text-align: center;
        }
        .history__title:before {
            content: "oooooooooooooo";
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            height: 100%;
            font-size: 0.75em;
            white-space: nowrap;
            -webkit-text-decoration-line: underline;
            text-decoration-line: underline;
            -webkit-text-decoration-style: wavy;
            text-decoration-style: wavy;
            -webkit-text-decoration-color: #3d3d3d;
            text-decoration-color: #3d3d3d;
            text-underline-position: under;
            color: transparent;
        }

        .history__text {
            margin-top: 5em;
            margin-bottom: 0.5em;
            font-size: 0.95em;
            font-weight: 300;
            letter-spacing: 0.2px;
            line-height: 1.6;
            text-transform: none;
            font-variant: normal;
            color: #263238;
        }

        .history__tree {
            margin-top: 50px;
            width: 100%;
        }

        .tree {
            position: relative;
            display: flex;
            flex-flow: column nowrap;
            justify-content: flex-start;
            align-items: center;
        }

        .tree__big-point {
            margin-bottom: 70px;
            width: 70px;
            height: 70px;
            font-weight: 500;
            line-height: 70px;
            letter-spacing: 1px;
            text-align: center;
            border-radius: 50%;
            border: 2px solid #3d3d3d;
            background: #fff;
            z-index: 2;
        }

        .tree__small-point {
            position: relative;
            margin-bottom: 17px;
            width: 17px;
            height: 17px;
            border-radius: 50%;
            background: #3d3d3d;
            z-index: 2;
        }

        .tree__small-point--middle-indent {
            margin-bottom: 180px;
        }

        .tree__small-point--big-indent {
            margin-bottom: 270px;
        }

        .tree__final-point {
            padding: 15px;
            width: 55px;
            height: 55px;
            color: #fff;
            fill: currentColor;
            border-radius: 50%;
            background: #3d3d3d;
            z-index: 2;
        }

        .tree__icon {
            width: 100%;
            height: 100%;
            -o-object-fit: cover;
            object-fit: cover;
            -o-object-position: center;
            object-position: center;
        }

        .tree__central-line {
            position: absolute;
            top: 0;
            width: 2px;
            height: 100%;
            background: #3d3d3d;
        }

        .tree__event-block {
            display: block;
            position: absolute;
            top: -20px;
            padding: 20px;
            width: 450px;
            border-radius: 2px;
            border: 2px solid #3d3d3d;
            background: #fff;
        }
        .tree__event-block:before, .tree__event-block:after {
            content: "";
            position: absolute;
            top: 26px;
            border-style: solid;
        }

        .tree__small-point:nth-child(odd) .tree__event-block {
            right: 35px;
            padding-right: 40px;
        }
        .tree__small-point:nth-child(odd) .tree__event-block:before, .tree__small-point:nth-child(odd) .tree__event-block:after {
            right: -12px;
            border-width: 13px 12px 0 0;
            border-color: #3d3d3d transparent transparent transparent;
        }
        .tree__small-point:nth-child(odd) .tree__event-block:after {
            top: 28px;
            right: -7px;
            border-width: 9px 8px 0 0;
            border-color: #fff transparent transparent transparent;
        }

        .tree__small-point:nth-child(even) .tree__event-block {
            left: 35px;
            padding-left: 40px;
        }
        .tree__small-point:nth-child(even) .tree__event-block:before, .tree__small-point:nth-child(even) .tree__event-block:after {
            left: -12px;
            border-width: 0 12px 13px 0;
            border-color: transparent #3d3d3d transparent transparent;
        }
        .tree__small-point:nth-child(even) .tree__event-block:after {
            top: 28px;
            left: -7px;
            border-width: 0 8px 9px 0;
            border-color: transparent #fff transparent transparent;
        }

        .tree__event-block--dark {
            color: #fff;
            background: #3d3d3d;
        }

        .tree__small-point:nth-child(odd) .tree__event-block--dark:after,
        .tree__small-point:nth-child(even) .tree__event-block--dark:after {
            border-color: transparent;
        }

        .tree__event-title {
            font-size: 0.9em;
            font-weight: 500;
            line-height: 1.5;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .tree__event-data {
            margin-top: 5px;
            font-size: 0.8em;
            font-weight: 500;
            line-height: 1;
        }

        .tree__event-text {
            margin-top: 15px;
            font-size: 0.85em;
            font-weight: 400;
            letter-spacing: 1px;
        }
        .history{  margin-bottom: 130px;}
    </style>
    @endpush
