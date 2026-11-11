@extends('layout.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-[#3d5c4c] rounded-2xl p-6 shadow-2xl border border-[#4a6a56]">
            <div class="mb-6">
                <h2 class="text-xl font-bold text-white mb-1">Edit RT</h2>
                <p class="text-emerald-200 text-sm">Silahkan lengkapi form berikut untuk memperbarui data RT.</p>
            </div>
            
            <form action="{{ route('rts.update', $rt->rt_id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="rt_number" class="block text-white font-medium text-sm mb-2">No. RT</label>
                        <input type="text" name="rt_number" id="rt_number" value="{{ $rt->rt_number }}" class="w-full px-4 py-3 bg-[#1a3326] border border-[#4a6a56] rounded-lg text-white focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/30 transition-all" required>
                    </div>
                    <div>
                        <label for="head_name" class="block text-white font-medium text-sm mb-2">Kepala RT</label>
                        <input type="text" name="head_name" id="head_name" value="{{ $rt->head_name }}" class="w-full px-4 py-3 bg-[#1a3326] border border-[#4a6a56] rounded-lg text-white focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/30 transition-all" required>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="population" class="block text-white font-medium text-sm mb-2">Jumlah Penduduk</label>
                        <input type="number" name="population" id="population" value="{{ $rt->population }}" class="w-full px-4 py-3 bg-[#1a3326] border border-[#4a6a56] rounded-lg text-white focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/30 transition-all" min="0" required>
                    </div>
                    <div>
                        <label for="reports_reported" class="block text-white font-medium text-sm mb-2">Laporan Diterbitkan</label>
                        <input type="number" name="reports_reported" id="reports_reported" value="{{ $rt->reports_reported }}" class="w-full px-4 py-3 bg-[#1a3326] border border-[#4a6a56] rounded-lg text-white focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/30 transition-all" min="0" required>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="report_type" class="block text-white font-medium text-sm mb-2">Tipe Laporan</label>
                    <select name="report_type" id="report_type" class="w-full px-4 py-3 bg-[#1a3326] border border-[#4a6a56] rounded-lg text-white focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/30 transition-all" required>
                        <option value="category" {{ $rt->report_type == 'category' ? 'selected' : '' }}>Kategori</option>
                        <option value="subcategory" {{ $rt->report_type == 'subcategory' ? 'selected' : '' }}>Subkategori</option>
                    </select>
                </div>
                
                <button type="submit" class="w-full bg-emerald-600 text-white px-6 py-4 rounded-lg font-semibold hover:bg-emerald-700 transition-all">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
@endsection