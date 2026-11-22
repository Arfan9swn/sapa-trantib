<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserTagController extends Controller
{
    protected function authenticateAdmin()
    {
        $userRole = Session::get('auth_user_role') ?? 'warga';
        if (!in_array($userRole, ['admin', 'super_admin'])) {
            return redirect()->route('admin.login')->withErrors(['error' => 'Akses admin diperlukan.']);
        }
    }

    public function index()
    {
        $authCheck = $this->authenticateAdmin();
        if ($authCheck) {
            return $authCheck;
        }

        $tags = UserTag::orderBy('name')->get();
        $users = User::orderBy('username')->get();

        $userRole = Session::get('auth_user_role') ?? 'warga';
        $isSuperAdmin = $userRole === 'super_admin';

        return view('user-tags.index', compact('tags', 'users', 'isSuperAdmin'));
    }

    public function create()
    {
        $authCheck = $this->authenticateAdmin();
        if ($authCheck) {
            return $authCheck;
        }

        return view('user-tags.create');
    }

    public function store(Request $request)
    {
        $authCheck = $this->authenticateAdmin();
        if ($authCheck) {
            return $authCheck;
        }

        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:user_tags,name',
            'color' => 'required|string|max:20',
        ]);

        UserTag::create([
            'name' => $validated['name'],
            'color' => $validated['color'],
        ]);

        return redirect()->route('admin-user-tags.index')
            ->with('success', 'User tag berhasil dibuat.');
    }

    public function edit(UserTag $tag)
    {
        $authCheck = $this->authenticateAdmin();
        if ($authCheck) {
            return $authCheck;
        }

        return view('user-tags.edit', compact('tag'));
    }

    public function update(Request $request, UserTag $tag)
    {
        $authCheck = $this->authenticateAdmin();
        if ($authCheck) {
            return $authCheck;
        }

        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:user_tags,name,' . $tag->tag_id . ',tag_id',
            'color' => 'required|string|max:20',
        ]);

        $tag->update([
            'name' => $validated['name'],
            'color' => $validated['color'],
        ]);

        return redirect()->route('admin-user-tags.index')
            ->with('success', 'User tag berhasil diperbarui.');
    }

    public function destroy(UserTag $tag)
    {
        $authCheck = $this->authenticateAdmin();
        if ($authCheck) {
            return $authCheck;
        }

        $tag->delete();

        return redirect()->route('admin-user-tags.index')
            ->with('success', 'User tag berhasil dihapus.');
    }

    public function apply(Request $request)
    {
        $authCheck = $this->authenticateAdmin();
        if ($authCheck) {
            return $authCheck;
        }

        $validated = $request->validate([
            'tag_id' => 'required|integer|exists:user_tags,tag_id',
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'integer|exists:users,user_id',
        ]);

        $tag = UserTag::findOrFail($validated['tag_id']);

        User::whereIn('user_id', $validated['user_ids'])->update([
            'user_type' => $tag->name,
            'user_type_color' => $tag->color,
        ]);

        return redirect()->route('admin-user-tags.index')
            ->with('success', 'Tag berhasil diterapkan ke ' . count($validated['user_ids']) . ' pengguna.');
    }
}
