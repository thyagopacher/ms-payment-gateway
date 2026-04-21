<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class PersonRepository extends BaseRepository
{

    /**
     * @var \App\Models\Person
     */
    protected Model $model;

    public function __construct()
    {
        parent::__construct(app('App\Models\Person'));
    }

    public function findByDocument(string $document): ?Model
    {
        return $this->model->newQuery()->where('document', $document)->first();
    }
}
