<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminLoginController extends Controller
{
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password_hash)) {
            return back()
                ->withErrors(['email' => 'Kredensial admin tidak sesuai.'])
                ->withInput();
        }

        if (! in_array($user->role, ['admin', 'super_admin'])) {
            return back()
                ->withErrors(['email' => 'Akun ini tidak memiliki hak akses admin.'])
                ->withInput();
        }

        if ($user->email_verified_at === null) {
            return back()
                ->withErrors(['email' => 'Akun Anda masih menunggu verifikasi dari super admin.'])
                ->withInput();
        }

        $request->session()->put('auth_user_id', $user->user_id);
        $request->session()->put('auth_user_role', $user->role);
        $request->session()->regenerate();

        return redirect()->intended(route('reports.admin'));
    }
}