<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EmailAttachmentRepository extends BaseRepository
{

    /**
     * @var \App\Models\EmailAttachment
     */
    protected Model $model;

    public function __construct()
    {
        parent::__construct(app('App\Models\EmailAttachment'));
    }

    public function getAttachments(array $filters): Collection
    {
        $query = $this->model->newQuery();

        if (isset($filters['email_id'])) {
            $query->where('email_id', $filters['email_id']);
        }

        if (isset($filters['limit'])) {
            $query->limit($filters['limit']);
        }

        return $query->get();
    }
}
