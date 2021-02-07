<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBusinessCategoryRequest;
use App\Http\Requests\StoreBusinessCategoryRequest;
use App\Http\Requests\UpdateBusinessCategoryRequest;
use App\Models\BusinessCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BusinessCategoryController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('business_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $businessCategories = BusinessCategory::all();

        return view('admin.businessCategories.index', compact('businessCategories'));
    }

    public function create()
    {
        abort_if(Gate::denies('business_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.businessCategories.create');
    }

    public function store(StoreBusinessCategoryRequest $request)
    {
        $businessCategory = BusinessCategory::create($request->all());

        return redirect()->route('admin.business-categories.index');
    }

    public function edit(BusinessCategory $businessCategory)
    {
        abort_if(Gate::denies('business_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.businessCategories.edit', compact('businessCategory'));
    }

    public function update(UpdateBusinessCategoryRequest $request, BusinessCategory $businessCategory)
    {
        $businessCategory->update($request->all());

        return redirect()->route('admin.business-categories.index');
    }

    public function show(BusinessCategory $businessCategory)
    {
        abort_if(Gate::denies('business_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $businessCategory->load('businessCategoryBusinesses');

        return view('admin.businessCategories.show', compact('businessCategory'));
    }

    public function destroy(BusinessCategory $businessCategory)
    {
        abort_if(Gate::denies('business_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $businessCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyBusinessCategoryRequest $request)
    {
        BusinessCategory::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
