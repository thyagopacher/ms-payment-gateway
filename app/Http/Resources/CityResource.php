<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
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
            'name' => $this->name,
            'state' => $state->name .' - '. $state->abbreviation ?? '',
            'country' => $state->country->name . ' - ' . $state->country->abbreviation ?? ''
        ];
    }
}
