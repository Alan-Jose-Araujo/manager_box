<?php

namespace Database\Factories\Clients;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Clients\Company;

class CompanyFactory extends Factory
{

    protected $model = Company::class;

    public function definition(): array
    {
        return [
            'fantasy_name' => $this->faker->company,
            'corporate_name' => $this->faker->unique()->companySuffix,
            'cnpj' => $this->faker->numerify('########0001##'), 
            'state_registration' => $this->faker->numerify('###########'),
            'logo_picture' => $this->faker->imageUrl(200, 200, 'business'),
            'phone_number' => $this->faker->numerify('###########'),
            'landline_number' => $this->faker->numerify('###########'),
            'contact_email' => $this->faker->unique()->companyEmail,
            'website_url' => $this->faker->url,
            'is_active' => $this->faker->boolean(90),
        ];
    }
}
