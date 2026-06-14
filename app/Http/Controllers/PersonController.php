<?php

namespace App\Http\Controllers;

use App\Dto\PersonDTO;
use App\Http\Requests\PersonRequest;
use App\Http\Resources\PersonResource;
use App\Services\PersonService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;


class PersonController extends Controller
{

    public function __construct(private PersonService $personService)
    {

    }

    #[OA\Post(
        path: "/api/person",
        summary: "Create person",
        tags: ['Person'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Person created successfully'
            )
        ]
    )]
    public function store(PersonRequest $request)
    {
        $data = $request->validated();
        $res = $this->personService->create(PersonDTO::fromArray($data));
        return response()->json([
            'success' => true,
            'msg' => $res ? __('api.created_success') : __('api.created_error'),
            'id' => $res
        ], 201);
    }


    #[OA\Put(
        path: "/api/person/{id}",
        summary: "Update person",
        tags: ['Person'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Person updated successfully'
            )
        ]
    )]
    public function update(PersonRequest $request, int $id): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();

        $res = $this->personService->update(PersonDTO::fromArray($data), $id);
        $success = !empty($res->id);

        return response()->json([
            'success' => $success,
            'msg' => $success ? __('api.updated_success') : __('api.updated_error')
        ]);

    }

    #[OA\Delete(
        path: "/api/person/{id}",
        summary: "Delete person",
        tags: ['Person'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Person deleted successfully'
            )
        ]
    )]
    public function delete(int $id)
    {

        $res = $this->personService->delete($id);
        return response()->json([
            'success' => true,
            'msg' => $res ? __('api.deleted_success') : __('api.deleted_error')
        ]);
    }

    #[OA\Get(
        path: "/api/person/{id}",
        summary: "Get person by ID",
        tags: ['Person'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Person Found'
            ),
            new OA\Response(
                response: 404,
                description: 'Person Not Found'
            )
        ]
    )]
    public function show(int $id)
    {
        $person = $this->personService->find($id);
        return new PersonResource($person);
    }

    #[OA\Get(
        path: "/api/person",
        summary: "Get all persons with filters",
        tags: ['Person'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Person Found'
            ),
            new OA\Response(
                response: 404,
                description: 'Person Not Found'
            )
        ]
    )]
    public function index()
    {
        return PersonResource::collection($this->personService->findAll());
    }

}
