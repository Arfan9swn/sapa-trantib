@extends('layout.app')

@section('title', 'User Show - SapaTrantib')

@section('content')
@php
    $userRole = session('auth_user_role') ?? 'warga';
    $isSuperAdmin = $userRole === 'super_admin';
    $currentUserId = session('auth_user_id');
    
@endphp

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-white">Detail pengguna</h1>
            <p class="text-white/60 text-sm">Detail akun pengguna</p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('admin-users.index') }}" class="px-6 py-3 rounded-xl bg-[#4a6a56] text-white text-sm font-medium hover:bg-[#4a6a56]/80 transition-colors w-full sm:w-auto text-center sm:text-left">Kembali</a>

            <form action="{{ route('admin-users.destroy', $user->user_id) }}" method="POST" class="inline w-full sm:w-auto" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full px-6 py-3 rounded-xl bg-[#a63d3d] text-white text-sm font-medium hover:bg-[#8f3333] transition-colors">Hapus user</button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-200 text-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-200 text-sm">{{ session('error') }}</div>
    @endif

    <div class="bg-[#2d4a3a] rounded-2xl border border-[#4a6a56] overflow-hidden shadow-lg">
        <div class="p-6">
            <div class="mb-4 flex items-center justify-between">
                <span class="text-xs font-semibold text-[#8fd89b] uppercase tracking-wider">Detail akun</span>
                <a href="{{ route('admin-users.edit', $user->user_id) }}" class="text-sm text-emerald-400 hover:text-emerald-300 transition-colors">Edit pengguna</a>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs text-white/60 uppercase tracking-wider mb-1">Nama</label>
                    <div class="bg-white/5 rounded-xl p-3 border border-white/10">
                        <p class="text-white text-sm">{{ $user->username }}</p>
                    </div>
                </div>

                <div>
                    <label class="block text-xs text-white/60 uppercase tracking-wider mb-1">Password</label>
                    <div class="bg-white/5 rounded-xl p-3 border border-white/10">
                        <p class="text-white text-sm">••••••••</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-white/60 uppercase tracking-wider mb-1">Role</label>
                        <div class="bg-white/5 rounded-xl p-3 border border-white/10">
                            <span class="px-2 py-1 rounded bg-[#4a6a56] text-white/80 text-xs font-medium uppercase">{{ strtolower($user->role) }}</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs text-white/60 uppercase tracking-wider mb-1">Email</label>
                        <div class="bg-white/5 rounded-xl p-3 border border-white/10">
                            <p class="text-white text-sm">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-white/60 uppercase tracking-wider mb-1">ID Pengguna</label>
                        <div class="bg-white/5 rounded-xl p-3 border border-white/10">
                            <p class="text-white text-sm font-mono">{{ $user->user_id }}</p>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs text-white/60 uppercase tracking-wider mb-1">Dibuat pada</label>
                        <div class="bg-white/5 rounded-xl p-3 border border-white/10">
                            <p class="text-white text-sm">{{ $user->created_at ? $user->created_at->format('d M Y H:i') : '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection