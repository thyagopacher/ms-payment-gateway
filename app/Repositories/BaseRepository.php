<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(array $columns = ['*'])
    {
        return $this->model->newQuery()->get($columns);
    }

    public function find(int $id)
    {
        return $this->model->newQuery()->find($id);
    }

    public function findOrFail(int $id)
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function create(array $data): model
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(int $id, array $data): model
    {
        $model = $this->findOrFail($id);
        $model->update($data);

        return $model;
    }

    public function delete(int $id): bool
    {
        return $this->findOrFail($id)->delete();
    }
}
