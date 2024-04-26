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

        /* ORDINO I RISULTATI DELLA QUERY IN ORDINE E FILTRA GLI APPARTAMENTI IN BASE ALL'ID DELL'UTENTE AUTENTICATO */
        $query = Apartment::where('user_id', Auth::id())->orderByDesc('updated_at')->orderByDesc('created_at');


        /* PAGINAZIONE */
        $apartments = $query->paginate(3);


        /* RECUPERO LE VISSUALIZZAZIONI CHE CORRISPONDONO AGLI ID DELL'APPARTAMENTI ESTRANDOLI E FILTRANDOLI */
        $views = View::whereIn('apartment_id', $apartments->pluck('id'))->get();


        /* RECUPERO LE VISSUALIZZAZIONI CHE CORRISPONDONO AGLI ID DELL'APPARTAMENTI ESTRANDOLI E FILTRANDOLI */
        $messages = Message::whereIn('apartment_id', $apartments->pluck('id'))->get();


        /* RESTITUISCO IN PAGINA */
        return view('welcome', compact('apartments', 'views', 'messages'));
    }
}
