<?php

namespace App\Http\Requests;

use App\Models\ServiceHistory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateServiceHistoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('service_history_edit');
    }

    public function rules()
    {
        return [
            'service_id' => [
                'required',
                'integer',
            ],
            'content'    => [
                'required',
            ],
        ];
    }
}
