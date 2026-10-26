<?php

namespace App\Http\Controllers;

use App\Models\RepsComment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RepsCommentController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(RepsComment::with('report')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'report_id' => 'required|exists:reports,report_id',
            'body' => 'required|string',
            'created_at' => 'required|date',
        ]);

        $comment = RepsComment::create($validated);

        return response()->json($comment->load('report'), 201);
    }

    public function show(RepsComment $comment): JsonResponse
    {
        return response()->json($comment->load('report'));
    }

    public function update(Request $request, RepsComment $comment): JsonResponse
    {
        $validated = $request->validate([
            'report_id' => 'sometimes|exists:reports,report_id',
            'body' => 'sometimes|string',
            'created_at' => 'sometimes|date',
        ]);

        $comment->update($validated);

        return response()->json($comment);
    }

    public function destroy(RepsComment $comment): JsonResponse
    {
        $comment->delete();

        return response()->json(['message' => 'Komentar berhasil dihapus']);
    }
}