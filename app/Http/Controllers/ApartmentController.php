<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Recupero tutti gli appartamenti dal DB
        $apartments = Apartment::orderByDesc('updated_at')->orderByDesc('created_at')->get();

        return view('admin.apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $apartment = new Apartment;
        return view('admin.apartments.create', compact('apartment'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|string|min:5|max:50|unique:apartments',
                'address' => 'required|string|min:5|max:50',
                'cover' => 'required|image',
                'is_visible' => 'nullable|boolean',
            ],
            [
                'title.required' => 'Il titolo è obbligatorio',
                'title.unique' => 'Non possono esistere più progetti con lo stesso titolo',
                // 'description.required' => 'La descrizione è obbligatoria',
                'cover.image' => 'Il file inserito non è un\'immagine',
                'cover.mimes' => 'Le estensione possono essere .png, .jpg, .jpeg',
            ]
        );

        $data = $request->all();
        $apartment = new Apartment();
        $apartment->fill($data);
        $apartment->is_visible = array_key_exists('is_visible', $data);


        $apartment->save();
        return to_route('admin.apartments.show', $apartment->id)->with('message', 'Nuova parola inserita con successo')->with('type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Apartment $apartment)
    {
        return view('admin.apartments.show', compact('apartment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apartment $apartment)
    {
        return view('admin.apartments.edit', compact('apartment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Apartment $apartment)
    {
        $request->validate(
            [
                'title' => 'required|string|min:5|max:50|unique:apartments',
                // 'content' => 'required|string',
                'cover' => 'nullable|image',
                'is_visible' => 'nullable|boolean',
            ],
            [
                'title.required' => 'Il titolo è obbligatorio',
                'title.unique' => 'Non possono esistere più progetti con lo stesso titolo',
                // 'description.required' => 'La descrizione è obbligatoria',
                'cover.image' => 'Il file inserito non è un\'immagine',
                'cover.mimes' => 'Le estensione possono essere .png, .jpg, .jpeg',
            ]
        );

        $data = $request->all();

        $apartment->fill($data);
        $apartment->is_visible = array_key_exists('is_visible', $data);


        $apartment->update($data);
        return to_route('admin.apartments.show', $apartment->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        $apartment->delete();
        return to_route('admin.apartments.index');
    }


    public function trash()
    {
        $apartments = Apartment::onlyTrashed()->get();
        return view('admin.apartments.trash', compact('apartments'));
    }

    public function restore(Apartment $apartment)
    {
        $apartment->restore();
        return to_route('admin.apartments.index');
    }

    public function drop(Apartment $apartment)
    {
        $apartment->forceDelete();


        return to_route('admin.apartments.trash');
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
        return to_route('admin.apartments.trash');
    }


    // Ripristina completamente il cestino
    public function returned()
    {
        $apartments = Apartment::onlyTrashed()->get();


        foreach ($apartments as $apartment) {

            $apartment->restore();
        }
        return to_route('admin.apartments.index');
    }
}
