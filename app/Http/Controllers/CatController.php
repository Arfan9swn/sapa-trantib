<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CatController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Cat::with('subCategories', 'reports')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:categories',
        ]);

        $category = Cat::create($validated);

        return response()->json($category, 201);
    }

    public function show(Cat $category): JsonResponse
    {
        return response()->json($category->load('subCategories', 'reports'));
    }

    public function update(Request $request, Cat $category): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:50|unique:categories,name,' . $category->category_id,
        ]);

        $category->update($validated);

        return response()->json($category);
    }

    public function destroy(Cat $category): JsonResponse
    {
        $category->delete();

        return response()->json(['message' => 'Kategori berhasil dihapus']);
    }
}