<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = ['email', 'name', 'content', 'apartment_id'];

    /* RELAZIONE CON IL MODELLO APPARTAMENTI */
    public function apartment()
    {

        /* UN SOLO APPARTAMENTO */
        return $this->belongsTo(Apartment::class);
    }
    public function getDate($date_field, $format = 'd/m/y H:i')
    {
        return Carbon::create($this->$date_field)
            ->format($format);
    }
}
