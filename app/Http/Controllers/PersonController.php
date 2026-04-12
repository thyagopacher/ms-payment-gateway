<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonRequest;
use App\Services\PersonService;
use Illuminate\Http\Request;

class PersonController extends Controller
{

    public function __construct(private PersonService $personService)
    {

    }

    public function create(PersonRequest $request)
    {
        $data = $request->validated();

        $res = $this->personService->create($data);
        return response()->json([
            'success' => true,
            'msg' => $res ? 'Criado com sucesso' : 'Erro ao criar'
        ]);
    }

    public function update(PersonRequest $request, int $id)
    {
        $data = $request->validated();

        $res = $this->personService->update($data, $id);
        return response()->json([
            'success' => true,
            'msg' => $res ? 'Atualizado com sucesso' : 'Erro ao atualizar'
        ]);
    }

    public function delete(int $id)
    {

        $res = $this->personService->delete($id);
        return response()->json([
            'success' => true,
            'msg' => $res ? 'Excluido com sucesso' : 'Erro ao excluir'
        ]);
    }

    public function find(int $id)
    {
        $person = $this->personService->find($id);
        return response()->json([
            'success' => true,
            'data' => $person
        ]);
    }

}
