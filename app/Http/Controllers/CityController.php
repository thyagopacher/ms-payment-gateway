<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityRequest;
use App\Http\Requests\CityFilterRequest;
use App\Http\Resources\CityResource;
use App\Services\CityService;

class CityController extends Controller
{

    public function __construct(
        private CityService $service
    ) {

    }

    public function store(CityRequest $request)
    {
        $data = $request->validated();
        $res = $this->service->create($data);

        return response()->json($res);
    }

    public function update(CityRequest $request, int $id)
    {
        $data = $request->validated();
        $res = $this->service->update($data, $id);
        $success = !empty($res->id);

        return response()->json([
            'success' => $success,
            'msg' => $success ? __('api.updated_success') : __('api.updated_error')
        ]);
    }

    public function destroy(int $id)
    {
        $res = $this->service->delete($id);

        return response()->json([
            'success' => $res,
            'msg' => $res ? __('api.deleted_success') : __('api.deleted_error')
        ]);
    }

    public function show(int $id)
    {
        $res = $this->service->getCity($id);
        return new CityResource($res);
    }

    public function index(CityFilterRequest $request)
    {
        $filters = $request->validated();
        $data = $this->service->getCities($filters);

        return CityResource::collection($data);
    }

}
