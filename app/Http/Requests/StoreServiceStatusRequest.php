<?php

namespace App\Http\Requests;

use App\Models\ServiceStatus;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreServiceStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('service_status_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'    => [
                'string',
                'min:2',
                'max:50',
                'required',
                'unique:service_statuses',
            ],
            'slug'    => [
                'string',
                'min:2',
                'max:50',
                'required',
                'unique:service_statuses',
            ],
            'message' => [
                'required',
            ],
        ];
    }
}
