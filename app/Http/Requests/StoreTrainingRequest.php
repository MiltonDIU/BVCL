<?php

namespace App\Http\Requests;

use App\Models\Training;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTrainingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('training_create');
    }

    public function rules()
    {
        return [
            'is_active'  => [
                'required',
            ],
            'title'      => [
                'string',
                'max:200',
                'required',
            ],
            'duration'   => [
                'string',
                'required',
            ],
            'start_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'schedule'   => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'users.*'    => [
                'integer',
            ],
            'users'      => [
                'required',
                'array',
            ],
        ];
    }
}
