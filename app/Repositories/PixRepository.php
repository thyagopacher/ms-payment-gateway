<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class PixRepository extends BaseRepository
{

    /**
     * @var \App\Models\Pix
     */
    protected Model $model;

    public function __construct()
    {
        parent::__construct(app('App\Models\Pix'));
    }

}
