<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;


    /* RELAZIONE CON IL MODELLO APPARTAMENTI */
    public function apartment()
    {

        /* UN SOLO APPARTAMENTO */
        return $this->belongsTo(Apartment::class);
    }
}