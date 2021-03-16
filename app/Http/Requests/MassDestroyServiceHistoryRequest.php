<?php

namespace App\Http\Requests;

use App\Models\ServiceHistory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyServiceHistoryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('service_history_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:service_histories,id',
        ];
    }
}
