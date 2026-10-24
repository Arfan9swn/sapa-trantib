<?php

namespace App\Http\Controllers;

use App\Models\Reps;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RepsController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Reps::with('category', 'subCategory', 'assignedUser', 'media', 'comments', 'activities')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'reference_code' => 'required|string|max:12|unique:reports',
            'title' => 'required|string|max:50',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,category_id',
            'sub_category_id' => 'required|exists:sub_categories,sub_category_id',
            'status' => 'sometimes|in:pending,resolved,rejected',
            'reporter_name' => 'required|string|max:100',
            'reporter_phone_number' => 'sometimes|string|max:20',
            'reporter_location' => 'required|string',
            'reporter_rt' => 'required|integer',
            'latitude' => 'sometimes|numeric',
            'longitude' => 'sometimes|numeric',
            'boosts' => 'sometimes|integer',
            'assigned_to' => 'sometimes|exists:users,user_id',
            'submitted_at' => 'required|date',
            'resolved_at' => 'sometimes|date',
            'resolution_note' => 'sometimes|string',
        ]);

        $rep = Reps::create($validated);

        return response()->json($rep->load('category', 'subCategory', 'assignedUser'), 201);
    }

    public function show(Reps $rep): JsonResponse
    {
        return response()->json($rep->load('category', 'subCategory', 'assignedUser', 'media', 'comments', 'activities'));
    }

    public function update(Request $request, Reps $rep): JsonResponse
    {
        $validated = $request->validate([
            'reference_code' => 'sometimes|string|max:12|unique:reports,reference_code,' . $rep->report_id,
            'title' => 'sometimes|string|max:50',
            'description' => 'sometimes|string',
            'category_id' => 'sometimes|exists:categories,category_id',
            'sub_category_id' => 'sometimes|exists:sub_categories,sub_category_id',
            'status' => 'sometimes|in:pending,resolved,rejected',
            'reporter_name' => 'sometimes|string|max:100',
            'reporter_phone_number' => 'sometimes|string|max:20',
            'reporter_location' => 'sometimes|string',
            'reporter_rt' => 'sometimes|integer',
            'latitude' => 'sometimes|numeric',
            'longitude' => 'sometimes|numeric',
            'boosts' => 'sometimes|integer',
            'assigned_to' => 'sometimes|exists:users,user_id',
            'submitted_at' => 'sometimes|date',
            'resolved_at' => 'sometimes|date',
            'resolution_note' => 'sometimes|string',
        ]);

        $rep->update($validated);

        return response()->json($rep->load('category', 'subCategory', 'assignedUser'));
    }

    public function destroy(Reps $rep): JsonResponse
    {
        $rep->delete();

        return response()->json(['message' => 'Laporan berhasil dihapus']);
    }
}