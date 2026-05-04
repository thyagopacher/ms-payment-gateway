<?php

namespace App\Services;

use App\Repositories\CityRepository;
use Illuminate\Database\Eloquent\Model;

class CityService
{

    public function __construct(
        private CityRepository $cityRepository,
    ) {

    }

    public function create(array $cityData): Model
    {

        $city = $this->cityRepository->create([
            'name'         => $cityData['name'],
            'state' => $cityData['state'],
        ]);

        return $city;
    }

    public function getCities(array $filters): array
    {
        $cities = $this->cityRepository->getCities($filters);
        return $cities;
    }

}
