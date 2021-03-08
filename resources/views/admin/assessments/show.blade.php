@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.assessment.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.assessments.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.assessment.fields.id') }}
                        </th>
                        <td>
                            {{ $assessment->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.assessment.fields.user') }}
                        </th>
                        <td>
                            {{ $assessment->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.assessment.fields.question') }}
                        </th>
                        <td>

                            {{\App\Models\Question::assessment($questions)}}

{{--                            --}}
{{--                            <table>--}}
{{--                                <tr>--}}
{{--                                    <td>Question</td>--}}
{{--                                    <td>Answer List and Marks</td>--}}
{{--                                    <td>My Answer Marks</td>--}}
{{--                                </tr>--}}
{{--                                --}}
{{--                                --}}
{{--                                --}}
{{--                                --}}
{{--                                @foreach($questions as $key=> $question)--}}
{{--                                    <tr>--}}
{{--                                    <td>{{\App\Models\Question::findQuestion($key)->title}}</td>--}}
{{--                                        <td>--}}
{{--                                            <table>--}}
{{--                                                @foreach(\App\Models\Question::findQuestion($key)->answers as $answer)--}}
{{--                                                    <tr>--}}
{{--                                                        <td>{{$answer->title}}</td>--}}
{{--                                                        <td>{{$answer->mark}}</td>--}}
{{--                                                    </tr>--}}
{{--                                                @endforeach--}}

{{--                                            </table>--}}
{{--                                        </td>--}}
{{--<td>--}}
{{--    {{\App\Models\Question::findAnswer($key,$question)->title}}<br>--}}
{{--       {{\App\Models\Question::findAnswer($key,$question)->mark}}--}}
{{--</td>--}}
{{--                                    </tr>--}}
{{--                                @endforeach--}}

{{--                            </table>--}}

{{--                            {{ $assessment->content ?? '' }}--}}
                        </td>
{{--                        <td>--}}
{{--                            @foreach($assessment->questions as $key => $question)--}}
{{--                                <span class="label label-info">{{ $question->title }}</span>--}}
{{--                            @endforeach--}}
{{--                        </td>--}}
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.assessments.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>



@endsection
