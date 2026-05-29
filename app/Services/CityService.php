<?php

namespace App\Services;

use App\Repositories\CityRepository;
use Illuminate\Database\Eloquent\Collection;
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

    public function update(array $cityData, int $id): Model
    {

        $city = $this->cityRepository->update($id, [
            'name'         => $cityData['name'],
            'state' => $cityData['state'],
        ]);

        return $city;
    }

    public function delete(int $id): bool
     {
        $res = $this->cityRepository->delete($id);
        return $res;
    }

    public function getCity(int $id): Model
    {
        $city = $this->cityRepository->find($id);
        return $city;
    }

    public function getCities(array $filters): Collection
    {
        $cities = $this->cityRepository->getCities($filters);
        return $cities;
    }

}
