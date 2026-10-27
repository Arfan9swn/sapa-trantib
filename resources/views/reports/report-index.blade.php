@extends('layout.app')

@section('title', 'Laporan Anda - SapaTrantib')

@section('content')
<div class="min-h-screen w-full relative overflow-hidden flex">

    <!-- Main Content -->
    <div class="flex-1 p-8 md:p-16 bg-[#1a3326] min-h-screen">
        <div class="max-w-5xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
                <div>
                    <h1 class="text-4xl font-bold text-white mb-1">Laporan Anda</h1>
                    <p class="text-white/80 text-sm">Kelola laporan yang sudah dikirim</p>
                </div>
                <span class="bg-[#3d5c4c] text-white px-3 py-1 rounded-full text-xs font-medium mt-4 md:mt-0">
                    {{ $reports->count() }} laporan
                </span>
            </div>

            <!-- Search Bar -->
            <div class="flex gap-2 mb-6">
                <div class="flex-1 relative">
                    <input type="text" placeholder="Cari laporan anda..." class="w-full pl-10 pr-10 py-3 rounded-xl bg-white border border-white/30 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-white/60">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
                <button class="bg-[#3d5c4c] hover:bg-[#4a6a56] text-white px-6 py-3 rounded-xl font-medium transition-colors border border-[#4a6a56]">Cari</button>
            </div>

            <!-- Filter Pills -->
            <div class="flex gap-3 mb-8 overflow-x-auto pb-2">
                <span class="bg-[#d97706] text-white px-4 py-1.5 rounded-full text-xs font-medium whitespace-nowrap border border-[#d97706]">Pending</span>
                <span class="bg-[#3d5c4c] text-white px-4 py-1.5 rounded-full text-xs font-medium whitespace-nowrap border border-[#4a6a56]">Bencana alam</span>
                <span class="bg-[#3d5c4c] text-white px-4 py-1.5 rounded-full text-xs font-medium whitespace-nowrap border border-[#4a6a56]">Banjar banding</span>
            </div>

            <!-- Reports Grid -->
            <div class="space-y-4">
                @forelse($reports as $report)
                <div class="bg-white rounded-2xl shadow-sm border border-white/20 overflow-hidden">
                    <div class="flex flex-col md:flex-row">
                        <!-- Thumbnail -->
                        <div class="w-full md:w-48 h-48 md:h-auto bg-[#2d4a3a] flex items-center justify-center">
                            <svg class="w-12 h-12 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L12 14l2.586-2.586a2 2 0 012.828 0L16 16"></path></svg>
                        </div>

                        <!-- Content -->
                        <div class="p-6 flex-1">
                            <h3 class="text-xl font-bold text-[#1a3326] mb-2">{{ $report->title }}</h3>
                            <p class="text-[#1a3326]/70 text-sm mb-4 line-clamp-3">{{ $report->description }}</p>
                            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('reports.show', $report->report_id) }}" class="bg-[#3d5c4c] hover:bg-[#4a6a56] text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 transition-colors border border-[#4a6a56]">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Lihat
                                    </a>
                                    <form action="{{ route('reports.destroy', $report->report_id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-[#a63d3d] hover:bg-[#8f3333] text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors border border-[#c96b6b]">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Hapus
                                        </button>
                                    </form>
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