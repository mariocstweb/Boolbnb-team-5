<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    use HasFactory;


    /* RELAZIONE CON IL MODELLO APPARTAMENTI */
    public function apartments()
    {

        /* MOLTI APPARTAMENTI */
        return $this->belongsToMany(Apartment::class)->withPivot('expiration_date');
    }



    public function durationInMinutes()
    {
        // La durata è rappresentata come HH:MM
        list($hours, $minutes) = explode(':', $this->duration);

        // Calcola il totale dei minuti
        return ($hours * 60) + $minutes;
    }
}
