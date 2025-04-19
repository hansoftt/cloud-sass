<?php

namespace Hansoft\CloudSass\Database\Factories;

use Hansoft\CloudSass\Models\Client;
use Hansoft\CloudSass\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'subdomain' => $this->faker->unique()->word,
            'project_id' => Project::factory(),
        ];
    }
}
