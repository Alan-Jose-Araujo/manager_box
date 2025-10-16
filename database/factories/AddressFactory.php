<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $addressable = fake()->randomElement([
            \App\Models\Company::class,
            \App\Models\User::class,
        ]);
        return [
            'street' => fake()->streetName(),
            'building_number' => fake()->numerify('#####'),
            'neighborhood' => fake()->streetAddress(),
            'zip_code' => fake()->numerify('########'),
            'complement' => fake()->text(),
            'city' => fake()->city(),
            'state' => strtoupper(fake()->randomLetter() . fake()->randomLetter()),
            'addressable_type' => $addressable,
            'addressable_id' => $addressable::factory()->create()->id,
        ];
    }
}
