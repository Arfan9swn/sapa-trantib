<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WargaRegisterController extends Controller
{
    /**
     * Show the warga/guest registration form.
     *
     * Input fields: Government name (full_name) and active phone number only.
     */
    public function create()
    {
        return view('auth.warga-register');
    }

    /**
     * Register a new warga/guest account.
     *
     * Only Government name and phone number are collected.
     * No email or password is required for warga accounts.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name'     => 'required|string|max:255',
            'phone_number'  => 'required|string|max:25|unique:users,phone_number',
        ]);

        // Generate username from full name (replace spaces with underscores, lowercase)
        $username = strtolower(str_replace(' ', '_', $validated['full_name']));

        $user = User::create([
            'full_name'      => $validated['full_name'],
            'phone_number'   => $validated['phone_number'],
            'username'       => $username,
            'email'          => null,
            'password_hash'  => null,
            'role'           => 'warga',
        ]);

        // Log the warga in via custom session (same keys as admin auth)
        $request->session()->put('auth_user_id', $user->user_id);
        $request->session()->put('auth_user_role', $user->role);
        $request->session()->put('auth_user_name', $user->full_name);
        $request->session()->put('auth_user_phone', $user->phone_number);
        $request->session()->regenerate();

        return redirect()->route('reports.create')
            ->with('status', 'Selamat datang, ' . e($user->full_name) . '. Akun warga Anda telah aktif.');
    }
}
