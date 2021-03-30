<?php

namespace App\Http\Requests;

use App\Models\TrainingApply;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTrainingApplyRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('training_apply_create');
    }

    public function rules()
    {
        return [
            'training_id'             => [
                'required',
                'integer',
            ],
        ];
    }
}
