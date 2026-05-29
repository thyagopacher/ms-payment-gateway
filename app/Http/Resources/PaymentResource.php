<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $person = $this->person;

        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'status' => $this->status,
            'payment_method' => $this->payment_method,
            'due_date' => $this->due_date,
            'paid_at' => $this->paid_at,
            'person_name' => $person->person_name,
            'person_document' => $person->person_document,
        ];
    }
}
