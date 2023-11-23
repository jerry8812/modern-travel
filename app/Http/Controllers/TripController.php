<?php

namespace App\Http\Controllers;

use App\Enums\Town;
use App\Enums\TripStatus;
use App\Http\Requests\TripFormRequest;
use App\Models\Trip;
use App\Models\TripDay;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TripController extends Controller
{
    public function createTrip()
    {
        return Inertia::render('Trips/TripForm', $this->getTripFormLookups());
    }

    public function edit(Trip $trip)
    {
        $trip->load('tripDays');
        $formData = \array_merge(['trip' => $trip], $this->getTripFormLookups());
        return Inertia::render('Trips/TripForm', $formData);
    }

    public function update(TripFormRequest $request, Trip $trip)
    {
        return $this->handleForm($request, $trip);
    }

    public function store(TripFormRequest $request)
    {
        $trip = new Trip();
        return $this->handleForm($request, $trip);
    }

    /**
     * handle create and update trip
     *
     * @param Trip $trip
     * @return redirect to trips view
     */
    private function handleForm(TripFormRequest $request, Trip $trip)
    {
        DB::transaction(function () use ($request, $trip) {
            $trip->fill($request->all());

            // generate a trip number for new created trip
            if (!$trip->trip_number) {
                // get count of trips that start on same day
                $countOfTripsStartOnSameDay = Trip::where('start_date', $request->start_date)->count();
                // generate trip number
                $trip->trip_number = \sprintf(
                    '%s-%s',
                    (new Carbon($request->start_date))->format('Ymd'),
                    str_pad($countOfTripsStartOnSameDay + 1, 2, '0', \STR_PAD_LEFT)
                );
            }

            $trip->save();

            // date changes, delete old records
            if ($trip->wasChanged('start_date') || $trip->wasChanged('end_date')) {
                $trip->tripDays()->delete();
            }
            // now create trip days or update them
            foreach ($request->trip_days as $tripDay) {
                // not scheduled if no location passed through
                if (!$tripDay['id'] && !$tripDay['location']) continue;

                $day = TripDay::firstOrNew(['id' => $tripDay['id']]);
                $day->fill($tripDay);
                $day->trip_id = $trip->id;
                $day->tour_guide_id = $tripDay['tour_guide_id'];
                $day->rental_car_id = $tripDay['rental_car_id'];
                $day->save();
            }
        });
        return \redirect(route('trips'));
    }

    private function getTripFormLookups()
    {
        $townLookup = collect(Town::cases())->pluck('value');
        $tripStatusLookup = collect(TripStatus::cases())->pluck('value');
        return \compact('townLookup', 'tripStatusLookup');
    }
}
