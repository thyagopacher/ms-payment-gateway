<?php

namespace Tests\Unit\Dto;

use App\Dto\CityDTO;

class CityDtoTest extends \Tests\TestCase
{
    public function test_from_array(): void
    {
        $data = [
            'name' => '123',
            'state' => 'PR'
        ];

        $cityDto = CityDto::fromArray($data);

        $this->assertEquals('123', $cityDto->city->getValue());
        $this->assertEquals('PR', $cityDto->state->getValue());
    }

    public function test_to_array(): void
    {
        $cityDto = new CityDto(
            city: new \App\ValueObject\City('123'),
            state: new \App\ValueObject\State('PR'),
        );

        $array = $cityDto->toArray();

        $this->assertEquals('123', $array['city']);
        $this->assertEquals('PR', $array['state']);
    }
}
