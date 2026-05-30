<?php

namespace App\Http\Resources;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * CityResource class
 *
 * @mixin City
 *
 * @author Thyago Henrique Pacher <thyago.pacher@gmail.com.br>
 */
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
            'state' => $state->name .' - '. $state->abbreviation,
            'country' => $state->country->name . ' - ' . $state->country->abbreviation
        ];
    }
}
