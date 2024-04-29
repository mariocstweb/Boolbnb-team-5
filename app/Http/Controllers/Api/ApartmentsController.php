<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Http\Request;


class ApartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $apartments = Apartment::latest()->paginate(5);

    //     return response()->json($apartments);
    // }

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

        // // Filtra gli appartamenti per range se presente il parametro "range"
        // if ($request->has('range') && $request->has('latitude') && $request->has('longitude')) {
        //     $range = $request->input('range');
        //     $latitude = $request->input('latitude');
        //     $longitude = $request->input('longitude');

        //     $query->selectRaw(
        //         '( 6371 * acos( cos( radians(?) ) *
        //         cos( radians( latitude ) ) *
        //         cos( radians( longitude ) - radians(?) ) +
        //         sin( radians(?) ) *
        //         sin( radians( latitude ) ) ) ) AS distance',
        //         [$latitude, $longitude, $latitude]
        //     )->havingRaw("distance < ?", [$range]);
        // }

        // Ordina gli appartamenti per data di creazione, paginazione con 5 risultati per pagina
        $apartments = $query->latest()->with('services')->get();
        return response()->json($apartments);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $apartment = Apartment::find($id);
        if (!$apartment) return response(null, 404);
        return response()->json($apartment);
    }
}