<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $country = $this->country;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'country' => $country->name . ' - ' . $country->abbreviation ?? ''
        ];
    }
}
