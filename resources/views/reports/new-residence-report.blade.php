@extends('layout.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-[#3d5c4c] rounded-2xl p-6 shadow-2xl border border-[#4a6a56]">
            <div class="mb-6">
                <h2 class="text-xl font-bold text-white mb-1">Laporan Penduduk Baru</h2>
                <p class="text-emerald-200 text-sm">Silahkan lengkapi data berikut untuk pendaftaran penduduk baru.</p>
            </div>

            <form action="{{ route('warga.reports.store.new-residence') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="nik" class="block text-white font-medium text-sm mb-2">NIK</label>
                    <input type="text" name="nik" id="nik" class="w-full px-4 py-3 bg-[#1a3326] border border-[#4a6a56] rounded-lg text-white focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/30 transition-all" placeholder="Masukkan NIK (16 digit)..." required maxlength="16">
                </div>

                <div class="mb-4">
                    <label for="nama" class="block text-white font-medium text-sm mb-2">Nama</label>
                    <input type="text" name="nama" id="nama" class="w-full px-4 py-3 bg-[#1a3326] border border-[#4a6a56] rounded-lg text-white focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/30 transition-all" placeholder="Masukkan nama lengkap..." required>
                </div>

                <div class="mb-4">
                    <label for="nomor_telepon" class="block text-white font-medium text-sm mb-2">Nomor telepon</label>
                    <input type="text" name="nomor_telepon" id="nomor_telepon" class="w-full px-4 py-3 bg-[#1a3326] border border-[#4a6a56] rounded-lg text-white focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/30 transition-all" placeholder="Masukkan nomor telepon..." required>
                </div>

                <div class="mb-4">
                    <label for="alamat" class="block text-white font-medium text-sm mb-2">Alamat</label>
                    <textarea name="alamat" id="alamat" class="w-full px-4 py-3 bg-[#1a3326] border border-[#4a6a56] rounded-lg text-white focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/30 transition-all" placeholder="Masukkan alamat lengkap..." rows="4" required></textarea>
                </div>

                <button type="submit" class="w-full bg-emerald-600 text-white px-8 py-4 rounded-lg font-semibold hover:bg-emerald-700 transition-all flex items-center justify-center gap-2">
                    Kirim Laporan
                </button>
            </form>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('reports.index') }}" class="bg-[#a63d3d] text-white px-6 py-3 rounded-lg font-medium hover:bg-[#8f3333] transition-all">← Kembali ke daftar</a>
        </div>
    </div>
</div>
@endsection