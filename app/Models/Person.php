<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{

    use HasFactory;

    protected $table = 'person';

    protected $fillable = [
        'name', 'document', 'email', 'phone'
    ];

    public function scopeByDocument($query, $document)
    {
        return $query->where('document', $document);
    }
}
