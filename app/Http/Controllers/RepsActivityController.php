<?php

namespace App\Http\Controllers;

use App\Models\RepsActivity;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RepsActivityController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(RepsActivity::with('report', 'user')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'report_id' => 'required|exists:reports,report_id',
            'user_id' => 'sometimes|exists:users,user_id',
            'action' => 'required|string|max:50',
            'old_value' => 'sometimes|string',
            'new_value' => 'sometimes|string',
            'created_at' => 'required|date',
        ]);

        $activity = RepsActivity::create($validated);

        return response()->json($activity->load('report', 'user'), 201);
    }

    public function show(RepsActivity $activity): JsonResponse
    {
        return response()->json($activity->load('report', 'user'));
    }

    public function update(Request $request, RepsActivity $activity): JsonResponse
    {
        $validated = $request->validate([
            'report_id' => 'sometimes|exists:reports,report_id',
            'user_id' => 'sometimes|exists:users,user_id',
            'action' => 'sometimes|string|max:50',
            'old_value' => 'sometimes|string',
            'new_value' => 'sometimes|string',
            'created_at' => 'sometimes|date',
        ]);

        $activity->update($validated);

        return response()->json($activity);
    }

    public function destroy(RepsActivity $activity): JsonResponse
    {
        $activity->delete();

        return response()->json(['message' => 'Aktivitas berhasil dihapus']);
    }
}