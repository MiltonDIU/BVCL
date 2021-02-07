<?php

namespace App\Http\Requests;

use App\Models\BusinessCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateBusinessCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('business_category_edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'       => [
                'string',
                'required',
            ],
            'short_name' => [
                'string',
                'nullable',
            ],
            'is_active'  => [
                'required',
            ],
        ];
    }
}
