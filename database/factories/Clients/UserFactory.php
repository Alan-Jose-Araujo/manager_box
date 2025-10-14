<?php

namespace Database\Factories\Clients;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Clients\User;

class UserFactory extends Factory
{
    protected static ?string $password;

    protected $model = User::class;

    public function definition(): array
    {
            return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_confirmed_at' => now(),
            'password' => Hash::make('password'), 
            'remember_token' => \Str::random(10),
            'cpf' => $this->faker->unique()->numerify('###########00'),
            'profile_picture' => $this->faker->imageUrl(100,100,'people'),
            'phone_number' => $this->faker->numerify('###########'),
            'birth_date' => $this->faker->date(),
            'is_active' => true,
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
