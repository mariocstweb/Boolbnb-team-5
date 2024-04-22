<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sponsor;
use Carbon\Carbon;

class SponsorSeeder extends Seeder
{
    public function run(): void
    {
        $sponsors = config('sponsors');

        foreach ($sponsors as $sponsorData) {
            $new_sponsor = new Sponsor();
            $new_sponsor->label = $sponsorData['label'];
            $new_sponsor->price = $sponsorData['price'];
            $new_sponsor->description = $sponsorData['description'];
            $new_sponsor->color = $sponsorData['color'];
            $new_sponsor->duration = $sponsorData['duration'];

            $new_sponsor->save();
        }
    }
}
