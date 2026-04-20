<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Notifications\Notifiable;

class Person extends Model
{

    use HasFactory, Notifiable;

    protected $table = 'person';

    protected $fillable = [
        'person_name', 'person_document', 'person_mail', 'person_phone'
    ];

    public function scopeByDocument(Builder $query, string $document)
    {
        return $query->where('person_document', $document);
    }
}
