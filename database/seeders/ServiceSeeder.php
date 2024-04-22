<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $apartments_ids = Apartment::pluck('id')->toArray();

        // Services List
        $services = config('apartment_services');

        foreach ($services as $service) {

            $new_service = new Service();

            $new_service->label = $service['label'];
            $new_service->icon = $service['icon'];

            $new_service->save();

            $service_apartments = array_filter($apartments_ids, fn () => rand(0, 1));

            $new_service->apartments()->attach($service_apartments);
        }
    }
}
