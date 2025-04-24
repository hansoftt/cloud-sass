<?php

namespace Hansoft\CloudSass\Database\Factories;

use Hansoft\CloudSass\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubsriptionFactory extends Factory
{
    protected $model = Subscription::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word,
            'validity' => $this->faker->numberBetween(30, 365),
            'no_of_users' => $this->faker->numberBetween(1, 100),
            'created_at' => now(),
        ];
    }
}
