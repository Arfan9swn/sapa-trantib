@extends('layout.app')

@section('title', 'Semua laporan - SapaTrantib')

@section('content')
<div class="min-h-screen w-full relative overflow-hidden flex">

    <!-- Main Content -->
    <div class="flex-1 p-8 md:p-16 bg-[#1a3326] min-h-screen">
        <div class="max-w-5xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
                <div>
                    <h1 class="text-4xl font-bold text-white mb-1">Semua laporan</h1>
                    <p class="text-white/80 text-sm">Kelola laporan yang sudah dikirim</p>
                </div>
                <span class="bg-[#3d5c4c] text-white px-3 py-1 rounded-full text-xs font-medium mt-4 md:mt-0">
                    {{ $reports->count() }} laporan
                </span>
            </div>

            <!-- Filter Form -->
            <form method="GET" class="flex flex-row sm:flex-row gap-4 mb-6 max-w-2xl">
                <div class="flex-1 sm:flex-1">
                    <select name="status" class="block w-full rounded-xl border border-green-500 bg-green-800 px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all appearance-none">
                        <option value="" {{ $request->status == '' ? 'selected' : '' }}>Semua Status</option>
                        <option value="pending" {{ $request->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="denied" {{ $request->status == 'denied' ? 'selected' : '' }}>Ditolak</option>
                        <option value="complete" {{ $request->status == 'complete' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <div class="flex-1 sm:flex-1">
                    <select name="category_id" class="block w-full rounded-xl border border-green-500 bg-green-800 px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all appearance-none" on="change-category">
                        <option value="" {{ $request->category_id == '' ? 'selected' : '' }}>Semua Kategori</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->category_id }}" {{ $request->category_id == $cat->category_id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1 sm:flex-1">
                    <select name="sub_category_id" class="block w-full rounded-xl border border-green-500 bg-green-800 px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all appearance-none" id="subCategoryFilter">
                        <option value="" {{ $request->sub_category_id == '' ? 'selected' : '' }}>Semua Sub-Kategori</option>
                        @foreach($subCategories as $sc)
                        <option value="{{ $sc->sub_category_id }}" {{ $request->sub_category_id == $sc->sub_category_id ? 'selected' : '' }}>{{ $sc->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1 sm:flex-1">
                    <input type="text" name="search" placeholder="Cari laporan..." class="block w-full rounded-xl border border-green-500 bg-green-800 px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all appearance-none" value="{{ $request->search ?? '' }}">
                </div>
                <button type="submit" class="bg-[#3d5c4c] hover:bg-[#4a6a56] text-white px-6 py-3 rounded-xl font-medium transition-colors border border-[#4a6a56]">Filter</button>
            </form>

            <!-- Subcategory AJAX script -->
            <script>
            function loadSubCategories(categoryId) {
                axios.get('/api/subcategories', { params: { category_id: categoryId } })
                    .then(response => {
                        const subCategoryFilter = document.getElementById('subCategoryFilter');
                        subCategoryFilter.innerHTML = '<option value="">Semua Sub-Kategori</option>';
                        response.data.forEach(subCat => {
                            const option = document.createElement('option');
                            option.value = subCat.sub_category_id;
                            option.text = subCat.name;
                            subCategoryFilter.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error loading subcategories:', error);
                    });
            }

            // Handle category change
            const categorySelect = document.querySelector('select[name="category_id"]');
            categorySelect.addEventListener('change', function() {
                const categoryId = this.value;
                loadSubCategories(categoryId);
            });
            </script>

            <!-- Reports Grid -->
            <div class="space-y-4">

            <!-- Reports Grid -->
            <div class="space-y-4">
                @forelse($reports as $report)
                <div class="rounded-2xl shadow-sm border border-white/20 overflow-hidden">
                    <div class="flex flex-col md:flex-row">
                        <!-- Thumbnail -->
                        <div class="w-full md:w-48 h-48 md:h-auto bg-[#2d4a3a] flex items-center justify-center">
                            <svg class="w-12 h-12 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L12 14l2.586-2.586a2 2 0 012.828 0L16 16"></path></svg>
                        </div>

                        <!-- Content -->
                        <div class="p-6 flex-1">
                            <h3 class="text-xl font-bold text-[#ffffff] mb-2">{{ $report->title }}</h3>
                            <p class="text-[#ffffff]/70 text-sm mb-4 line-clamp-3">{{ $report->description }}</p>

<!-- Report Submission Date -->
<div class="flex items-center gap-2 mb-4 text-sm text-white/60 mt-2">
    <span>{{ \Illuminate\Support\Carbon::parse($report->submitted_at)->format('d F Y H:i') }}</span>
</div>
                            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('reports.show', $report->report_id) }}" class="bg-[#3d5c4c] hover:bg-[#4a6a56] text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 transition-colors border border-[#4a6a56]">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Lihat
                                    </a>
                                    <div class="flex gap-2">
                                    @if (session('auth_user_role') == 'admin' || session('auth_user_role') == 'super_admin' || strtolower($report->reporter_phone_number) == strtolower(session('auth_user_phone')))
                                    <form action="{{ route('reports.destroy', $report->report_id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-[#a63d3d] hover:bg-[#8f3333] text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors border border-[#c96b6b]">
                                            <svg class="w-full h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Hapus
                                        </button>
                                    </form>
                                    @endif
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-12"><p class="text-white/50">Belum ada laporan.</p></div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection