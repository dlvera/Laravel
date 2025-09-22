<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmailFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'recipient' => $this->faker->email,
            'subject' => $this->faker->sentence,
            'body' => $this->faker->paragraphs(3, true),
            'status' => 'sent',
            'sent_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }

    // Estado para borradores
    public function draft()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'draft',
                'sent_at' => null,
            ];
        });
    }
}