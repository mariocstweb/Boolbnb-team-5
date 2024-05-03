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

    public function statistics(Apartment $apartment)
    {
        // Check if authorized
        if (Auth::id() !== $apartment->user_id) {
            return to_route('admin.apartments.index', $apartment)->with('alert-type', 'warning')->with('alert-message', 'Non sei autorizzato!');
        }

        // Prepare variables
        $month_views = array_fill(0, 12, 0);
        $month_messages = array_fill(0, 12, 0);
        // $year_views = [];
        // $year_messages = [];

        // Get Current Year Views and Messages
        $current_year_views = $apartment->views->where('time_of_view', '>=', date('Y-m-d H:i:s', strtotime('-1 year')));
        $current_year_messages = $apartment->messages->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-1 year')));


        // Calculate data
        foreach ($current_year_views as $view) {
            $month = date("m", strtotime($view->time_of_view));
            $month_views[$month - 1]++;
        }

        // foreach ($apartment->views as $view) {
        //     $year = date("Y", strtotime($view->time_of_view));
        //     if (isset($year_views[$year])) {
        //         $year_views[$year]++;
        //     } else {
        //         $year_views[$year] = 1;
        //     }
        // }

        foreach ($current_year_messages as $message) {
            $month = date("m", strtotime($message->created_at));
            $month_messages[$month - 1]++;
        }

        // foreach ($apartment->messages as $message) {
        //     $year = date("Y", strtotime($message->created_at));
        //     if (isset($year_messages[$year])) {
        //         $year_messages[$year]++;
        //     } else {
        //         $year_messages[$year] = 1;
        //     }
        // }


        return view('welcome', compact('month_views', 'apartment', 'month_messages'));
    }
}
