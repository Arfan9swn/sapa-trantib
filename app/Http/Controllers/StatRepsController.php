<?php

namespace App\Http\Controllers;

use App\Models\Reps;
use App\Models\Cat;
use Carbon\Carbon;

class StatRepsController extends Controller
{
    /**
     * Show the statistics page with per-day report charts.
     *
     * The data is grouped per-day based on the submitted_at date. Every time
     * the day changes (tomorrow), the date continues to the next day.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // All categories used for the stacked column chart legend.
        $categories = Cat::orderBy('name')->get();

        // --- Line chart data: total reports per day ---
        $reportsPerDay = Reps::selectRaw('DATE(submitted_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->keyBy('date');

        // --- Stacked column chart data: reports per day per category ---
        $reportsPerDayPerCategory = Reps::selectRaw('DATE(submitted_at) as date, category_id, COUNT(*) as total')
            ->groupBy('date', 'category_id')
            ->orderBy('date', 'asc')
            ->get()
            ->groupBy('date');

        // Build a continuous date range from the first to the last report date
        // so the timeline keeps moving to the next day even when a day has no reports.
        $dates = [];
        $lineData = [];
        $columnDatasets = [];

        if ($categories->isNotEmpty() && Reps::count() > 0) {
            $firstDate = Carbon::parse(Reps::min('submitted_at'))->startOfDay();
            $lastDate = Carbon::parse(Reps::max('submitted_at'))->startOfDay();

            $current = clone $firstDate;
            while ($current <= $lastDate) {
                $dateKey = $current->format('Y-m-d');
                $dates[] = $dateKey;

                // Line chart value for this day.
                $dayReport = $reportsPerDay->get($dateKey);
                $lineData[] = $dayReport ? (int) $dayReport->total : 0;

                $current->addDay();
            }

            // Colour palette matching the design (Bencana Alam, Pencemaran, Pembunuhan, ...).
            $palette = [
                '#3b82f6', // blue
                '#22d3ee', // cyan/teal
                '#ef4444', // red
                '#f59e0b', // amber
                '#a855f7', // purple
                '#10b981', // emerald
                '#fb923c', // orange
            ];

            // Build one stacked dataset per category, aligned to the continuous dates.
            foreach ($categories as $index => $category) {
                $dataPoints = [];
                foreach ($dates as $dateKey) {
                    $dayCategories = $reportsPerDayPerCategory->get($dateKey, collect());
                    $found = $dayCategories->firstWhere('category_id', $category->category_id);
                    $dataPoints[] = $found ? (int) $found->total : 0;
                }

                $columnDatasets[] = [
                    'label' => $category->name,
                    'data' => $dataPoints,
                    'backgroundColor' => $palette[$index % count($palette)],
                ];
            }
        }

        $totalReports = Reps::count();

        return view('statistics.statistics', compact(
            'totalReports',
            'dates',
            'lineData',
            'categories',
            'columnDatasets'
        ));
    }
}
