<?php

namespace Database\Factories;

use App\Models\Apartment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        /* CREO UN ARRAY CON DENTRO GLI ID DEGLI APPARTMENTI */
        $apartments_ids = Apartment::pluck('id')->toArray();

        
        /* VALORI FAKE */
        return [
            'apartment_id' => Arr::random($apartments_ids),
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'email' => fake()->unique()->safeEmail,
            'text' => fake()->paragraph,
        ];
    }
}