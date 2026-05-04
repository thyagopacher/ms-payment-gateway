<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class CityRepository extends BaseRepository
{

    /**
     * @var \App\Models\City
     */
    protected Model $model;

    public function __construct()
    {
        parent::__construct(app('App\Models\City'));
    }

    public function getCities(array $filters): array
    {
        $query = $this->model->newQuery();

        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if (!empty($filters['state'])) {
            $query->where('state', $filters['state']);
        }

        return $query->get()->toArray();
    }
}
