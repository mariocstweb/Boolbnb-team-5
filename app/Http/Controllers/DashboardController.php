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
    public function __invoke()
    {
        // Imposta la localizzazione su italiano
        Carbon::setLocale('it');

        // Recupera tutti gli appartamenti dell'utente loggato
        $apartments = Apartment::where('user_id', Auth::id())->get();

        // Inizializza le variabili per le statistiche totali
        $totalMessages = 0;
        $totalViews = 0;

        // Cicla attraverso gli appartamenti per calcolare le statistiche totali
        foreach ($apartments as $apartment) {
            // Aggiungi il conteggio dei messaggi dell'appartamento ai totali
            $totalMessages += $apartment->messages()->count();

            // Aggiungi il conteggio delle visualizzazioni dell'appartamento ai totali
            $totalViews += $apartment->views()->count();
        }

        // Recupera i dati delle visualizzazioni totali per i mesi
        $month_views = []; // Inizializza l'array vuoto per i dati delle visualizzazioni per i mesi

        // Cicla attraverso i mesi dell'anno
        for ($month = 1; $month <= 12; $month++) {
            // Recupera il numero totale di visualizzazioni per il mese corrente
            $viewsCount = View::whereMonth('created_at', $month)
                ->whereIn('apartment_id', $apartments->pluck('id'))
                ->count();
            // Aggiungi il conteggio delle visualizzazioni all'array dei dati dei mesi
            $month_views[] = $viewsCount;
        }

        // Recupera i dati dei messaggi totali per i mesi
        $month_messages = []; // Inizializza l'array vuoto per i dati dei messaggi per i mesi

        // Cicla attraverso i mesi dell'anno
        for ($month = 1; $month <= 12; $month++) {
            // Recupera il numero totale di messaggi per il mese corrente
            $messagesCount = Message::whereMonth('created_at', $month)
                ->whereIn('apartment_id', $apartments->pluck('id'))
                ->count();
            // Aggiungi il conteggio dei messaggi all'array dei dati dei mesi
            $month_messages[] = $messagesCount;
        }

        // return view('welcome', compact('totalMessages', 'totalViews', 'month_views', 'month_messages'));
        return view('welcome', compact('apartments', 'totalMessages', 'totalViews', 'month_views', 'month_messages'));
    }
}
