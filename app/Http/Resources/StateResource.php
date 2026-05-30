<?php

namespace App\Http\Resources;

use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * StateResource class
 *
 * @mixin State
 *
 * @author Thyago Henrique Pacher <thyago.pacher@gmail.com.br>
 */
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
            'country' => $country->name . ' - ' . $country->abbreviation
        ];
    }
}
