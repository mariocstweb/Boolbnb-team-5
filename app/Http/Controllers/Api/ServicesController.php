<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Http\Request;


class ServicesController extends Controller
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
        $services = Service::all();

        return response()->json($services);
    }
}
