<?php

namespace Database\Factories;

use App\Models\Email;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmailFactory extends Factory
{
    protected $model = Email::class;

    public function definition()
    {
        // Definir los estados permitidos
        $allowedStatuses = ['pending', 'sending', 'sent', 'failed'];
        
        return [
            'subject' => $this->faker->sentence(),
            'recipient' => $this->faker->email(),
            'body' => $this->faker->paragraphs(3, true),
            'status' => $this->faker->randomElement($allowedStatuses), // Solo valores permitidos
            'user_id' => User::factory(),
            'sent_at' => $this->faker->optional(0.7)->dateTime(), // 70% de probabilidad de tener fecha
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}