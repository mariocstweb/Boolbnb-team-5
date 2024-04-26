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
        // Query per gli appartamenti
        $query = Apartment::where('user_id', Auth::id())->orderByDesc('updated_at')->orderByDesc('created_at');

        $apartments = $query->paginate(3);

        $views = View::all();

        $messages = Message::all();


        return view('welcome', compact('apartments', 'views', 'messages'));
    }
}
