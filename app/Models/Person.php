<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Person extends Model
{

    use HasFactory, Notifiable;

    protected $table = 'person';

    protected $fillable = [
        'name', 'document', 'mail', 'phone'
    ];

    public function scopeByDocument($query, $document)
    {
        return $query->where('document', $document);
    }
}
