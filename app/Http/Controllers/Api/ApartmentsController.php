<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
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

        // Ordina gli appartamenti per data di creazione, paginazione con 5 risultati per pagina
        $apartments = $query->latest()->paginate(5);

        return response()->json($apartments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Apartment $apartment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        //
    }
}
