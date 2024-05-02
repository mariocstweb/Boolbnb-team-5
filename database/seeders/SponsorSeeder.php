<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sponsor;
use Carbon\Carbon;

class SponsorSeeder extends Seeder
{
    public function run(): void
    {

        /* RECUPERO ARRAY ASSOCIATIVO IN CONFIG */
        $sponsors = config('sponsors');


        /* CICLO SUL L'ARRAY CREANDO UNA NUOVA ISTANZA E DANDOGLI DEI VALORI AD OGNI SINGOLO ELEMENTO */
        foreach ($sponsors as $sponsorData) {
            $new_sponsor = new Sponsor();
            $new_sponsor->label = $sponsorData['label'];
            $new_sponsor->price = $sponsorData['price'];
            $new_sponsor->premium = $sponsorData['premium'];
            $new_sponsor->description = $sponsorData['description'];
            $new_sponsor->color = $sponsorData['color'];
            $new_sponsor->duration = $sponsorData['duration'];

            $new_sponsor->save();
        }
    }
}
// c