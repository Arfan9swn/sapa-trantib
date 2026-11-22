<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(User::all());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'username' => 'required|string|max:50|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password_hash' => 'required|string',
            // Perbolehkan kosong/null, atau batasi hanya untuk mengubah role ke admin/super_admin oleh sistem tertentu
            'role' => 'nullable|in:super_admin,admin', 
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'email' => $email = $validated['email'],
            'password_hash' => Hash::make($validated['password_hash']),
            // Ubah default-nya menjadi null atau kosong agar menjadi pengguna biasa (non-admin)
            'role' => $validated['role'] ?? null, 
        ]);

        return response()->json($user, 201);
    }

    public function show(User $user): JsonResponse
    {
        return response()->json($user);
    }

    public function update(Request $request, User $user): JsonResponse
    {
        $validated = $request->validate([
            'username' => 'sometimes|string|max:50|unique:users,username,' . $user->user_id,
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->user_id,
            'password_hash' => 'sometimes|string',
            'role' => 'nullable|in:super_admin,admin',
        ]);

        if (isset($validated['password_hash'])) {
            $validated['password_hash'] = Hash::make($validated['password_hash']);
        }

        $user->update($validated);

        return response()->json($user);
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json(['message' => 'Pengguna berhasil dihapus']);
    }
}