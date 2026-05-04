<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{

    use HasFactory;

    protected $table = 'city';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name', 'state'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'state' => 'string'
    ];

    protected $with = ['state:id,name,abbreviation,country_id'];

    public function state()
    {
        return $this->belongsTo(State::class, 'state', 'abbreviation');
    }

    public function scopeByState($query, $stateAbbreviation)
    {
        return $query->where('state', $stateAbbreviation);
    }

}
