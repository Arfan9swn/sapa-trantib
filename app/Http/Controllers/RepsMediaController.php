<?php

namespace App\Http\Controllers;

use App\Models\RepsMedia;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

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
            'file' => 'required|file|max:10240', //10MB
            'media_type' => 'sometimes|string|max:20',
            'uploaded_at' => 'sometimes|date',
        ]);

        $path = $request->file('file')->store('media', 'public');

        $media = RepsMedia::create([
            'report_id' => $validated['report_id'],
            'media_url' => $path,
            'media_type' => $validated['media_type'] ?? $request->file('file')->getMimeType(),
            'uploaded_at' => $validated['uploaded_at'] ?? now(),
        ]);

        return response()->json($media->load('report'), 201);
    }

    public function show(RepsMedia $media): JsonResponse
    {
        return response()->json($media->load('report'));
    }

    public function update(Request $request, RepsMedia $media): JsonResponse
    {
        $validated = $request->validate([
            'report_id' => 'sometimes|exists:reports,report_id',
            'file' => 'sometimes|file|max:10240',
            'media_type' => 'sometimes|string|max:20',
            'uploaded_at' => 'sometimes|date',
        ]);

        if ($request->hasFile('file')) {
            if ($media->media_url && Storage::disk('public')->exists($media->media_url)) {
                Storage::disk('public')->delete($media->media_url);
            }

            $path = $request->file('file')->store('media', 'public');
            $validated['media_url'] = $path;
            $validated['media_type'] = $validated['media_type'] ?? $request->file('file')->getMimeType();
        }

        $media->update($validated);

        return response()->json($media->load('report'));
    }

    public function destroy(RepsMedia $media): JsonResponse
    {
        if ($media->media_url && Storage::disk('public')->exists($media->media_url)) {
            Storage::disk('public')->delete($media->media_url);
        }

        $media->delete();

        return response()->json(['message' => 'Media berhasil dihapus']);
    }
}