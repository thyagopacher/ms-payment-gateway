<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankSlip extends Model
{

    use HasFactory;

    protected $table = 'bank_slip';

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
