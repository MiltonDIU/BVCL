<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreServiceStatusRequest;
use App\Http\Requests\UpdateServiceStatusRequest;
use App\Http\Resources\Admin\ServiceStatusResource;
use App\Models\ServiceStatus;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServiceStatusApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('service_status_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ServiceStatusResource(ServiceStatus::all());
    }

    public function store(StoreServiceStatusRequest $request)
    {
        $serviceStatus = ServiceStatus::create($request->all());

        return (new ServiceStatusResource($serviceStatus))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ServiceStatus $serviceStatus)
    {
        abort_if(Gate::denies('service_status_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ServiceStatusResource($serviceStatus);
    }

    public function update(UpdateServiceStatusRequest $request, ServiceStatus $serviceStatus)
    {
        $serviceStatus->update($request->all());

        return (new ServiceStatusResource($serviceStatus))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ServiceStatus $serviceStatus)
    {
        abort_if(Gate::denies('service_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $serviceStatus->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
