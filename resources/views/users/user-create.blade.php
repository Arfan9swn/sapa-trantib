@extends('layout.app')

@section('title', 'Create User - SapaTrantib')

@section('content')
@php
    $userRole = session('auth_user_role') ?? 'warga';
    $isSuperAdmin = $userRole === 'super_admin';
@endphp

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-white">Tambah pengguna</h1>
            <p class="text-white/60 text-sm">Buat akun pengguna baru</p>
        </div>

        <a href="{{ route('admin-users.index') }}" class="inline-flex items-center justify-center px-6 py-3 text-sm font-medium text-white bg-[#4b6b43] rounded-xl hover:bg-[#3d5835] transition-colors">← Kembali ke daftar user</a>
    </div>

    @if($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-200 text-sm">
            <ul class="list-disc list-inside">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="bg-[#2d4a3a] rounded-2xl border border-[#4a6a56] p-8 sm:p-12 shadow-xl">
        <form action="{{ route('admin-users.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-medium text-white/90 mb-2">Nama pengguna</label>
                <input type="text" name="username" value="{{ old('username') }}"
                    placeholder="Masukkan nama pengguna..."
                    class="w-full px-4 py-3 rounded-xl bg-white text-[#1a3326] text-base border-0 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors">
            </div>

            <div>
                <label class="block text-sm font-medium text-white/90 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    placeholder="Masukkan email..."
                    class="w-full px-4 py-3 rounded-xl bg-white text-[#1a3326] text-base border-0 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors">
            </div>

            <div>
                <label class="block text-sm font-medium text-white/90 mb-2">Password</label>
                <input type="password" name="password"
                    placeholder="••••••••"
                    class="w-full px-4 py-3 rounded-xl bg-white text-[#1a3326] text-base border-0 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors">
            </div>

            <div>
                <label class="block text-sm font-medium text-white/90 mb-2">Role</label>
                <select name="role" class="w-full px-4 py-3 rounded-xl bg-white text-[#1a3326] text-base border-0 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors">
                    <option value="admin">Admin</option>
                    <option value="super_admin">Super Admin</option>
                </select>
            </div>

<div>
                <label class="block text-sm font-medium text-white/90 mb-2">User Type</label>
                <select name="user_type" class="w-full px-4 py-3 rounded-xl bg-white text-[#1a3326] text-base border-0 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors">
                    <option value="warga">Warga</option>
                    <option value="petugas">Petugas</option>
                    <option value="vip">VIP</option>
                    <option value="moderator">Moderator</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-white/90 mb-2">Warna Tag</label>
                <input type="color" name="user_type_color" value="#6366f1" class="w-full px-4 py-3 rounded-xl bg-white text-[#1a3326] text-base border-0 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors">
                <p class="text-white/60 text-sm mt-1">Pilih warna untuk tag pengguna</p>
            </div>
            <div class="pt-4 flex flex-col sm:flex-row gap-3">
                <a href="{{ route('admin-users.index') }}"
                    class="flex-1 sm:w-auto px-6 py-3 rounded-xl border border-white/20 text-white text-sm font-medium text-center hover:bg-white/10 transition-colors">
                    Batal
                </a>
                <button type="submit"
                    class="flex-1 sm:w-auto py-3 rounded-xl bg-emerald-600 text-white font-semibold text-sm hover:bg-emerald-500 transition-colors">
                    Buat Pengguna
                </button>
            </div>
        </form>
    </div>

</div>
@endsection