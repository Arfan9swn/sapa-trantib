@extends('layout.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-[#3d5c4c] rounded-2xl p-6 shadow-2xl border border-[#4a6a56]">
            <div class="mb-6">
                <h2 class="text-xl font-bold text-white mb-1">Kirim Laporan</h2>
                <p class="text-emerald-200 text-sm">Silahkan lengkapi form berikut untuk mengirim laporan sebagai warga.</p>
            </div>

            <form action="{{ route('warga.reports.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="title" class="block text-white font-medium text-sm mb-2">Judul laporan</label>
                    <input type="text" name="title" id="title" class="w-full px-4 py-3 bg-[#1a3326] border border-[#4a6a56] rounded-lg text-white focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/30 transition-all" placeholder="Masukan judul laporan..." required>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-white font-medium text-sm mb-2">Isi laporan</label>
                    <textarea name="description" id="description" class="w-full px-4 py-3 bg-[#1a3326] border border-[#4a6a56] rounded-lg text-white focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/30 transition-all" placeholder="Masukan isi laporan..." rows="4" required></textarea>
                </div>

                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div>
                        <label for="reporter_rt" class="block text-white font-medium text-sm mb-2">RT</label>
                        <select name="reporter_rt" id="reporter_rt" class="w-full px-4 py-3 bg-[#1a3326] border border-[#4a6a56] rounded-lg text-white focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/30 transition-all" required>
                            <option value="">Pilih RT...</option>
                            @php
                                $rts = App\Models\RT::orderBy('rt_number')->get();
                            @endphp
                            @foreach ($rts as $rt)
                                <option value="{{ $rt->rt_number }}">{{ $rt->rt_number }} - Kepala: {{ $rt->head_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="category_id" class="block text-white font-medium text-sm mb-2">Kategori</label>
                        <select name="category_id" id="category_id" class="w-full px-4 py-3 bg-[#1a3326] border border-[#4a6a56] rounded-lg text-white focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/30 transition-all" required>
                            <option value="">Pilih Kategori...</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->category_id }}" {{ $categoryId == $category->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="sub_category_id" class="block text-white font-medium text-sm mb-2">Subkategori</label>
                        <select name="sub_category_id" id="sub_category_id" class="w-full px-4 py-3 bg-[#1a3326] border border-[#4a6a56] rounded-lg text-white focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/30 transition-all" required>
                            <option value="">Pilih Subkategori...</option>
                            @foreach ($subCategories as $subCategory)
                                <option value="{{ $subCategory->sub_category_id }}">{{ $subCategory->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="image" class="block text-white font-medium text-sm mb-2">Lampirkan foto</label>
                    <div class="w-full bg-[#1a3326] border-2 border-dashed border-[#4a6a56] rounded-lg px-6 py-4 text-center text-gray-400 hover:border-emerald-500 hover:text-white transition-all cursor-pointer group" id="imageDropZone">
                        <svg class="w-6 h-6 mx-auto mb-2 text-gray-400 group-hover:text-emerald-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <div class="text-sm font-medium text-gray-400 group-hover:text-emerald-400 transition-colors">Klik untuk memilih foto...</div>
                    </div>
                    <input type="file" name="image" id="image" class="hidden" accept="image/*">
                    <p class="text-xs text-white/50 mt-2">Format: JPG, PNG, GIF, WEBP (maks. 2MB)</p>
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const categorySelect = document.getElementById('category_id');
        const subCategorySelect = document.getElementById('sub_category_id');
        const imageInput = document.getElementById('image');
        const imageDropZone = document.getElementById('imageDropZone');

        // Subcategory AJAX loading
        categorySelect.addEventListener('change', function() {
            const categoryId = this.value;

            subCategorySelect.innerHTML = '<option value="">Memuat subkategori...</option>';
            subCategorySelect.disabled = true;

            if (!categoryId) {
                subCategorySelect.innerHTML = '<option value="">Pilih Subkategori...</option>';
                subCategorySelect.disabled = true;
                return;
            }

            fetch('{{ route('api.subcategories') }}?category_id=' + categoryId)
                .then(response => response.json())
                .then(data => {
                    subCategorySelect.innerHTML = '<option value="">Pilih Subkategori...</option>';
                    data.forEach(function(sub) {
                        const option = document.createElement('option');
                        option.value = sub.sub_category_id;
                        option.textContent = sub.name;
                        subCategorySelect.appendChild(option);
                    });
                    subCategorySelect.disabled = false;
                })
                .catch(error => {
                    console.error('Error:', error);
                    subCategorySelect.innerHTML = '<option value="">Gagal memuat subkategori</option>';
                    subCategorySelect.disabled = false;
                });
        });

        // Image upload click handler
        imageDropZone.addEventListener('click', function() {
            imageInput.click();
        });

        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imageDropZone.innerHTML = `
                        <img src="${e.target.result}" alt="Preview" class="max-w-full max-h-48 mx-auto mb-2 rounded-lg">
                        <div class="text-sm font-medium text-emerald-400">Foto terpilih: ${file.name}</div>
                        <button type="button" onclick="resetImage()" class="text-xs text-red-400 hover:text-red-300 mt-2">Ganti foto</button>
                    `;
                };
                reader.readAsDataURL(file);
            }
        });

        window.resetImage = function() {
            imageInput.value = '';
            imageDropZone.innerHTML = `
                <svg class="w-6 h-6 mx-auto mb-2 text-gray-400 group-hover:text-emerald-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <div class="text-sm font-medium text-gray-400 group-hover:text-emerald-400 transition-colors">Klik untuk memilih foto...</div>
            `;
        };
    });
</script>
@endpush
@endsection