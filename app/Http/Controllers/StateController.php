<?php

namespace App\Http\Controllers;

use App\Http\Requests\StateRequest;
use App\Http\Requests\StateFilterRequest;
use App\Http\Resources\StateResource;
use App\Services\StateService;
use OpenApi\Attributes as OA;

class StateController extends Controller
{

    public function __construct(
        private StateService $service
    ) {

    }

    #[OA\Post(
        path: "/api/state",
        summary: "Create state",
        tags: ['State'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'State created successfully'
            )
        ]
    )]
    public function store(StateRequest $request)
    {
        $data = $request->validated();
        $res = $this->service->create($data);

        return response()->json($res);
    }

    #[OA\Put(
        path: "/api/state/{id}",
        summary: "Update state",
        tags: ['State'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'State updated successfully'
            )
        ]
    )]
    public function update(StateRequest $request, int $id)
    {
        $data = $request->validated();
        $res = $this->service->update($data, $id);
        $success = !empty($res->id);

        return response()->json([
            'success' => $success,
            'msg' => $success ? __('api.updated_success') : __('api.updated_error')
        ]);
    }

    #[OA\Delete(
        path: "/api/state/{id}",
        summary: "Delete state by ID",
        tags: ['State'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'State deleted successfully'
            ),
            new OA\Response(
                response: 404,
                description: 'State Not Found'
            )
        ]
    )]
    public function destroy(int $id)
    {
        $res = $this->service->delete($id);

        return response()->json([
            'success' => $res,
            'msg' => $res ? __('api.deleted_success') : __('api.deleted_error')
        ]);
    }

    #[OA\Get(
        path: "/api/state/{id}",
        summary: "Get state by ID",
        tags: ['State'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'State Found'
            ),
            new OA\Response(
                response: 404,
                description: 'State Not Found'
            )
        ]
    )]
    public function show(int $id)
    {
        $res = $this->service->getState($id);
        return new StateResource($res);
    }

    #[OA\Get(
        path: "/api/state",
        summary: "Get all states with filters",
        tags: ['State'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'State Found'
            ),
            new OA\Response(
                response: 404,
                description: 'State Not Found'
            )
        ]
    )]
    public function index(StateFilterRequest $request)
    {
        $filters = $request->validated();
        $data = $this->service->getStates($filters);
        return StateResource::collection($data);
    }

}
