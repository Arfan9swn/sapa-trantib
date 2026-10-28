@extends('layout.app')

@section('title', 'Verifikasi Admin - SapaTrantib')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white">Verifikasi Admin</h1>
        <p class="text-white/60 mt-1">
            Daftar admin yang belum diverifikasi oleh super admin.
        </p>
    </div>

    @if(session('status'))
    <div class="mb-4 p-3 rounded-xl bg-green-500/10 border border-green-500/20 text-green-400 text-sm">
        {{ session('status') }}
    </div>
    @endif

    @if($errors->any())
    <div class="mb-4 p-3 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
        {{ $errors->first() }}
    </div>
    @endif

    <div class="bg-[#2d4a3a] rounded-xl border border-[#4a6a56] overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-[#4a6a56]">
                    <th class="px-4 py-3 text-white/70 text-sm font-medium">Nama</th>
                    <th class="px-4 py-3 text-white/70 text-sm font-medium">Email</th>
                    <th class="px-4 py-3 text-white/70 text-sm font-medium">Role</th>
                    <th class="px-4 py-3 text-white/70 text-sm font-medium">Dibuat</th>
                    <th class="px-4 py-3 text-white/70 text-sm font-medium text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if($pendingAdmins->isEmpty())
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-white/50">
                        Tidak ada admin yang menunggu verifikasi.
                    </td>
                </tr>
                @else
                @foreach($pendingAdmins as $admin)
                <tr class="border-b border-[#4a6a56]/50 last:border-0">
                    <td class="px-4 py-3 text-white">{{ $admin->username }}</td>
                    <td class="px-4 py-3 text-white/80">{{ $admin->email }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded bg-[#4a6a56] text-white/80 text-xs">
                            {{ ucfirst($admin->role) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-white/50 text-sm">
                        {{ $admin->created_at ? $admin->created_at->format('d M Y H:i') : '-' }}
                    </td>
                    <td class="px-4 py-3 text-center">
                        <form action="{{ route('admin.verify', $admin->user_id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                    class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-medium rounded transition-colors">
                                Verifikasi
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection