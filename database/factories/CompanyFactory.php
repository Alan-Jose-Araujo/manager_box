<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fantasy_name' => fake()->company(),
            'corporate_name' => fake()->name(),
            'cnpj' => fake()->unique()->numerify('########0001##'),
            'state_registration' => fake()->unique()->numerify('########'),
            'phone_number' => fake()->numerify('55###########'),
            'landline_number' => fake()->numerify('55###########'),
            'contact_email' => fake()->unique()->safeEmail(),
            'website_url' => fake()->url(),
            'is_active' => true,
        ];
    }
}
