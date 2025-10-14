<?php

namespace Database\Factories\Clients;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Clients\Address;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition(): array
    {
        return [
            'street' => $this->faker->streetName,
            'building_number' => $this->faker->buildingNumber,
            'neighborhood' => $this->faker->citySuffix,
            'city' => $this->faker->city,
            'state' => $this->faker->stateAbbr,
        ];
    }
}
