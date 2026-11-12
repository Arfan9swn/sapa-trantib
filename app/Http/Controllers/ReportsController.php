<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use App\Models\Reps;
use App\Models\RepsMedia;
use App\Models\SubCat;
use Illuminate\Http\Request;
class ReportsController extends Controller
{
    /** Display a listing of the reports (for admin). */
    public function admin()
    {
        $reports = Reps::latest()->get();
        return view('reports.admin', compact('reports'));
    }

    /** Show the report creation form. */
    public function create(Request $request)
    {
        $categories = Cat::all();
        $categoryId = $request->query('category_id');
        $subCategories = $categoryId
            ? SubCat::where('category_id', $categoryId)->get()
            : collect();

        return view('reports.create', compact('categories', 'subCategories', 'categoryId'));
    }

    /** Get subcategories for a category (AJAX). */
    public function getSubCategories(Request $request)
    {
        $categoryId = $request->query('category_id');
        $subCategories = SubCat::where('category_id', $categoryId)->get();

        return response()->json($subCategories);
    }

    /** Store a new report. */
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
            'reporter_rt' => 'nullable|string|max:10',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
            'boosts' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $report = Reps::create($validated);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('reports', 'public');
            RepsMedia::create([
                'report_id' => $report->report_id,
                'media_url' => $path,
                'media_type' => $request->file('image')->getMimeType(),
                'uploaded_at' => now(),
            ]);
        }

        return redirect()->route('reports.admin')
            ->with('success', 'Laporan berhasil dibuat.');
    }

    /** Store a new report as warga/guest. */
    public function wargaStore(Request $request)
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
            'reporter_rt' => 'nullable|string|max:10',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
            'boosts' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $report = Reps::create($validated);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('reports', 'public');
            RepsMedia::create([
                'report_id' => $report->report_id,
                'media_url' => $path,
                'media_type' => $request->file('image')->getMimeType(),
                'uploaded_at' => now(),
            ]);
        }

        return redirect()->route('reports.index')
            ->with('success', 'Laporan berhasil dibuat sebagai warga/guest.');
    }

    /** Show warga/guest report creation form. */
    public function wargaCreate(Request $request)
    {
        $categories = Cat::all();
        $categoryId = $request->query('category_id');
        $subCategories = $categoryId
            ? SubCat::where('category_id', $categoryId)->get()
            : collect();

        return view('reports.warga-create', compact('categories', 'subCategories', 'categoryId'));
    }

    /** Delete a report. */
    public function destroy(Request $request, Reps $report)
    {
        $report->delete(); // Delete cascades to media, comments, activities

        return redirect()->route('reports.admin')
            ->with('success', 'Laporan berhasil dihapus.');
    }
}
 
