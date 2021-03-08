<?php

namespace App\Http\Requests;

use App\Models\Assessment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAssessmentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('assessment_edit');
    }

    public function rules()
    {
        return [
            'user_id'     => [
                'required',
                'integer',
            ],
            'questions.*' => [
                'integer',
            ],
            'questions'   => [
                'required',
                'array',
            ],
            'answers.*'   => [
                'integer',
            ],
            'answers'     => [
                'required',
                'array',
            ],
        ];
    }
}
