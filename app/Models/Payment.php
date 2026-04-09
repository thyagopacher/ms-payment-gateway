<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Database\Factories\PaymentFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[UseFactory(PaymentFactory::class)]
class Payment extends Model
{

    use HasFactory;

    protected $table = 'payment';

    protected $casts = [
        'status' => PaymentStatus::class,
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function isPaid()
    {
        return $this->status === PaymentStatus::PAID;
    }
}
