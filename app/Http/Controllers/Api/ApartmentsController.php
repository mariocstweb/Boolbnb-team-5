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

        // Filtra gli appartamenti per indirizzo se presente il parametro "address"
        if ($request->has('address')) {
            $address = $request->input('address');
            $query->where('address', 'like', '%' . $address . '%');
        }



        if ($request->has('rooms')) {
            $rooms = $request->input('rooms');
            $query->where('rooms', '>=', $rooms);
        }

        if ($request->has('beds')) {
            $beds = $request->input('beds');
            $query->where('beds', '>=', $beds);
        }

        if ($request->has('services')) {
            $services = $request->input('services');
            $query->whereHas('services', function ($q) use ($services) {
                $q->whereIn('id', $services);
            });
        }

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
