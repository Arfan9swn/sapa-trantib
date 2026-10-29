@extends('layout.app')

@section('title', 'User List - SapaTrantib')

@section('content')
@php
    $userRole = session('auth_user_role') ?? 'warga';
    $isSuperAdmin = $userRole === 'super_admin';
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-white">List pengguna yang terdaftar</h1>
            <p class="text-white/60 text-sm">Kelola akun pengguna</p>
        </div>
        <a href="{{ route('admin-users.create') }}" class="inline-flex items-center justify-center w-full lg:w-auto px-6 py-3 text-sm font-medium text-white bg-emerald-600 rounded-xl hover:bg-emerald-500 transition-colors"><svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg> Tambah user</a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-200 text-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-200 text-sm">{{ session('error') }}</div>
    @endif
    @if(session('info'))
        <div class="mb-6 p-4 rounded-xl bg-blue-500/10 border border-blue-500/20 text-blue-200 text-sm">{{ session('info') }}</div>
    @endif
    <div class="bg-[#2d4a3a] rounded-2xl border border-[#4a6a56] overflow-hidden shadow-lg">
        <div class="p-6">
            <form action="{{ route('admin-users.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4 mb-6">
                <div class="flex-1 relative"><input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari pengguna..." class="w-full px-4 py-3 rounded-xl bg-white text-[#1a3326] text-base border-0 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors"></div>
                <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-600 text-white text-sm font-medium hover:bg-emerald-500 transition-colors whitespace-nowrap">Cari</button>
            </form>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-[#4a6a56]">
                            <th class="px-4 py-3 text-white/70 text-sm font-medium">ID</th>
                            <th class="px-4 py-3 text-white/70 text-sm font-medium">Nama</th>
                            <th class="px-4 py-3 text-white/70 text-sm font-medium">Role</th>
                            @if($isSuperAdmin)<th class="px-4 py-3 text-white/70 text-sm font-medium text-center">Aksi</th>@endif
                        </tr>
                    </thead>
                    <tbody>
                        @if($users->isEmpty())
                            <tr><td colspan="{{ $isSuperAdmin ? 4 : 3 }}" class="px-4 py-8 text-center text-white/50">Tidak ada pengguna ditemukan.</td></tr>
                        @else
                            @foreach($users as $user)
                                <?php $isOwn = $user->user_id == $currentUserId; ?>
                                <tr class="border-b border-[#4a6a56]/50 last:border-0 hover:bg-[#3d5c4c]/30 transition-colors">
                                    <td class="px-4 py-3 text-white text-sm">{{ $user->user_id }}</td>
                                    <td class="px-4 py-3 text-white text-sm">
                                        {{ $user->username }}
                                        @if($isOwn)
                                            <span class="ml-2 px-2 py-0.5 rounded bg-[#8fd89b] text-[#1a3326] text-[10px] font-bold uppercase">Anda</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm"><span class="px-2 py-1 rounded bg-[#4a6a56] text-white/80 text-xs font-medium uppercase">{{ strtolower($user->role) }}</span></td>
                                    @if($isSuperAdmin && !$isOwn)
                                        <td class="px-4 py-3 text-center">
                                            <div class="flex items-center justify-center gap-1">
                                                <a href="{{ route('admin-users.show', $user->user_id) }}" class="w-8 h-8 rounded-lg bg-[#4a6a56] flex items-center justify-center text-white/80 hover:text-white hover:bg-[#4a6a56]/80 transition-colors text-xs" title="Lihat detail"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></a>
                                                <button onclick="confirmDeleteUser({{ $user->user_id }}, '{{ $user->username }}')" class="w-8 h-8 rounded-lg bg-[#a63d3d]/20 flex items-center justify-center text-red-400/80 hover:bg-red-500/30 hover:text-red-400 transition-colors text-xs" title="Hapus"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            {{ $users->links() }}
        </div>
    </div>
</div>

<!-- Delete confirmation modal -->
<div id="deleteUserModal" class="fixed inset-0 z-50 hidden">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeDeleteUserModal()"></div>
    <div class="fixed inset-0 z-10 flex items-center justify-center">
        <div class="bg-[#2d4a3a] rounded-2xl border border-[#4a6a56] p-6 w-full max-w-sm shadow-xl">
            <h3 class="text-white font-semibold text-lg mb-1">Hapus Pengguna</h3>
            <p class="text-white/60 text-sm mb-6">Apakah Anda yakin ingin menghapus pengguna <span id="deleteUserName" class="text-white font-medium"></span>?</p>
            <form id="deleteUserForm" method="POST" class="flex gap-3">
                @csrf
                @method('DELETE')
                <input type="hidden" name="user_id" id="deleteUserId">
                <button type="button" onclick="closeDeleteUserModal()" class="flex-1 py-2 rounded-xl bg-[#4a6a56] text-white text-sm font-medium hover:bg-[#4a6a56]/80 transition-colors">Batal</button>
                <button type="submit" class="flex-1 py-2 rounded-xl bg-[#a63d3d] text-white text-sm font-medium hover:bg-[#8f3333] transition-colors">Hapus</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function confirmDeleteUser(userId, username) {
        document.getElementById('deleteUserId').value = userId;
        document.getElementById('deleteUserName').textContent = username;
        const form = document.getElementById('deleteUserForm');
        form.action = '{{ route('admin-users.destroy', 0) }}'.replace('0', userId);
        document.getElementById('deleteUserModal').classList.remove('hidden');
    }

    function closeDeleteUserModal() {
        document.getElementById('deleteUserModal').classList.add('hidden');
    }
</script>
@endpush

@endsection