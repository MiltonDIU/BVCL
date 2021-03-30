@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.attendance.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.trainings.attendance.store") }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="training_id">{{$trainings->title}}</label>
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="inputFormRow">
                                <div class="input-group mb-3">
                                    <input hidden="text" name="training_id" value="{{$trainings->id}}" class="form-control m-input" placeholder="Answer title" autocomplete="off">
                                    <input type="hidden" name="event_date" value="{{date('Y-m-d')}}" class="form-control m-input" placeholder="Answer title" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class=" table-sm table-bordered table-striped table-hover datatable">
                        <thead>
                            <tr>
                                <th style="width: 85px">Students/Days</th>
{{--                                @foreach($trainings->days as $day)--}}
{{--                                    <th style="width: 5px">{{ $day->name }}</th>--}}
{{--                               @endforeach--}}

                                @php
                                $data= array();
                                @endphp
                                @foreach($trainings->days as $day)
                                    @for($i = strtotime($day->name, strtotime($trainings->start_date)); $i <= strtotime($trainings->end_date); $i = strtotime('+1 week', $i))
                                        @php
                                            array_push($data,[date('l', $i),date('d-m-Y', $i)]);
                                        @endphp
                                    @endfor
                                @endforeach

                                @php
                                    // Comparison function
                                    function date_compare($element1, $element2) {
                                        $datetime1 = strtotime($element1[1]);
                                        $datetime2 = strtotime($element2[1]);
                                        return $datetime1 - $datetime2;
                                    }
                                    // Sort the array
                                    usort($data, 'date_compare');
@endphp

                    @foreach($data as $day)
                    <th style="width: 5px">{{ $day[0] }}<br>{{ $day[1] }}</th>
                    @endforeach




                            </tr>
                        </thead>
                        <tbody>
                        @foreach($trainings->trainingTrainingApplies as $apply)
                            <tr>
                                <td>  {{$apply->user->name}}</td>
                                @foreach($data as $day)
                                   @if(strtotime(date('d-m-Y'))==strtotime($day[1]))
                                    <td style="width: 5px">
                                        <input
                                            type="checkbox"
                                            name="user_id[]"
                                            value="{{$apply->user->id}}"
                                            {{ \App\Models\Training::checkAttendance($trainings->id,$apply->user->id,date('Y-m-d',strtotime($day[1]))) ? 'checked' : '' }}
                                        >
                                    </td>
@else
                                        <td style="width: 5px">
                                            <input
                                                disabled
                                                type="checkbox"
                                                value=""
                      {{ \App\Models\Training::checkAttendance($trainings->id,$apply->user->id,date('Y-m-d',strtotime($day[1]))) ? 'checked' : '' }}
                                            >
                                        </td>
                                    @endif

                                @endforeach


                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
