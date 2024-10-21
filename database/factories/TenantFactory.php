<?php

namespace Database\Factories;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TenantFactory extends Factory
{
    protected $model = Tenant::class;

    public function definition(): array
    {
        return [
            'tenant_number' => $this->faker->word(),
            'name' => $this->faker->name(),
            'subscription' => $this->faker->boolean(),
            'valid_until' => Carbon::now(),
            'contact_name' => $this->faker->name(),
            'contact_email' => $this->faker->unique()->safeEmail(),
            'contact_cell' => $this->faker->word(),
            'user_id' => User::factory(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'data' => $this->faker->words(),
        ];
    }
}
