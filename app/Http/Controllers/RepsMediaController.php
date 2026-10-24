<?php

namespace App\Http\Controllers;

use App\Models\RepsMedia;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RepsMediaController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(RepsMedia::with('report')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'report_id' => 'required|exists:reports,report_id',
            'media_url' => 'required|string',
            'media_type' => 'required|string|max:20',
            'uploaded_at' => 'required|date',
        ]);

        $media = RepsMedia::create($validated);

        return response()->json($media, 201);
    }

    public function show(RepsMedia $media): JsonResponse
    {
        return response()->json($media->load('report'));
    }

    public function update(Request $request, RepsMedia $media): JsonResponse
    {
        $validated = $request->validate([
            'report_id' => 'sometimes|exists:reports,report_id',
            'media_url' => 'sometimes|string',
            'media_type' => 'sometimes|string|max:20',
            'uploaded_at' => 'sometimes|date',
        ]);

        $media->update($validated);

        return response()->json($media);
    }

    public function destroy(RepsMedia $media): JsonResponse
    {
        $media->delete();

        return response()->json(['message' => 'Media berhasil dihapus']);
    }
}