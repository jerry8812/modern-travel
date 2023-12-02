<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RentalCar;
use App\Models\TourGuide;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TripController extends Controller
{
    public function index()
    {
        $trips = Trip::with(['tripDays' => fn ($query) => $query->withCarAndTourGuide()])
            ->where('trips.end_date', '>=', now())
            ->orderBy('start_date')
            ->get();

        $clientOptions = Trip::distinct('source')->get()->pluck('source');
        return \compact('trips', 'clientOptions');
    }

    public function destroy(Trip $trip)
    {
        $trip->delete();
    }

    /**
     * get available cars and tour guides in certain period
     *
     * @param Request $request start date and end date
     * @return array
     */
    public function getAvailableResources(Request $request): array
    {
        $availableCars = RentalCar::query()
            ->select([
                'rental_cars.id as id',
                DB::raw("CONCAT(rental_cars.model, ' - ', rental_cars.plate_number) as name")
            ])
            ->get();

        $availableTourGuides = TourGuide::query()
            ->select([
                'tour_guides.id as id',
                DB::raw("CONCAT(tour_guides.name, ' - ', tour_guides.location) as name")
            ])
            ->get();

        return \compact('availableCars', 'availableTourGuides');
    }
}
