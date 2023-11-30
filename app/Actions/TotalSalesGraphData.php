<?php

namespace App\Actions;

use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TotalSalesGraphData
{
    public function __invoke(Request $request)
    {
        $endDate = $request->endDate ?? Carbon::now();

        $trips = Trip::where('end_date', '<', $endDate)
            ->when($request->startDate, fn ($q) => $q->where('start_date', '>', $request->startDate))
            ->select(['source', DB::raw('ROUND(SUM(total_price), 2) as sales')])
            ->groupBy('source')
            ->get();

        $labels = $trips->map(function ($trip) {
            $sale = number_format($trip->sales, 2, '.', ',');
            return $trip->source . ' ($' . $sale . ')';
        });

        return [
            'labels' => $labels,
            'datasets' => $trips->pluck('sales'),
            'totalSales' => $trips->sum('sales')
        ];
    }
}
