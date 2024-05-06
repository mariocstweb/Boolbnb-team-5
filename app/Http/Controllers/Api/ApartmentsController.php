<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Http\Request;


class ApartmentsController extends Controller
{

    /* FUNZIONE PER TUTTI GLI APPARTMENTI */
    public function index(Request $request)
    {
        
        /* CREO UNA QUERY PER GLI APPARTIMENTI */
        $query = Apartment::query();

        
        /* METTO IN ORDINE PER DATA DI CREAZIONE GLI APPARTAMENTI E PASSO I SERVIZI RELAZIONATI TRAMITE MODELLO */
        $apartments = $query->latest()->with('services')->get();


        /* RESTITUISCO I DATI DEGLI APPARTAMENTI IN JSON */
        return response()->json($apartments);
    }


    /* FUNZIONE PER SINGOLO APPARTAMENTO */
    public function show(string $id)
    {

        /* RECUPERO L'APPARTMENTO CON ID SPECIFICO, E PASSO I SERVIZI CORRELLATI */
        $apartment = Apartment::with('services')->find($id);


        /* MESSAGGIO DI 404 SE L'APPARTMANETO NON ESISTE */
        if (!$apartment) return response(null, 404);


        /* RESTITUISCO I DATI DELL'APPARTAMENTO SPECIFICO IN JSON */
        return response()->json($apartment);
    }
}