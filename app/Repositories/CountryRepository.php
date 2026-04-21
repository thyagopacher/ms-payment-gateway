<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CountryRepository extends BaseRepository
{

    /**
     * @var \App\Models\Country
     */
    protected Model $model;

    public function __construct()
    {
        parent::__construct(app('App\Models\Country'));
    }

    public function save(array $data): bool
    {
        $res = $this->model->newQuery()->updateOrCreate(
            ['abbreviation' => $data['abbreviation']],
            $data
        );
        Cache::forget('countries');

        return !empty($res->id);
    }

    public function delete(int $id): bool
    {
        $res = parent::delete($id);
        Cache::forget('countries');

        return $res;
    }

    public function getAll()
    {
        return Cache::remember('countries', 60 * 60 * 24, function () {
            return $this->model->all();
        });
    }
}
