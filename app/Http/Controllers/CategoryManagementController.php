<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use App\Models\SubCat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryManagementController extends Controller
{
    public function __construct()
    {
        // Protect all methods: must be authenticated as admin or super_admin
        $this->middleware(function ($request, $next) {
            $userRole = Session::get('auth_user_role') ?? 'warga';
            if (!in_array($userRole, ['admin', 'super_admin'])) {
                return redirect()->route('admin.login')->withErrors(['error' => 'Akses admin diperlukan.']);
            }
            return $next($request);
        });
    }

    /**
     * List all categories with subcategory counts.
     */
    public function index()
    {
        $categories = Cat::withCount('subCategories')->latest()->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show form to create a new category with subcategories.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a new category with its subcategories.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:categories,name',
            'sub_categories' => 'nullable|array',
            'sub_categories.*' => 'nullable|string|max:100',
        ]);

        $category = Cat::create(['name' => $validated['name']]);

        if (!empty($validated['sub_categories'])) {
            foreach ($validated['sub_categories'] as $subName) {
                $subName = trim($subName);
                if ($subName !== '') {
                    SubCat::create([
                        'category_id' => $category->category_id,
                        'name' => $subName,
                    ]);
                }
            }
        }

        return redirect()->route('admin-categories.index')
            ->with('success', 'Kategori dan sub kategori berhasil dibuat.');
    }

    /**
     * Show form to edit a category and its subcategories.
     */
    public function edit(Cat $category)
    {
        $category->load('subCategories');
        return view('categories.edit', compact('category'));
    }

    /**
     * Update a category and its subcategories.
     */
    public function update(Request $request, Cat $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:categories,name,' . $category->category_id,
            'sub_categories' => 'nullable|array',
            'sub_categories.*' => 'nullable|string|max:100',
            'sub_category_ids' => 'nullable|array',
            'sub_category_ids.*' => 'nullable|integer|exists:sub_categories,sub_category_id',
            'deleted_sub_category_ids' => 'nullable|array',
            'deleted_sub_category_ids.*' => 'nullable|integer|exists:sub_categories,sub_category_id',
        ]);

        $category->update(['name' => $validated['name']]);

        // Handle deleted subcategories (marked for removal in edit form)
        $deletedIds = $validated['deleted_sub_category_ids'] ?? [];
        if (!empty($deletedIds)) {
            SubCat::whereIn('sub_category_id', $deletedIds)->delete();
        }

        // Remove subcategories that are no longer in the list (from sub_category_ids)
        $keepIds = $validated['sub_category_ids'] ?? [];
        if (!empty($keepIds)) {
            $category->subCategories()->whereNotIn('sub_category_id', $keepIds)->whereNotIn('sub_category_id', $deletedIds)->delete();
        } else {
            $category->subCategories()->whereNotIn('sub_category_id', $deletedIds)->delete();
        }

        // Add/update subcategories
        if (!empty($validated['sub_categories'])) {
            foreach ($validated['sub_categories'] as $index => $subName) {
                $subName = trim($subName);
                if ($subName === '') {
                    continue;
                }

                $existingId = isset($validated['sub_category_ids'][$index]) ? $validated['sub_category_ids'][$index] : null;

                if ($existingId) {
                    $subCat = SubCat::find($existingId);
                    if ($subCat && $subCat->category_id === $category->category_id) {
                        $subCat->update(['name' => $subName]);
                    }
                } else {
                    SubCat::create([
                        'category_id' => $category->category_id,
                        'name' => $subName,
                    ]);
                }
            }
        }

        return redirect()->route('admin-categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Delete a category and all its subcategories.
     */
    public function destroy(Cat $category)
    {
        $category->delete(); // cascades to sub_categories via foreign key onDelete('cascade')
        return redirect()->route('admin-categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}