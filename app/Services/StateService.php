<?php

namespace App\Services;

use App\Repositories\StateRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class StateService
{

    public function __construct(
        private StateRepository $stateRepository,
    ) {

    }

    public function create(array $stateData): Model
    {

        $state = $this->stateRepository->create([
            'name'         => $stateData['name'],
            'abbreviation' => $stateData['abbreviation'],
            'country_id' => $stateData['country_id'],
        ]);

        return $state;
    }

    public function update(array $stateData, int $id): Model
    {

        $state = $this->stateRepository->update($id, [
            'name'         => $stateData['name'],
            'abbreviation' => $stateData['abbreviation'],
            'country_id' => $stateData['country_id'],
        ]);

        return $state;
    }

    public function delete(int $id): bool
     {
        $res = $this->stateRepository->delete($id);
        return $res;
    }

    public function getState(int $id): Model
    {
        $state = $this->stateRepository->find($id);
        return $state;
    }

    public function getStates(array $filters): Collection
    {
        $states = $this->stateRepository->getStates($filters);
        return $states;
    }

}
