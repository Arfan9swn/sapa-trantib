@extends('layout.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="max-w-md mx-auto">
        <div class="bg-[#3d5c4c] rounded-2xl p-6 shadow-2xl border border-[#4a6a56]">
            <div class="mb-6">
                <h2 class="text-xl font-bold text-white mb-1">Tambah RT Baru</h2>
                <p class="text-emerald-200 text-sm">Silahkan lengkapi form berikut untuk menambahkan RT.</p>
            </div>
            
            <form action="{{ route('rts.store') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="head_name" class="block text-white font-medium text-sm mb-2">Kepala RT</label>
                    <input type="text" name="head_name" id="head_name" class="w-full px-4 py-3 bg-[#1a3326] border border-[#4a6a56] rounded-lg text-white focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/30 transition-all" placeholder="Nama kepala RT" required>
                </div>
                
                <div class="mb-4">
                    <label for="rt_number" class="block text-white font-medium text-sm mb-2">No. RT</label>
                    <input type="text" name="rt_number" id="rt_number" class="w-full px-4 py-3 bg-[#1a3326] border border-[#4a6a56] rounded-lg text-white focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/30 transition-all" placeholder="Contoh: 001" required>
                </div>
                <div class="flex gap-3 pt-4 justify-center">
                    <a href="{{ route('rts.index') }}" class="w-auto text-white bg-[#1a3326] px-6 py-4 rounded-lg font-semibold hover:bg-emerald-700 transition-all">Batal</a>
                    <button type="submit" class="w-auto bg-emerald-600 text-white px-6 py-4 rounded-lg font-semibold hover:bg-emerald-700 transition-all">Buat RT</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection