<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<State>
 */
class StateFactory extends Factory
{

    protected $model = State::class;

    private static $countryId;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        if (!self::$countryId) {
            self::$countryId = Country::where('abbreviation', 'BR')->firstOrFail()->id;
        }

        $state = $this->faker->unique()->randomElement($this->getStates());
        return [
            'name' => $state['name'],
            'abbreviation' => $state['abbreviation'],
            'country_id' => self::$countryId,
        ];
    }


    private function getStates(): array
    {
        return [
            ['name' => 'Acre',                'abbreviation' => 'AC'],
            ['name' => 'Alagoas',             'abbreviation' => 'AL'],
            ['name' => 'Amapá',               'abbreviation' => 'AP'],
            ['name' => 'Amazonas',            'abbreviation' => 'AM'],
            ['name' => 'Bahia',               'abbreviation' => 'BA'],
            ['name' => 'Ceará',               'abbreviation' => 'CE'],
            ['name' => 'Distrito Federal',    'abbreviation' => 'DF'],
            ['name' => 'Espírito Santo',      'abbreviation' => 'ES'],
            ['name' => 'Goiás',               'abbreviation' => 'GO'],
            ['name' => 'Maranhão',            'abbreviation' => 'MA'],
            ['name' => 'Mato Grosso',         'abbreviation' => 'MT'],
            ['name' => 'Mato Grosso do Sul',  'abbreviation' => 'MS'],
            ['name' => 'Minas Gerais',        'abbreviation' => 'MG'],
            ['name' => 'Pará',                'abbreviation' => 'PA'],
            ['name' => 'Paraíba',             'abbreviation' => 'PB'],
            ['name' => 'Paraná',              'abbreviation' => 'PR'],
            ['name' => 'Pernambuco',          'abbreviation' => 'PE'],
            ['name' => 'Piauí',               'abbreviation' => 'PI'],
            ['name' => 'Rio de Janeiro',      'abbreviation' => 'RJ'],
            ['name' => 'Rio Grande do Norte', 'abbreviation' => 'RN'],
            ['name' => 'Rio Grande do Sul',   'abbreviation' => 'RS'],
            ['name' => 'Rondônia',            'abbreviation' => 'RO'],
            ['name' => 'Roraima',             'abbreviation' => 'RR'],
            ['name' => 'Santa Catarina',      'abbreviation' => 'SC'],
            ['name' => 'São Paulo',           'abbreviation' => 'SP'],
            ['name' => 'Sergipe',             'abbreviation' => 'SE'],
            ['name' => 'Tocantins',           'abbreviation' => 'TO'],
        ];
    }
}
