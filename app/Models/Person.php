<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Notifications\Notifiable;

/**
 * Person class
 *
 * @property int $id
 * @property string $person_name
 *
 * @author Thyago Henrique Pacher <thyago.pacher@gmail.com.br>
 */
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
