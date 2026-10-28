@extends('layout.app')

@section('title', 'Buat Kategori - SapaTrantib')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white mb-1">Buat Kategori Baru</h1>
            <p class="text-white/60 text-sm">Isi nama kategori dan tambahkan sub kategori terkait</p>
        </div>

        <a href="{{ route('admin-categories.index') }}" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-medium text-white bg-[#4b6b43] rounded-xl hover:bg-[#3d5835] transition-colors">
            ← Kembali ke daftar kategori
        </a>
    </div>

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 rounded-xl text-red-200 text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-[#2d4a3a] rounded-2xl p-8 sm:p-12 border border-[#4a6a56] shadow-xl">
        <form action="{{ route('admin-categories.store') }}" method="POST" class="space-y-8">
            @csrf

            <!-- Category Name -->
            <div>
                <label class="block text-sm font-medium text-white/90 mb-2">Nama kategori</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    placeholder="Ketik Nama kategori..."
                    class="w-full px-4 py-3 rounded-xl bg-white text-[#1a3326] text-base border-0 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors">
            </div>

            <!-- Sub Categories -->
            <div>
                <div class="flex items-center justify-between mb-4">
                    <label class="block text-sm font-medium text-white/90">Tambah sub kategori</label>
                    <button type="button" onclick="addSubCategory()"
                        class="flex items-center justify-center w-10 h-10 rounded-xl border-2 border-dashed border-white/30 bg-white/5 hover:bg-white/10 hover:border-white/50 text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </button>
                </div>

                <div id="subCategoriesContainer" class="space-y-3">
                    <!-- Sub category rows will be added here -->
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit"
                    class="w-full py-4 rounded-xl bg-emerald-600 text-white font-semibold text-base hover:bg-emerald-700 transition-colors shadow-lg shadow-emerald-900/40">
                    Konfirmasi
                </button>
            </div>
        </form>
    </div>

</div>

@push('scripts')
<script>
    let subCategoryCount = 0;

    function addSubCategory() {
        const container = document.getElementById('subCategoriesContainer');
        const row = document.createElement('div');
        row.className = 'flex items-center gap-3 bg-white/5 rounded-xl p-3 border border-white/10 hover:bg-white/10 transition-colors';
        row.innerHTML = `
            <input type="text" name="sub_categories[]" placeholder="Nama sub kategori..."
                class="flex-1 px-3 py-2 rounded-lg bg-white text-[#1a3326] text-sm border-0 focus:outline-none focus:ring-2 focus:ring-emerald-500">
            <button type="button" onclick="removeSubCategory(this)" class="text-white/50 hover:text-red-400 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        `;
        container.appendChild(row);
    }

    function removeSubCategory(button) {
        button.parentElement.remove();
    }
</script>
@endpush