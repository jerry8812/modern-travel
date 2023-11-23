<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TourGuide;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class TourGuideController extends Controller
{
    public function index(Request $request)
    {

        $date = now()->addMonths($request->sequenceOfMonth ?? 0);
        $year = $date->year;
        $month = $date->month;
        $calendarDays = $this->generateCalendar($year, $month);
        // first day of first month
        $firstDayOfFirstMonth = Carbon::createFromDate($year, $month, 1);
        // last day of second month
        $endDayOfLastMonth = Carbon::createFromDate($year, $month + 1, 1)->lastOfMonth();

        // get tour guides with trip days within above date range
        $tourGuides = TourGuide::with(['tripDays' => fn ($q) => $q->whereBetween('date', [$firstDayOfFirstMonth, $endDayOfLastMonth])])
            ->whereHas('tripDays', fn ($q) => $q->where('date', '>', now()))
            ->when($request->tour_guide_id, fn ($q) => $q->where('id', $request->tour_guide_id))
            ->get();

        foreach ($tourGuides as $tourGuide) {
            $tourGuide->setAttribute('months', $calendarDays);
        }
        return $tourGuides;
    }

    public function destroy(TourGuide $tourGuide)
    {
        $tourGuide->delete();
    }

    /**
     * generate calendar views of given month and the next month
     * 
     * @param int $year 
     * @param int $month 
     * @return Collection<array-key, (string|Collection<array-key, (string|bool)[]>)[]> name of month, and days in month
     */
    private function generateCalendar(int $year, int $month)
    {
        // two months calendar views 
        return collect(range(0, 1))->map(function ($monthNumber) use ($year, $month) {
            $firstDayOfMonth = Carbon::createFromDate($year, $monthNumber + $month, 1);
            // get the first day of the calendar view
            $startOfCalendar = $firstDayOfMonth->copy()->startOfWeek(Carbon::MONDAY);
            // get the last day of the calendar view
            $endOfCalendar = $firstDayOfMonth->copy()->lastOfMonth()->endOfWeek(Carbon::SUNDAY);


            // transform each of these items into an array representing the calendar view for that month
            $days = collect(range(0, $startOfCalendar->diffInDays($endOfCalendar)))
                ->map(function ($dayNumber) use ($startOfCalendar, $firstDayOfMonth) {
                    $date = $startOfCalendar->copy()->addDays($dayNumber);
                    return [
                        'date' => $date->format('Y-m-d'),
                        'isCurrentMonth' => $date->month == $firstDayOfMonth->month,
                        'isToday' => $date->isToday()
                    ];
                });

            return [
                'name' => $firstDayOfMonth->format('F Y'),
                'days'      => $days
            ];
        });
    }
}
