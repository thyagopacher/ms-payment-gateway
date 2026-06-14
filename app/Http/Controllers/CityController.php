<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityRequest;
use App\Http\Requests\CityFilterRequest;
use App\Http\Resources\CityResource;
use App\Services\CityService;
use OpenApi\Attributes as OA;

class CityController extends Controller
{

    public function __construct(
        private CityService $service
    ) {

    }

    #[OA\Post(
        path: "/api/city",
        summary: "Create new city",
        tags: ['City'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'City created successfully'
            )
        ]
    )]
    public function store(CityRequest $request)
    {
        $data = $request->validated();
        $res = $this->service->create($data);

        return response()->json($res, 201);
    }

    #[OA\Put(
        path: "/api/city/{id}",
        summary: "Update city",
        tags: ['City'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'City updated successfully'
            )
        ]
    )]
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

    #[OA\Delete(
        path: "/api/city/{id}",
        summary: "Delete city",
        tags: ['City'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'City deleted successfully'
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
        path: "/api/city/{id}",
        summary: "Get city by ID",
        tags: ['City'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'City Found'
            ),
            new OA\Response(
                response: 404,
                description: 'City Not Found'
            )
        ]
    )]
    public function show(int $id)
    {
        $res = $this->service->getCity($id);
        return new CityResource($res);
    }

    #[OA\Get(
        path: "/api/city",
        summary: "Get all cities with filters",
        tags: ['City'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'City Found'
            ),
            new OA\Response(
                response: 404,
                description: 'City Not Found'
            )
        ]
    )]
    public function index(CityFilterRequest $request)
    {
        $filters = $request->validated();
        $data = $this->service->getCities($filters);

        return CityResource::collection($data);
    }

}
