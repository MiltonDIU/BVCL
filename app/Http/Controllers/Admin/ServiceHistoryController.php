<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyServiceHistoryRequest;
use App\Http\Requests\StoreServiceHistoryRequest;
use App\Http\Requests\UpdateServiceHistoryRequest;
use App\Models\Service;
use App\Models\ServiceHistory;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ServiceHistoryController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('service_history_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ServiceHistory::with(['user', 'service'])->select(sprintf('%s.*', (new ServiceHistory)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'service_history_show';
                $editGate      = 'service_history_edit';
                $deleteGate    = 'service_history_delete';
                $crudRoutePart = 'service-histories';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->editColumn('user.email', function ($row) {
                return $row->user ? (is_string($row->user) ? $row->user : $row->user->email) : '';
            });
            $table->addColumn('service_name', function ($row) {
                return $row->service ? $row->service->name : '';
            });

            $table->editColumn('document', function ($row) {
                if (!$row->document) {
                    return '';
                }

                $links = [];

                foreach ($row->document as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>';
                }

                return implode(', ', $links);
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'service', 'document']);

            return $table->make(true);
        }

        return view('admin.serviceHistories.index');
    }

    public function create()
    {
        abort_if(Gate::denies('service_history_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (auth()->user()->is_admin) {
            $services = Service::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        } else {
            $services = Service::where('user_id',auth()->id())->get()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        }

        //$services = Service::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.serviceHistories.create', compact('services'));
    }

    public function store(StoreServiceHistoryRequest $request)
    {

        $data = $request->all();
        $data['user_id'] =  auth()->id();
        $serviceHistory = ServiceHistory::create($data);

        foreach ($request->input('document', []) as $file) {
            $serviceHistory->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('document');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $serviceHistory->id]);
        }

        return redirect()->route('admin.service-histories.index');
    }

    public function edit(ServiceHistory $serviceHistory)
    {
        abort_if(Gate::denies('service_history_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $services = Service::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $serviceHistory->load('user', 'service');

        return view('admin.serviceHistories.edit', compact( 'services', 'serviceHistory'));
    }

    public function update(UpdateServiceHistoryRequest $request, ServiceHistory $serviceHistory)
    {
        $serviceHistory->update($request->all());

        if (count($serviceHistory->document) > 0) {
            foreach ($serviceHistory->document as $media) {
                if (!in_array($media->file_name, $request->input('document', []))) {
                    $media->delete();
                }
            }
        }

        $media = $serviceHistory->document->pluck('file_name')->toArray();

        foreach ($request->input('document', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $serviceHistory->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('document');
            }
        }

        return redirect()->route('admin.service-histories.index');
    }

    public function show(ServiceHistory $serviceHistory)
    {
        abort_if(Gate::denies('service_history_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $serviceHistory->load('user', 'service');

        return view('admin.serviceHistories.show', compact('serviceHistory'));
    }

    public function destroy(ServiceHistory $serviceHistory)
    {
        abort_if(Gate::denies('service_history_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $serviceHistory->delete();

        return back();
    }

    public function massDestroy(MassDestroyServiceHistoryRequest $request)
    {
        ServiceHistory::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('service_history_create') && Gate::denies('service_history_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new ServiceHistory();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
