<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Message;
use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function __invoke()
    {
        // Recupera tutti gli appartamenti dell'utente loggato
        $query = Apartment::where('user_id', Auth::id())->orderByDesc('updated_at')->orderByDesc('created_at');
        $apartments = $query->paginate(3);

        // Calcola il conteggio totale dei messaggi per tutti gli appartamenti dell'utente
        $totalMessages = Apartment::where('user_id', Auth::id())->withCount('messages')->get()->sum('messages_count');


        $totalViews = Apartment::where('user_id', Auth::id())->withCount('views')->get()->sum('views_count');

        // Restituisci la vista con il conteggio totale dei messaggi e altri dati necessari
        return view('welcome', compact('apartments', 'totalMessages', 'totalViews'));
    }
}
