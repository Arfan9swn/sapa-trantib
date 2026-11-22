<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use App\Models\NewResidenceReport;
use App\Models\Reps;
use App\Models\RepsMedia;
use App\Models\SubCat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
            'status' => 'required|in:pending,resolved,rejected',
            'reporter_name' => 'required|string|max:100',
            'reporter_phone_number' => 'nullable|string|max:20',
            'reporter_location' => 'nullable|string|max:255',
            'reporter_rt' => 'nullable|string|max:10',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
            'boosts' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if (empty($validated['sub_category_id'])) {
            $validated['sub_category_id'] = null;
        }

        if ($validated['status'] === 'resolved') {
            $validated['resolved_at'] = now();
        }

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
        $request->merge([
            'status'                => $request->input('status', 'pending'),
            'reporter_name'         => $request->input('reporter_name', session('auth_user_name', 'Warga')),
            'reporter_phone_number' => session('auth_user_phone', ''),
            'sub_category_id'       => $request->filled('sub_category_id') ? $request->input('sub_category_id') : null,
        ]);

        $validator = Validator::make($request->all(), [
            'title'                  => 'required|string|max:255',
            'description'            => 'nullable|string',
            'category_id'            => 'nullable|exists:categories,category_id',
            'sub_category_id'        => 'nullable|exists:sub_categories,sub_category_id',
            'status'                 => 'required|in:pending,resolved,rejected',
            'reporter_name'          => 'required|string|max:100',
            'reporter_phone_number'  => 'nullable|string|max:20',
            'reporter_location'      => 'nullable|string|max:255',
            'reporter_rt'            => 'nullable|string|max:10',
            'latitude'               => 'nullable|string',
            'longitude'              => 'nullable|string',
            'boosts'                 => 'nullable|integer',
            'image'                  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('warga.reports.create')
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        $now = now();
        $validated['submitted_at']   = $now;
        $validated['created_at']     = $now;
        $validated['updated_at']     = $now;
        $validated['reference_code'] = 'WRG-' . strtoupper(substr(uniqid(), -8));

        if ($validated['status'] === 'resolved') {
            $validated['resolved_at'] = $now;
        }

        try {
            $report = Reps::create($validated);

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('reports', 'public');
                RepsMedia::create([
                    'report_id'   => $report->report_id,
                    'media_url'   => $path,
                    'media_type'  => $request->file('image')->getMimeType(),
                    'uploaded_at' => now(),
                ]);
            }

            return redirect()->route('reports.admin')
                ->with('success', 'Laporan berhasil dikirim.');
        } catch (\Throwable $e) {
            Log::error('wargaStore error: ' . $e->getMessage(), ['exception' => $e]);

            return redirect()->route('warga.reports.create')
                ->withErrors(['report' => 'Gagal menyimpan laporan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /** Show warga/guest report creation form. */
    public function wargaCreate(Request $request)
    {
        $categories = Cat::all();
        $categoryId = $request->query('category_id');
        $subCategories = $categoryId
            ? SubCat::where('category_id', $categoryId)->get()
            : collect();

        return view('reports.create', compact('categories', 'subCategories', 'categoryId'));
    }

    /** Show new residence report creation form. */
    public function newResidenceCreate()
    {
        return view('reports.new-residence-report');
    }

    /** Store a new residence report as warga/guest. */
    public function newResidenceStore(Request $request)
    {
        $validated = $request->validate([
            'nik'            => 'required|string|max:16',
            'nama'           => 'required|string|max:100',
            'nomor_telepon'  => 'required|string|max:20',
            'alamat'         => 'required|string|max:255',
        ]);

        try {
            $report = NewResidenceReport::create([
                'user_id'        => session('auth_user_id'),
                'nik'            => $validated['nik'],
                'nama'           => $validated['nama'],
                'nomor_telepon'  => $validated['nomor_telepon'],
                'alamat'         => $validated['alamat'],
                'status'         => 'pending',
            ]);

            return redirect()->route('reports.index')
                ->with('success', 'Laporan penduduk baru berhasil dibuat.');
        } catch (\Exception $e) {
            \Log::error('newResidenceStore error: ' . $e->getMessage(), ['exception' => $e]);

            return redirect()->route('warga.reports.create.new-residence')
                ->withErrors(['report' => 'Gagal menyimpan laporan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /** Update report status (admin/super_admin only). */
    public function updateStatus(Request $request, Reps $report)
    {
        $userRole = session('auth_user_role') ?? '';
        if (!in_array(strtolower($userRole), ['admin', 'super_admin'], true)) {
            return back()->with('error', 'Hanya admin yang dapat mengubah status laporan.');
        }

        $request->validate([
            'status' => 'required|in:pending,resolved,rejected',
        ]);

        $report->status = $request->status;
        if ($request->status === 'resolved') {
            $report->resolved_at = now();
        } else {
            $report->resolved_at = null;
        }
        $report->save();

        return back()->with('success', 'Status laporan berhasil diubah.');
    }

    /** Delete a report. */
    public function destroy(Request $request, Reps $report)
    {
        $userRole = session('auth_user_role') ?? '';
        $userPhone = session('auth_user_phone') ?? '';

        if (!in_array(strtolower($userRole), ['admin', 'super_admin'], true)) {
            if (strtolower($report->reporter_phone_number) !== strtolower($userPhone)) {
                return back()->with('error', 'Anda tidak memiliki izin menghapus laporan ini.');
            }
        }

        $report->delete();

        return redirect()->route('reports.admin')->with('success', 'Laporan berhasil dihapus.');
    }
}