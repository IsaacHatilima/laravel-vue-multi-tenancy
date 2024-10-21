<?php

namespace Database\Factories;

use App\Models\Domain;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DomainFactory extends Factory
{
    protected $model = Domain::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'domain' => $this->faker->domainName(),
            'tenant_id' => Tenant::factory(),
            'user_id' => User::factory(),
            'updated_by' => User::factory(),
        ];
    }
}
