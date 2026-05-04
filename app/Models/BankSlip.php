<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankSlip extends Model
{

    use HasFactory;

    protected $table = 'bank_slip';

    protected $with = ['bank:id,name'];

    protected $fillable = [
        'person_name',
        'person_city',
        'person_state',
        'person_document',
        'person_address',
        'person_zipcode',
        'bill_amount',
        'bill_due_date',
        'payment_id',
        'bank_id',
    ];

    protected $casts = [
        'bill_amount' => 'decimal:2',
        'bill_due_date' => 'date',
        'payment_id' => 'integer',
        'bank_id' => 'integer',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

}
