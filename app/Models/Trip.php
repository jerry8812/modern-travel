<?php

namespace App\Models;

use App\Enums\TripStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
        'source',
        'status',
        'amount_of_people',
        'total_price',
        'comment'
    ];

    protected $cast = [
        'status' => TripStatus::class
    ];

    public function tripDays()
    {
        return $this->hasMany(TripDay::class);
    }

    public function scopeApplyFilters($q, $filters)
    {
        $keyword = $filters['keyword'] ?? '';
        $client = $filters['client'] ?? '';
        $currentTab = $filters['currentTab'] ?? '';

        return $q
            // filter trips by keyword search
            ->when($keyword, function ($query) use ($keyword) {
                $query->join('trip_days', 'trip_days.trip_id', '=', 'trips.id')
                    ->join('tour_guides', 'tour_guides.id', '=', 'trip_days.tour_guide_id')
                    ->select('trips.*')
                    ->distinct('trips.id')
                    ->where(function ($q) use ($keyword) {
                        $q->where('source', 'LIKE', '%' . $keyword . '%')
                            ->orWhere('trips.comment', 'LIKE', '%' . $keyword . '%')
                            ->orWhere('tour_guides.name', 'LIKE', '%' . $keyword . '%');
                    });
            })
            ->when($client, fn ($q) => $q->where('source', $client))
            ->when($currentTab, function ($q) use ($currentTab) {
                if ($currentTab == 'active') return $q->where('trips.end_date', '>=', now());
                if ($currentTab == 'not-invoiced') return $q->whereNull('trips.invoiced_at')->where('trips.end_date', '<=', now());
                if ($currentTab == 'completed') return $q->whereNotNull('trips.invoiced_at')->where('total_cost', '>', 0);
                if ($currentTab == 'cancelled') return $q->where('is_cancelled', true);
            });
    }
}
