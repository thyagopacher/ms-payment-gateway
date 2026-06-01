<?php

namespace App\Repositories;

use App\ValueObject\Document;
use Illuminate\Database\Eloquent\Collection;
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

    public function findByDocument(Document $document): ?Model
    {
        return $this->model->newQuery()->where('document', $document->getValue())->first();
    }

    public function getPersons(array $filters): Collection
    {
        $query = $this->model->newQuery();

        if (isset($filters['person_document'])) {
            $query->where('person_document', $filters['person_document']);
        }

        if (isset($filters['person_name'])) {
            $query->where('person_name', $filters['person_name']);
        }

        if (isset($filters['person_state'])) {
            $query->where('person_state', $filters['person_state']);
        }

        if (isset($filters['limit'])) {
            $query->limit($filters['limit']);
        }

        return $query->get();
    }
}
