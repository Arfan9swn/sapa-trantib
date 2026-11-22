@extends('layout.app')

@section('title', 'Tambah User Tag - SapaTrantib')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('admin-user-tags.index') }}" class="inline-flex items-center text-sm text-white/70 hover:text-white">← Kembali ke daftar tag</a>
    </div>
    <div class="bg-[#2d4a3a] rounded-2xl border border-[#4a6a56] p-8 shadow-xl">
        <h2 class="text-xl font-bold text-white mb-6">Tambah User Tag</h2>
        <form action="{{ route('admin-user-tags.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-medium text-white/90 mb-2">Nama Tag</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 rounded-xl bg-white text-[#1a3326] text-base border-0 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors" placeholder="cth: Kelurahan">
                @error('name')<p class="text-red-300 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-white/90 mb-2">Warna Tag</label>
                <input type="color" name="color" value="{{ old('color', '#6366f1') }}" required class="w-full h-12 rounded-xl bg-white p-2 border-0 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors">
                <p class="text-white/60 text-sm mt-1">Pilih warna kustom untuk tag</p>
                @error('color')<p class="text-red-300 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="flex gap-3 pt-4">
                <a href="{{ route('admin-user-tags.index') }}" class="flex-1 py-2 rounded-xl bg-[#4a6a56] text-white text-sm font-medium text-center hover:bg-[#3d5c4c] transition-colors">Batal</a>
                <button type="submit" class="flex-1 py-2 rounded-xl bg-emerald-600 text-white text-sm font-medium hover:bg-emerald-500 transition-colors">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection