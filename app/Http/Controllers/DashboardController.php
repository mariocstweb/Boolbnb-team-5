<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Message;
use App\Models\Sponsor;
use App\Models\View;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    // public function __invoke()
    // {

    //     // Recupera tutti gli appartamenti dell'utente loggato
    //     $query = Apartment::where('user_id', Auth::id())->orderByDesc('updated_at')->orderByDesc('created_at');
    //     $apartments = $query->paginate(3);

    //     // Calcola il conteggio totale dei messaggi per tutti gli appartamenti dell'utente
    //     $totalMessages = Apartment::where('user_id', Auth::id())->withCount('messages')->get()->sum('messages_count');


    //     $totalViews = Apartment::where('user_id', Auth::id())->withCount('views')->get()->sum('views_count');

    //     // Restituisci la vista con il conteggio totale dei messaggi e altri dati necessari
    //     return view('welcome', compact('apartments', 'totalMessages', 'totalViews', ''));
    // }

    // public function __invoke()
    // {
    //     // Recupera tutti gli appartamenti dell'utente loggato con i dati dell'expiration_date
    //     $apartments = Apartment::where('user_id', Auth::id())
    //         ->with(['sponsors' => function ($query) {
    //             $query->select('id', 'expiration_date'); // Seleziona solo l'id e l'expiration_date del sponsor
    //         }])
    //         ->orderByDesc('updated_at')
    //         ->orderByDesc('created_at')
    //         ->paginate(3);

    //     // Calcola il conteggio totale dei messaggi per tutti gli appartamenti dell'utente
    //     $totalMessages = Apartment::where('user_id', Auth::id())->withCount('messages')->get()->sum('messages_count');

    //     $totalViews = Apartment::where('user_id', Auth::id())->withCount('views')->get()->sum('views_count');

    //     // Restituisci la vista con il conteggio totale dei messaggi e altri dati necessari
    //     return view('welcome', compact('apartments', 'totalMessages', 'totalViews'));
    // }



    public function __invoke()
    {
        // Imposta la localizzazione su italiano
        Carbon::setLocale('it');

        // Recupera tutti gli appartamenti dell'utente loggato con i dati dell'expiration_date
        $apartments = Apartment::where('user_id', Auth::id())
            ->with(['sponsors' => function ($query) {
                $query->select('id', 'expiration_date'); // Seleziona solo l'id e l'expiration_date del sponsor
            }])
            ->orderByDesc('updated_at')
            ->orderByDesc('created_at')
            ->paginate(3);

        // Converti le date di scadenza nel formato italiano
        foreach ($apartments as $apartment) {
            foreach ($apartment->sponsors as $sponsor) {
                $sponsor->expiration_date = Carbon::parse($sponsor->expiration_date)->format('d-m-Y H:i:s');
            }
        }

        // Calcola il conteggio totale dei messaggi per tutti gli appartamenti dell'utente
        $totalMessages = Apartment::where('user_id', Auth::id())->withCount('messages')->get()->sum('messages_count');

        $totalViews = Apartment::where('user_id', Auth::id())->withCount('views')->get()->sum('views_count');

        // Restituisci la vista con il conteggio totale dei messaggi e altri dati necessari
        return view('welcome', compact('apartments', 'totalMessages', 'totalViews'));
    }
}
