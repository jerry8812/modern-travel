<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourGuide extends Model
{
    use HasFactory;

    public function tripDays()
    {
        return $this->hasMany(TripDay::class);
    }

    public function scopeAvailableTourGuide($q, $startDate, $endDate)
    {
        return $q->whereDoesntHave('tripDays', fn ($query) => $query->whereBetween('date', [$startDate, $endDate]));
    }
}
