<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pix extends Model
{

    use HasFactory;

    protected $table = 'pix';

    protected $fillable = [
        'pix_key',
        'status',
        'amount',
        'payment_id',
        'bank_id',
    ];

    protected $with = ['bank:id,name'];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
