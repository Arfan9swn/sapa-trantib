<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class WargaLoginController extends Controller
{
    /**
     * Show the warga/guest login form.
     *
     * Input field: active phone number only.
     */
    public function create()
    {
        return view('auth.warga-login');
    }

    /**
     * Authenticate a warga/guest by phone number.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'phone_number' => 'required|string|max:25',
        ]);

        $user = User::where('phone_number', $validated['phone_number'])
            ->where('role', 'warga')
            ->first();

        if (! $user) {
            return back()
                ->withErrors(['phone_number' => 'Nomor telepon tidak terdaftar. Silakan daftar terlebih dahulu.'])
                ->withInput();
        }

        $request->session()->put('auth_user_id', $user->user_id);
        $request->session()->put('auth_user_role', $user->role);
        $request->session()->put('auth_user_name', $user->full_name);
        $request->session()->put('auth_user_phone', $user->phone_number);
        $request->session()->regenerate();

        return redirect()->intended(route('warga.reports.create'))
            ->with('status', 'Selamat datang kembali, ' . e($user->full_name) . '.');
    }
}
