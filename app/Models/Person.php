<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;
use Illuminate\Notifications\Notifiable;
use Override;

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

    protected $primaryKey = 'id';

    protected $fillable = [
        'person_name', 'person_document', 'person_mail', 'person_phone', 'person_city', 'person_state'
    ];

    protected $with = ['state:id,name,abbreviation,country_id'];

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'person_state', 'abbreviation');
    }

    public function scopeByDocument(Builder $query, string $document)
    {
        return $query->where('person_document', $document);
    }

    public function scopeByCity(Builder $query, string $city)
    {
        return $query->where('person_city', $city);
    }

    public function scopeByState(Builder $query, string $state)
    {
        return $query->where('person_state', $state);
    }
}
