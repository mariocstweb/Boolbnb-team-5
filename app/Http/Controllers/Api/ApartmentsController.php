<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Http\Request;


class ApartmentsController extends Controller
{
    public function index(Request $request)
    {
        $query = Apartment::query();

        // Ordina gli appartamenti per data di creazione, paginazione con 5 risultati per pagina
        $apartments = $query->latest()->with('services')->get();
        return response()->json($apartments);
    }


    public function show(string $id)
    {
        $apartment = Apartment::with('services')->find($id);

        if (!$apartment) return response(null, 404);

        return response()->json($apartment);
    }
}
