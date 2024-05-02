<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    /**
     * Filter apartments resource
     */
    public function index(Request $request)
    {

        //*** FILTERS DATA ***//
        $filters = $request->all();
        $radius = $filters['radius'] ?? 20000;

        // Check Required parameters
        if (!isset($filters['lat']) || !isset($filters['lon'])) return response('Latitude and Longitude are required.', 400);


        //*** GET APARTMENTS WITH FILTERS ***//
        // Get apartments fields and calculate distance
        $query = Apartment::selectRaw("*, ST_Distance_Sphere(POINT({$filters['lon']}, {$filters['lat']}), POINT( `longitude`, `latitude`)) AS `distance`");

        // Get all visible apartments
        $query->where('is_visible', 1);

        // // Get last promotion end_date (only active promotion)
        // $query->withMax(['promotions' => function ($query) {
        //     $query->where('apartment_promotion.end_date', '>=', date("Y-m-d H:i:s"));
        // }], 'apartment_promotion.end_date');

        // Get all services
        $query->with('services');

        // Filtro "min rooms"
        if (isset($filters['rooms'])) {
            $query->where('rooms', '>=', $filters['rooms']);
        }

        // Filtro "min beds"
        if (isset($filters['beds'])) {
            $query->where('beds', '>=', $filters['beds']);
        }

        // Filtro "services"
        if ($request->has('services')) {
            $serviceIds = explode(',', $request->services);
            foreach ($serviceIds as $serviceId) {
                $query->whereHas('services', function ($q) use ($serviceId) {
                    $q->where('services.id', $serviceId);
                });
            }
        }

        // Filter by distance
        $query->having('distance', '<', $radius);


        // // Ordering
        // $query->orderBy('distance');
        // $query->orderBy('created_at', 'desc');

        // Apply query and get apartments
        $apartments = $query->get();


        return $apartments;
    }
}
