<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserManagementController extends Controller
{
    /**
     * Ensure user is authenticated and has admin/super_admin role.
     */
    protected function authenticateAdmin()
    {
        $userRole = Session::get('auth_user_role') ?? 'warga';
        if (!in_array($userRole, ['admin', 'super_admin'])) {
            return redirect()->route('admin.login')->withErrors(['error' => 'Akses admin diperlukan.']);
        }
    }

    /**
     * List all users.
     */
    public function index(Request $request)
    {
        $authCheck = $this->authenticateAdmin();
        if ($authCheck) {
            return $authCheck;
        }

        $users = User::orderBy('user_id', 'desc')->paginate(10);
        $search = $request->input('search');

        if ($search) {
            $users = User::where('username', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orderBy('user_id', 'desc')
                ->paginate(10)
                ->appends(['search' => $search]);
        }

        $userRole = Session::get('auth_user_role') ?? 'warga';
        $isSuperAdmin = $userRole === 'super_admin';
        $currentUserId = Session::get('auth_user_id');

        return view('users.user-index', compact('users', 'search', 'isSuperAdmin', 'currentUserId'));
    }

    /**
     * Show form to create a new user.
     */
    public function create()
    {
        $authCheck = $this->authenticateAdmin();
        if ($authCheck) {
            return $authCheck;
        }

        return view('users.user-create');
    }

    /**
     * Store a new user.
     */
    public function store(Request $request)
    {
        $authCheck = $this->authenticateAdmin();
        if ($authCheck) {
            return $authCheck;
        }

        $validated = $request->validate([
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:super_admin,admin',
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password_hash' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin-users.show', $user->user_id)
            ->with('success', 'Pengguna berhasil dibuat.');
    }

    /**
     * Show user details.
     */
    public function show(User $user)
    {
        $authCheck = $this->authenticateAdmin();
        if ($authCheck) {
            return $authCheck;
        }

        $userRole = Session::get('auth_user_role') ?? 'warga';
        $isSuperAdmin = $userRole === 'super_admin';
        $currentUserId = Session::get('auth_user_id');

        if ($user->user_id == $currentUserId) {
            return redirect()->route('admin-users.index')
                ->with('info', 'Ini adalah akun Anda sendiri. Anda tidak dapat melihat detail akun sendiri.');
        }

        return view('users.user-show', compact('user', 'isSuperAdmin', 'currentUserId'));
    }

    /**
     * Show form to edit a user.
     */
    public function edit(User $user)
    {
        $authCheck = $this->authenticateAdmin();
        if ($authCheck) {
            return $authCheck;
        }

        $currentUserId = Session::get('auth_user_id');

        if ($user->user_id == $currentUserId) {
            return redirect()->route('admin-users.index')
                ->with('info', 'Ini adalah akun Anda sendiri. Anda tidak dapat mengedit akun sendiri.');
        }

        return view('users.user-edit', compact('user'));
    }

    /**
     * Update a user.
     */
    public function update(Request $request, User $user)
    {
        $authCheck = $this->authenticateAdmin();
        if ($authCheck) {
            return $authCheck;
        }

        $currentUserId = Session::get('auth_user_id');

        if ($user->user_id == $currentUserId) {
            return redirect()->route('admin-users.index')
                ->with('info', 'Ini adalah akun Anda sendiri. Anda tidak dapat mengedit akun sendiri.');
        }

        $validated = $request->validate([
            'username' => 'required|string|max:50|unique:users,username,' . $user->user_id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->user_id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:super_admin,admin',
        ]);

        $user->username = $validated['username'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];

        if (!empty($validated['password'])) {
            $user->password_hash = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin-users.show', $user->user_id)
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    /**
     * Delete a user.
     */
    public function destroy(User $user)
    {
        $authCheck = $this->authenticateAdmin();
        if ($authCheck) {
            return $authCheck;
        }

        $currentUserId = Session::get('auth_user_id');
        if ($user->user_id == $currentUserId) {
            return redirect()->route('admin-users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin-users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
