<?php

namespace App\Repositories;

use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

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

    public function save(array $data): bool
    {
        $res = $this->model->newQuery()->updateOrCreate(
            ['name' => $data['name'], 'state' => $data['state']],
            $data
        );
        Cache::forget('cities_state_'. $data['state']);

        return !empty($res->id);
    }

    public function delete(int $id): bool
    {
        $city = parent::find($id);
        if(empty($city->id)) {
            throw new NotFoundException(__('api.select_not_found'));
        }

        $state = $city->state;

        $res = parent::delete($id);
        Cache::forget('cities_state_'. $state);

        return $res;
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

    public function getCitiesByState(string $state): array
    {
        return Cache::remember('cities_state_'. $state, 3600, function () use ($state) {
            $query = $this->model->newQuery();
            $query->where('state', $state);
            return $query->get()->toArray();
        });
    }
}
