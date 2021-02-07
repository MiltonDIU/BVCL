<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBusinessCategoryRequest;
use App\Http\Requests\UpdateBusinessCategoryRequest;
use App\Http\Resources\Admin\BusinessCategoryResource;
use App\Models\BusinessCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BusinessCategoryApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('business_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BusinessCategoryResource(BusinessCategory::all());
    }

    public function store(StoreBusinessCategoryRequest $request)
    {
        $businessCategory = BusinessCategory::create($request->all());

        return (new BusinessCategoryResource($businessCategory))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(BusinessCategory $businessCategory)
    {
        abort_if(Gate::denies('business_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BusinessCategoryResource($businessCategory);
    }

    public function update(UpdateBusinessCategoryRequest $request, BusinessCategory $businessCategory)
    {
        $businessCategory->update($request->all());

        return (new BusinessCategoryResource($businessCategory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(BusinessCategory $businessCategory)
    {
        abort_if(Gate::denies('business_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $businessCategory->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
