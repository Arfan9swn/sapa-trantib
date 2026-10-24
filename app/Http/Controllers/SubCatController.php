<?php

namespace App\Http\Controllers;

use App\Models\SubCat;
use App\Models\Cat;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SubCatController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(SubCat::with('category', 'reports')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,category_id',
            'name' => 'required|string|max:100|unique:sub_categories',
        ]);

        $subCat = SubCat::create($validated);

        return response()->json($subCat, 201);
    }

    public function show(SubCat $subCat): JsonResponse
    {
        return response()->json($subCat->load('category', 'reports'));
    }

    public function update(Request $request, SubCat $subCat): JsonResponse
    {
        $validated = $request->validate([
            'category_id' => 'sometimes|exists:categories,category_id',
            'name' => 'sometimes|string|max:100|unique:sub_categories,name,' . $subCat->sub_category_id,
        ]);

        $subCat->update($validated);

        return response()->json($subCat);
    }

    public function destroy(SubCat $subCat): JsonResponse
    {
        $subCat->delete();

        return response()->json(['message' => 'Sub kategori berhasil dihapus']);
    }
}