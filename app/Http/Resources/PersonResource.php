<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'name' => $this->person_name,
            'document' => $this->person_document,
            'mail' => $this->person_mail,
            'phone' => $this->person_phone,
            'city' => $this->person_city,
            'state' => $this->state->name .' - '. $this->state->abbreviation ?? '',
            'country' => $this->state->country->name ?? ''
        ];
    }
}
