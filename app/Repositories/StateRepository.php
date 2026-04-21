<?php

namespace App\Repositories;

use App\Models\State;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class StateRepository extends BaseRepository
{

    /**
     * @var \App\Models\State
     */
    protected Model $model;

    public function __construct()
    {
        parent::__construct(app('App\Models\State'));
    }

    public function save(array $data): bool
    {
        $res = $this->model->newQuery()->updateOrCreate(
            ['abbreviation' => $data['abbreviation']],
            $data
        );
        Cache::forget('states');

        return !empty($res->id);
    }

    public function delete(int $id): bool
    {
        $res = parent::delete($id);
        Cache::forget('states');

        return $res;
    }

    public function getAll()
    {
        return Cache::remember('states', 60 * 60 * 24, function () {
            return $this->model->all();
        });
    }
}
