<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * State class
 *
 * @property int $id
 * @property string $name
 * @property string $abbreviation
 * @property int $country_id
 * @property string $country_abbreviation
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property Country $country
 *
 * @author Thyago Henrique Pacher <thyago.pacher@gmail.com.br>
 */
class State extends Model
{

    use HasFactory;

    protected $table = 'state';

    protected $fillable = [
        'name', 'abbreviation', 'country_id', 'country_abbreviation'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'country_id'
    ];

    protected $with = ['country:id,name,abbreviation'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function scopeByAbbreviation(Builder $query, string $abbreviation)
    {
        return $query->where('abbreviation', $abbreviation);
    }

    public function scopeByCountry(Builder $query, int $countryId)
    {
        return $query->where('country_id', $countryId);
    }

}
