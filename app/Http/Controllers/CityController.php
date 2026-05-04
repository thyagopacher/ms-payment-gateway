<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityRequest;
use App\Http\Requests\CityFilterRequest;
use App\Services\CityService;

class CityController extends Controller
{

    public function __construct(
        private CityService $service
    ) {

    }

    public function create(CityRequest $request)
    {
        $data = $request->validated();
        $res = $this->service->create($data);
        return response()->json($res);
    }

    public function getCities(CityFilterRequest $request)
    {
        $data = $request->validated();
        $res = $this->service->getCities($data);
        return response()->json($res);
    }

}
