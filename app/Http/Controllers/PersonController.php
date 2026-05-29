<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonRequest;
use App\Http\Resources\PersonResource;
use App\Services\PersonService;
use Illuminate\Http\Request;

class PersonController extends Controller
{

    public function __construct(private PersonService $personService)
    {

    }

    public function store(PersonRequest $request)
    {
        $data = $request->validated();

        $res = $this->personService->create($data);
        return response()->json([
            'success' => true,
            'msg' => $res ? __('api.created_success') : __('api.created_error'),
            'id' => $res
        ]);
    }

    /**
     * update function
     *
     * method PUT
     *
     * @param PersonRequest $request
     * @param integer $id
     * @return void
     * @author Thyago Henrique Pacher <thyago.pacher@gmail.com.br>
     */
    public function update(PersonRequest $request, int $id)
    {
        $data = $request->validated();

        $res = $this->personService->update($data, $id);
        return response()->json([
            'success' => true,
            'msg' => $res ? __('api.updated_success') : __('api.updated_error')
        ]);
    }

    public function delete(int $id)
    {

        $res = $this->personService->delete($id);
        return response()->json([
            'success' => true,
            'msg' => $res ? __('api.deleted_success') : __('api.deleted_error')
        ]);
    }

    public function show(int $id)
    {
        $person = $this->personService->find($id);
        return new PersonResource($person);
    }

    public function index()
    {
        return PersonResource::collection($this->personService->findAll());
    }

}
