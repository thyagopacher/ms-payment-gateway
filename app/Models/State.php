<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{

    use HasFactory;

    protected $table = 'state';

    protected $fillable = [
        'name', 'abbreviation', 'country_id'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'country_id'
    ];

    protected $with = ['country:id,name'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function scopeByAbbreviation($query, $abbreviation)
    {
        return $query->where('abbreviation', $abbreviation);
    }

    public function scopeByCountry($query, $countryId)
    {
        return $query->where('country_id', $countryId);
    }

}
