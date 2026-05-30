<?php

namespace App\Http\Resources;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * PersonResource class
 *
 * @mixin Person
 *
 * @author Thyago Henrique Pacher <thyago.pacher@gmail.com.br>
 */
class PersonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $state = $this->state;

        return [
            'id' => $this->id,
            'name' => $this->person_name,
            'document' => $this->person_document,
            'mail' => $this->person_mail,
            'phone' => $this->person_phone,
            'city' => $this->person_city,
            'state' => $state->name .' - '. $state->abbreviation,
            'country' => $state->country->name ?? ''
        ];
    }
}
