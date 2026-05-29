<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;

/**
 * City class
 *
 * @property int $id
 * @property string $name
 * @property string $city_state
 * @property State $state
 *
 * @author Thyago Henrique Pacher <thyago.pacher@gmail.com.br>
 */
class City extends Model
{

    use HasFactory;

    protected $table = 'city';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name', 'city_state'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'city_state' => 'string'
    ];

    protected $with = ['state:id,name,abbreviation,country_id'];

    public function state()
    {
        return $this->belongsTo(
            State::class,
            'city_state',
            'abbreviation'
        );
    }

    public function scopeByState(Builder $query, string $stateAbbreviation)
    {
        return $query->where('state', $stateAbbreviation);
    }

}
