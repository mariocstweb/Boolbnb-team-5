<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Http\Request;;

class FilterServiceController extends Controller
{
    public function __invoke(string $id)
    {
        $service = Service::whereId($id)->first();
        if (!$service) return response(null, 404);

        $service_id = $service->id;

        $apartments = Apartment::whereIsVisible(true)->whereHas('services', function ($query) use ($service_id) {
            $query->where('service_id', $service_id);
        })->with('services')->get();

        return response()->json(['apartments' => $apartments, 'label' => $service->label]);
    }
}
