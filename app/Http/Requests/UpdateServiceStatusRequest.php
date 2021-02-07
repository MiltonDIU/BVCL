<?php

namespace App\Http\Requests;

use App\Models\ServiceStatus;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateServiceStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('service_status_edit');
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
                'unique:service_statuses,name,' . request()->route('service_status')->id,
            ],
            'slug'    => [
                'string',
                'min:2',
                'max:50',
                'required',
                'unique:service_statuses,slug,' . request()->route('service_status')->id,
            ],
            'message' => [
                'required',
            ],
        ];
    }
}
