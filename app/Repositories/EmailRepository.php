<?php

namespace App\Repositories;

use App\ValueObject\Email;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EmailRepository extends BaseRepository
{

    /**
     * @var \App\Models\Email
     */
    protected Model $model;

    public function __construct()
    {
        parent::__construct(app('App\Models\Email'));
    }

    public function findByEmail(Email $email): ?Model
    {
        return $this->model->newQuery()->where('to', $email->getValue())->first();
    }

    public function getEmails(array $filters): Collection
    {
        $query = $this->model->newQuery();

        if (isset($filters['to'])) {
            $query->where('to', $filters['to']);
        }

        if (isset($filters['subject'])) {
            $query->where('subject', $filters['subject']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['limit'])) {
            $query->limit($filters['limit']);
        }

        return $query->get();
    }
}
