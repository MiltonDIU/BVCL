<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CheckOwnershipPermission;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyBusinessRequest;
use App\Http\Requests\StoreBusinessRequest;
use App\Http\Requests\UpdateBusinessRequest;
use App\Models\Business;
use App\Models\BusinessCategory;
use App\Models\Setting;
use App\Models\Site;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class BusinessController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('business_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (auth()->user()->is_admin) {
            $businesses = Business::with(['business_categories', 'user'])->get();
        } else {
            $businesses =  Business::with(['business_categories', 'user'])->where('user_id',auth()->id())->get();
        }

        return view('admin.businesses.index', compact('businesses'));
    }

    public function create()
    {
        abort_if(Gate::denies('business_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $business_categories = BusinessCategory::all()->pluck('name', 'id');
        return view('admin.businesses.create', compact('business_categories'));
    }

    public function store(StoreBusinessRequest $request)
    {
        $data = $request->all();
        $data['user_id']=auth()->id();
        $business = Business::create($data);
        $business->business_categories()->sync($request->input('business_categories', []));

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $business->id]);
        }

        return redirect()->route('admin.businesses.index');
    }

    public function edit(Business $business)
    {
       abort_if(Gate::denies('business_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (!auth()->user()->is_admin) {
            $business =  Business::where('id',$business->id)->where('user_id',auth()->id())->get()->first();
            if ($business==null){
                return redirect('not-allowed');
            }
        }
        $business_categories = BusinessCategory::all()->pluck('name', 'id');
        $business->load('business_categories', 'user');

        return view('admin.businesses.edit', compact('business_categories', 'business'));
    }

    public function update(UpdateBusinessRequest $request, Business $business)
    {

        $data = $request->all();
        $data['user_id']=auth()->id();
        $business->update($data);
        $business->business_categories()->sync($request->input('business_categories', []));

        return redirect()->route('admin.businesses.index');
    }

    public function show(Business $business)
    {
        abort_if(Gate::denies('business_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (!auth()->user()->is_admin) {
            $business =  Business::where('id',$business->id)->where('user_id',auth()->id())->get()->first();
            if ($business==null){
                return redirect('not-allowed');
            }
        }
        $business->load('business_categories', 'user');

        return view('admin.businesses.show', compact('business'));
    }

    public function destroy(Business $business)
    {
        abort_if(Gate::denies('business_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $business->delete();

        return back();
    }

    public function massDestroy(MassDestroyBusinessRequest $request)
    {
        Business::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('business_create') && Gate::denies('business_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Business();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function checkOwner($business){
        if (!auth()->user()->is_admin) {
            $business =  Business::where('id',$business->id)->where('user_id',auth()->id())->get()->first();
            if ($business==null){
                return redirect('not-allowed');
            }
        }
    }
}
