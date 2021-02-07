<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyServiceStatusRequest;
use App\Http\Requests\StoreServiceStatusRequest;
use App\Http\Requests\UpdateServiceStatusRequest;
use App\Models\ServiceStatus;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class ServiceStatusController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('service_status_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $serviceStatuses = ServiceStatus::all();

        return view('admin.serviceStatuses.index', compact('serviceStatuses'));
    }

    public function create()
    {
        abort_if(Gate::denies('service_status_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.serviceStatuses.create');
    }

    public function store(StoreServiceStatusRequest $request)
    {
        $serviceStatus = ServiceStatus::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $serviceStatus->id]);
        }

        return redirect()->route('admin.service-statuses.index');
    }

    public function edit(ServiceStatus $serviceStatus)
    {
        abort_if(Gate::denies('service_status_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.serviceStatuses.edit', compact('serviceStatus'));
    }

    public function update(UpdateServiceStatusRequest $request, ServiceStatus $serviceStatus)
    {
        $serviceStatus->update($request->all());

        return redirect()->route('admin.service-statuses.index');
    }

    public function show(ServiceStatus $serviceStatus)
    {
        abort_if(Gate::denies('service_status_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.serviceStatuses.show', compact('serviceStatus'));
    }

    public function destroy(ServiceStatus $serviceStatus)
    {
        abort_if(Gate::denies('service_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $serviceStatus->delete();

        return back();
    }

    public function massDestroy(MassDestroyServiceStatusRequest $request)
    {
        ServiceStatus::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('service_status_create') && Gate::denies('service_status_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new ServiceStatus();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
