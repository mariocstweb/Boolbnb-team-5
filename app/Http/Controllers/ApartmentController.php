<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Http\Requests\UpdateApartmentRequest;
use App\Http\Requests\StoreApartmentRequest;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        /* Recupero valore */
        $search = $request->query('search');

        // if (!$search) {
        //     // Recupero tutti gli appartamenti dal DB
        //     $apartments = Apartment::orderByDesc('updated_at')->orderByDesc('created_at')->get();
        // } else {
        //     /* Filtro per nome */
        //     $apartments = Apartment::where('title', 'LIKE', "$search%")->get();
        // }

        // Query per gli appartamenti
        $query = Apartment::orderByDesc('updated_at')->orderByDesc('created_at');

        // Applica filtro di ricerca se presente
        if ($search) {
            $query->where('title', 'LIKE', "%$search%");
        }

        $apartments = $query->paginate(2);
        return view('admin.apartments.index', compact('apartments', 'search',));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        /* RECUPERO TUTTI I SERVIZI */
        $services = Service::all();

        $array_services = array();

        $apartment = new Apartment;
        return view('admin.apartments.create', compact('apartment', 'services', 'array_services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApartmentRequest $request)
    {
        $data = $request->validated();


        $apartment = new Apartment();
        $apartment->fill($data);
        $apartment->is_visible = array_key_exists('is_visible', $data);


        $apartment->save();


        /* VERIFICO SE ESISTE NELL'ARRAY LA CHIAVE SERVICES, SE ESTISTE */
        if (Arr::exists($data, 'services')) {
            /* ATTACCO I RECORD DELL'APPARTAMWENTO AI RECORD DELI SERVIZI */
            $apartment->services()->attach($data['services']);
        }

        return to_route('admin.apartments.show', $apartment->id)
            ->with('message', 'Hai inserito correttamente un nuovo appartamento')
            ->with('type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Apartment $apartment)
    {
        $services = Service::all();

        return view('admin.apartments.show', compact('apartment', 'services'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apartment $apartment)
    {

        /* CREO ARRAY CON GLI ID DI SERVICES */
        $array_services = $apartment->services->pluck('id')->toArray();

        $services = Service::all();

        return view('admin.apartments.edit', compact('apartment', 'services', 'array_services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApartmentRequest $request, Apartment $apartment)
    {
        $data = $request->validated();



        $apartment->fill($data);
        $apartment->is_visible = array_key_exists('is_visible', $data);


        $apartment->update($data);

        /* VERIFICO SE ESISTE NELL'ARRAY LA CHIAVE SERVICES, SE ESTISTE , ALTRIMENTI SE NON ESISTE E CI SONO RELAZIONI */
        if (Arr::exists($data, 'services')) {
            /* SINCRONIZZO I RECORD DELL'APPARTAMENTO AI RECORD DEI SERVIZI*/
            $apartment->services()->sync($data['services']);
        } elseif (!Arr::exists($data, 'services') && $apartment->has('services')) {

            /* DISSOCIA I RECORD DELL'APPARTAMENTO AI RECORD DEI SERVIZI */
            $apartment->services()->detach($data['services']);
        }


        return to_route('admin.apartments.show', $apartment->id)
            ->with('type', 'warning')
            ->with('message', "'$apartment->title' modificato con successo.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        $apartment->delete();
        return to_route('admin.apartments.index')
            ->with('type', 'danger')
            ->with('message', "Hai spostato '$apartment->title' nel cestino.");
    }


    public function trash()
    {
        $apartments = Apartment::onlyTrashed()->get();
        return view('admin.apartments.trash', compact('apartments'));
    }

    public function restore(Apartment $apartment)
    {
        $apartment->restore();
        return to_route('admin.apartments.index')
            ->with('type', 'success')
            ->with('message', "Hai ripristinato '$apartment->title' con successo.");
    }

    public function drop(Apartment $apartment)
    {
        $apartment->forceDelete();


        return to_route('admin.apartments.trash')
            ->with('type', 'danger')
            ->with('message', "Hai eliminato '$apartment->title' definitivamente.");
    }


    // Svuota completamente il cestino
    public function empty()
    {
        $apartments = Apartment::onlyTrashed()->get();


        foreach ($apartments as $apartment) {

            if ($apartment->title) {
                Storage::delete($apartment->title);
            }

            $apartment->forceDelete();
        }
        return to_route('admin.apartments.trash')
            ->with('type', 'danger')
            ->with('message', "Cestino svuotato");
    }


    // Ripristina completamente il cestino
    public function returned()
    {
        $apartments = Apartment::onlyTrashed()->get();


        foreach ($apartments as $apartment) {

            $apartment->restore();
        }
        return to_route('admin.apartments.index')
            ->with('type', 'info')
            ->with('message', "Hai ripristinato tutti gli appartamenti");
    }
}
