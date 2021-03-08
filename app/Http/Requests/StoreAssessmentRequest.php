<?php

namespace App\Http\Requests;

use App\Models\Assessment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAssessmentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('assessment_create');
    }

    public function rules()
    {
        return [
//
//            'questions.*' => [
//                'integer',
//            ],
//            'questions'   => [
//                'required',
//                'array',
//            ],
//            'answers.*'   => [
//                'integer',
//            ],
//            'answers'     => [
//                'required',
//                'array',
//            ],
        ];
    }
}
