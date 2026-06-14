<?php

namespace Database\Factories;

use App\Enums\SendEmail;
use App\Models\Email;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Email>
 */
class EmailFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'to' => fake()->unique()->safeEmail(),
            'subject' => fake()->sentence(),
            'body' => fake()->paragraph(),
            'status' => fake()->randomElement(SendEmail::values()),
            'error_message' => fake()->optional()->sentence(),
            'read_at' => fake()->optional()->dateTime(),
        ];
    }

}
