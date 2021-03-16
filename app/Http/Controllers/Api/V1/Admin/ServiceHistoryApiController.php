<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreServiceHistoryRequest;
use App\Http\Requests\UpdateServiceHistoryRequest;
use App\Http\Resources\Admin\ServiceHistoryResource;
use App\Models\ServiceHistory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServiceHistoryApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('service_history_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ServiceHistoryResource(ServiceHistory::with(['user', 'service'])->get());
    }

    public function store(StoreServiceHistoryRequest $request)
    {
        $serviceHistory = ServiceHistory::create($request->all());

        if ($request->input('document', false)) {
            $serviceHistory->addMedia(storage_path('tmp/uploads/' . basename($request->input('document'))))->toMediaCollection('document');
        }

        return (new ServiceHistoryResource($serviceHistory))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ServiceHistory $serviceHistory)
    {
        abort_if(Gate::denies('service_history_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ServiceHistoryResource($serviceHistory->load(['user', 'service']));
    }

    public function update(UpdateServiceHistoryRequest $request, ServiceHistory $serviceHistory)
    {
        $serviceHistory->update($request->all());

        if ($request->input('document', false)) {
            if (!$serviceHistory->document || $request->input('document') !== $serviceHistory->document->file_name) {
                if ($serviceHistory->document) {
                    $serviceHistory->document->delete();
                }

                $serviceHistory->addMedia(storage_path('tmp/uploads/' . basename($request->input('document'))))->toMediaCollection('document');
            }
        } elseif ($serviceHistory->document) {
            $serviceHistory->document->delete();
        }

        return (new ServiceHistoryResource($serviceHistory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ServiceHistory $serviceHistory)
    {
        abort_if(Gate::denies('service_history_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $serviceHistory->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
