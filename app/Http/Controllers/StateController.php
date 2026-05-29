<?php

namespace App\Http\Controllers;

use App\Http\Requests\StateRequest;
use App\Http\Requests\StateFilterRequest;
use App\Http\Resources\StateResource;
use App\Services\StateService;

class StateController extends Controller
{

    public function __construct(
        private StateService $service
    ) {

    }

    public function store(StateRequest $request)
    {
        $data = $request->validated();
        $res = $this->service->create($data);

        return response()->json($res);
    }

    public function update(StateRequest $request, int $id)
    {
        $data = $request->validated();
        $res = $this->service->update($data, $id);

        return response()->json([
            'success' => $res,
            'msg' => $res ? __('api.updated_success') : __('api.updated_error')
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
        $res = $this->service->getState($id);
        return new StateResource($res);
    }

    public function index(StateFilterRequest $request)
    {
        $filters = $request->validated();
        $data = $this->service->getStates($filters);
        return StateResource::collection($data);
    }

}
