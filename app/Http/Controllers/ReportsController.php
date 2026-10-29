<?php

namespace App\Http\Controllers;

use App\Models\Reps;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    /**
     * Display a listing of the reports (for admin).
     */
    public function admin()
    {
        $reports = Reps::latest()->get();
        return view('reports.admin', compact('reports'));
    }

    /**
     * Show the report creation form.
     */
    public function create()
    {
        return view('reports.create');
    }

    /**
     * Store a new report.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,category_id',
            'sub_category_id' => 'nullable|exists:sub_categories,sub_category_id',
            'status' => 'required|string|max:50',
            'reporter_name' => 'required|string|max:100',
            'reporter_phone_number' => 'nullable|string|max:20',
            'reporter_location' => 'nullable|string|max:255',
            'reporter_rt' => 'nullable|string|10',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
            'boosts' => 'nullable|integer',
        ]);

        Reps::create($validated);

        return redirect()->route('reports.admin')
            ->with('success', 'Laporan berhasil dibuat.');
    }

    /**
     * Delete a report.
     */
    public function destroy(Request $request, Reps $report)
    {
        $report->delete(); // Delete cascades to media, comments, activities

        return redirect()->route('reports.admin')
            ->with('success', 'Laporan berhasil dihapus.');
    }
}