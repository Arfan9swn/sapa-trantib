@extends('layout.app')

@section('title', 'Detail Laporan - SapaTrantib')

@section('content')
<div class="min-h-screen w-full relative overflow-hidden flex">
    <!-- Left panel -->
    <div class="md:w-1/2 bg-gradient-to-r from-[#1a2e1a] via-black/70 to-black/80 p-8 md:p-16 flex flex-col justify-center text-white relative z-10 hidden md:block">
        <div class="max-w-md">
            <h2 class="text-3xl font-bold text-white mb-2">{{ $report->title }}</h2>
            <p class="text-white/90 text-sm mb-8">Detail laporan</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-8 md:p-16 bg-[#1a3326] min-h-screen">
        <div class="max-w-4xl mx-auto">
            <!-- Back button -->
            <div class="flex items-center gap-2 mb-8">
                <a href="{{ route('reports.index') }}" class="flex items-center gap-2 text-white/70 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali
                </a>
            </div>

            <!-- Title -->
            <h1 class="text-3xl font-bold text-white mb-6">{{ $report->title }}</h1>

            <!-- Status Pills -->
            <div class="flex gap-3 mb-8">
                <span class="bg-[#3d5c4c] text-white px-4 py-1.5 rounded-full text-xs font-medium border border-[#4a6a56]">
                    {{ ucfirst($report->status ?? 'pending') }}
                </span>
                @if($report->category)
                <span class="bg-[#3d5c4c] text-white px-4 py-1.5 rounded-full text-xs font-medium border border-[#4a6a56]">
                    {{ $report->category->name }}
                </span>
                @endif
                @if($report->reporter_rt)
                <span class="bg-[#3d5c4c] text-white px-4 py-1.5 rounded-full text-xs font-medium border border-[#4a6a56]">
                    RT {{ $report->reporter_rt }}
                </span>
                @endif
            </div>

            <!-- Main Image Area -->
            <div class="h-64 bg-[#2d4a3a] rounded-2xl flex items-center justify-center mb-8">
                <svg class="w-16 h-16 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L12 14l2.586-2.586a2 2 0 012.828 0L16 16"></path>
                </svg>
            </div>

            <!-- Location Info -->
            <div class="flex items-start gap-4 mb-8">
                <div class="w-8 h-8 bg-[#3d5c4c] rounded-lg flex items-center justify-center text-white flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-white text-sm font-medium">{{ $report->latitude ?? '-' }}°, {{ $report->longitude ?? '-' }}°</p>
                    <p class="text-white/80 text-sm">{{ $report->reporter_location ?? '-' }}</p>
                </div>
            </div>

            <!-- Reporter Info -->
            <div class="flex items-start gap-4 mb-8">
                <div class="w-8 h-8 bg-[#3d5c4c] rounded-lg flex items-center justify-center text-white flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-white text-sm font-medium">{{ $report->reporter_name ?? '-' }}</p>
                    <p class="text-white/80 text-sm">{{ $report->reporter_phone_number ?? '-' }}</p>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-white mb-3">Deskripsi</h3>
                <p class="text-white/80 text-sm leading-relaxed">{{ $report->description }}</p>
            </div>

            <!-- Comments Section -->
            <div class="bg-white rounded-2xl p-6 border border-white/20">
                <h3 class="text-xl font-bold text-[#1a3326] mb-4">Komentar</h3>

                <!-- Comment Form -->
                <form action="{{ route('reports.comments.store', $report->report_id) }}" method="POST" class="mb-6">
                    @csrf
                    <div class="flex gap-3">
                        <textarea name="body" rows="2" placeholder="Tulis komentar..." class="flex-1 px-4 py-3 rounded-xl bg-[#1a3326] border border-[#3d5c4c] text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all"></textarea>
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white px-6 py-3 rounded-xl font-medium transition-colors">Kirim</button>
                    </div>
                </form>

                <!-- Comments List -->
                <div class="space-y-4">
                    @forelse($report->comments as $comment)
                    <div class="flex gap-3">
                        <div class="w-8 h-8 bg-[#3d5c4c] rounded-full flex items-center justify-center text-white flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-[#1a3326] text-sm">{{ $comment->body }}</p>
                            <p class="text-[#1a3326]/50 text-xs mt-1">{{ $comment->created_at ?? '' }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-[#1a3326]/50 text-sm text-center py-4">Belum ada komentar.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection