<?php

namespace App\Http\Requests;

use App\Models\Business;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateBusinessRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('business_edit');
    }

    public function rules()
    {
        return [
            'name'                  => [
                'string',
                'max:200',
                'required',
            ],
            'business_categories.*' => [
                'integer',
            ],
            'business_categories'   => [
                'required',
                'array',
            ],
            'location'              => [
                'string',
                'nullable',
            ],
        ];
    }
}
