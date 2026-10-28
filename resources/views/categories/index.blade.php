@extends('layout.app')

@section('title', 'Daftar Kategori - SapaTrantib')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white mb-1">Admin – Categories List</h1>
            <p class="text-white/60 text-sm">Kelola kategori dan sub kategori laporan</p>
        </div>

        <a href="{{ route('admin-categories.create') }}" class="inline-flex items-center justify-center w-full lg:w-auto px-8 py-4 text-base font-medium text-white bg-emerald-600 rounded-full hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 transition-all duration-200 shadow-xl shadow-emerald-900/40 hover:shadow-emerald-900/60">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah kategori
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-xl text-emerald-200 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 rounded-xl text-red-200 text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Categories Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($categories as $category)
            <div class="bg-[#3d5c4c] rounded-2xl p-6 border border-[#4a6a56] shadow-lg hover:border-[#8fd89b]/50 transition-all duration-200">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-white">{{ $category->name }}</h3>
                        <p class="text-white/60 text-sm">{{ $category->sub_categories_count }} Sub kategori</p>
                    </div>
                    <button onclick="confirmDelete({{ $category->category_id }})" class="text-white/40 hover:text-red-400 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>

                <a href="{{ route('admin-categories.edit', $category->category_id) }}" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 mt-2 bg-white/10 border border-white/20 rounded-xl text-white text-sm font-medium hover:bg-white/20 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 23l3-7m0 0l-3-7m3 7l-3 7"></path>
                    </svg>
                    Edit
                </a>
            </div>
        @empty
            <div class="col-span-full bg-[#3d5c4c] rounded-2xl p-12 text-center border border-[#4a6a56]">
                <p class="text-white/50 text-lg">Belum ada kategori. Buat kategori pertama Anda.</p>
                <a href="{{ route('admin-categories.create') }}" class="mt-4 inline-block px-6 py-2 bg-emerald-600 hover:bg-emerald-700 rounded-lg text-white text-sm font-medium transition-colors">
                    Buat Kategori
                </a>
            </div>
        @endforelse
    </div>

</div>

@push('scripts')
<script>
function confirmDelete(categoryId) {
    if (confirm('Apakah Anda yakin ingin menghapus kategori ini? Semua sub kategori di dalamnya juga akan dihapus.')) {
        fetch('{{ route('admin-categories.destroy', 0) }}'.replace('0', categoryId), {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (response.ok) {
                window.location.reload();
            } else {
                alert('Gagal menghapus kategori.');
            }
        })
        .catch(() => alert('Gagal menghapus kategori.'));
    }
}
</script>
@endpush