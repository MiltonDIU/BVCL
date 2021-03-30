@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.training.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.trainings.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.training.fields.id') }}
                        </th>
                        <td>
                            {{ $training->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.training.fields.is_active') }}
                        </th>
                        <td>
                            {{ App\Models\Training::IS_ACTIVE_SELECT[$training->is_active] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.training.fields.title') }}
                        </th>
                        <td>
                            {{ $training->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.training.fields.description') }}
                        </th>
                        <td>
                            {!! $training->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.training.fields.duration') }}
                        </th>
                        <td>
                            {{ $training->duration }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.training.fields.start_date') }}
                        </th>
                        <td>
{{--                            {{ date("F 1, Y", strtotime("-6 months"))}}--}}
                            {{ $training->start_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.training.fields.outcome') }}
                        </th>
                        <td>
                            {!! $training->outcome !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.training.fields.schedule') }}
                        </th>
                        <td>
                        <table>
                            <tr>
                                <th>
                                    {{ trans('cruds.training.day') }}
                                </th>
                                <th>
                                    {{ trans('cruds.training.fields.begin_time') }}
                                </th>
                                <th>
                                    {{ trans('cruds.training.fields.close_time') }}
                                </th>
                            </tr>
                            @foreach($training->days as $day)
                                <tr>
                                    <td>{{$day->name}}</td>
                                    <td>{{$day->pivot->begin_time}}</td>
                                    <td>{{$day->pivot->close_time}}</td>
                                </tr>
                                @endforeach
                        </table>
                        </td>
                    </tr>

                    <tr>
                        <th>
                            Date with Day and Time
                        </th>
                        <td>
                        <table>
                            <tr>
                                <th>
                                    {{ trans('cruds.training.day') }}
                                </th>
                                <th>
                                    {{ trans('cruds.training.fields.begin_time') }}
                                </th>
                                <th>
                                    {{ trans('cruds.training.fields.close_time') }}
                                </th>
                                <th>
                                    Date
                                </th>
                            </tr>
                            @foreach($training->days as $day)
                                @for($i = strtotime($day->name, strtotime($training->start_date)); $i <= strtotime($training->end_date); $i = strtotime('+1 week', $i))
                                    <tr>

{{--                                    {{date('l Y-m-d', $i)}}--}}
                                        <td>{{date('l', $i)}}</td>
                                        <td>{{$day->pivot->begin_time}}</td>
                                        <td>{{$day->pivot->close_time}}</td>
                                        <td>{{date('d-m-Y', $i)}}</td>
                                    </tr>
                                @endfor

                            @endforeach
                        </table>









                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.training.fields.user') }}
                        </th>
                        <td>
                             @can('profile_show')
                                @foreach($training->users as $key => $user)
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.profiles.show', $user->id) }}">
                                       {{ $user->name }}
                                    </a>
                                @endforeach
                                @endcan
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.trainings.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    @can('training_apply_access')
    <div class="card">
        <div class="card-header">
            {{ trans('global.relatedData') }}
        </div>
        <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
            <li class="nav-item">
                <a class="nav-link" href="#training_training_applies" role="tab" data-toggle="tab">
                    {{ trans('cruds.trainingApply.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="training_training_applies">
                @includeIf('admin.trainings.relationships.trainingTrainingApplies', ['trainingApplies' => $training->trainingTrainingApplies])
            </div>
        </div>
    </div>
@endcan


@endsection
