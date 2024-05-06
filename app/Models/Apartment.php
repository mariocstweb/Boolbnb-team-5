<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apartment extends Model
{
    use HasFactory;


    /* ELIMINAZIONE SOFT */
    use SoftDeletes;


    /* ASSEGNO VALORI DI MASSA */
    protected $fillable = ['title', 'cover', 'beds', 'rooms', 'bathrooms', 'address', 'sqm', 'longitude', 'latitude', 'description', 'user_id'];


    /* RELAZIONE CON IL MODELLO SERVIZI */
    public function services()
    {

        /* MOLTI SERVIZI */
        return $this->belongsToMany(Service::class);
    }


    /* RELAZIONE CON IL MODELLO MESSAGGI */
    public function messages()
    {

        /* MOLTI MESSAGGI */
        return $this->hasMany(Message::class)->orderByDesc('created_at');
    }


    /* RELAZIONE CON IL MODELLO SPONSOR */
    public function sponsors()
    {

        /* MOLTI SPONSOR */
        return $this->belongsToMany(Sponsor::class)->withPivot('expiration_date');
    }


    /* RELAZIONE CON IL MODELLO VISUALIZZAZIONI */
    public function views()
    {

        /* MOLTE VISUALIZZAZIONI */
        return $this->hasMany(View::class);
    }


    /* RELAZIONE CON IL MODELLO USER */
    public function user()
    {

        /* UN SOLO USER */
        return $this->belongsTo(User::class);
    }


    /* FUNZIONE PER CONTARE LE VISUALIZZAZZIONI DI OGNI SINGOLO APPARTAMENTO */
    public function viewsCount()
    {
        return $this->views()->count();
    }


    /* FUNZIONE PER CONTARE I MESSAGGI DI OGNI SINGOLO APPARTAMENTO */
    public function messagesCount()
    {
        return $this->messages()->count();
    }
}
