<?php

namespace App\Models;

use App\Enums\Town;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TripDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'day_number',
        'date',
        'rental_fee',
        'location',
        'comment'
    ];

    protected $cast = [
        'location' => Town::class
    ];

    public function scopeWithCarAndTourGuide($query)
    {
        return $query->leftJoin('rental_cars', 'rental_cars.id', '=', 'trip_days.rental_car_id')
            ->leftJoin('tour_guides', 'tour_guides.id', '=', 'trip_days.tour_guide_id')
            ->select([
                'trip_days.*',
                'tour_guides.name as tour_guide_name',
                DB::raw("CONCAT(rental_cars.model, ' - ', rental_cars.plate_number) as rental_car_name")
            ]);
    }
}
