<?php

namespace Database\Factories;

use App\Models\Apartment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\View>
 */
class ViewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $apartments_ids = Apartment::pluck('id')->toArray();
        // $apartments_ids[] = null;

        return [
            'code_ip' => fake()->ipv4(),
            'time_of_view' => fake()->time('H:i:s'),
            'apartment_id' => Arr::random($apartments_ids)
        ];
    }
}












// $service_apartments = array_filter($apartments_ids, fn () => rand(0, 1));


// $new_service->apartments()->attach($service_apartments);
