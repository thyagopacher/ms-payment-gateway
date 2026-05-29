<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{

    use HasFactory;

    protected $primaryKey = 'id';

    protected $table = 'bank';

    protected $fillable = [
        'name', 'code'
    ];

    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
    }
}
