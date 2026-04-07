<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = [
        'name', 'document'
    ];

    public function scopeByDocument($query, $document)
    {
        return $query->where('document', $document);
    }
}
