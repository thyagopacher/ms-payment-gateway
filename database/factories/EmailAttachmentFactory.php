<?php

namespace Database\Factories;

use App\Models\Email;
use App\Models\EmailAttachment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EmailAttachment>
 */
class EmailAttachmentFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email_id' => Email::factory(),
            'file_name' => fake()->word() . '.pdf',
            'file_path' => fake()->filePath(),
            'file_type' => fake()->mimeType(),
            'file_size' => fake()->numberBetween(1024, 1048576),
        ];
    }
    
}
