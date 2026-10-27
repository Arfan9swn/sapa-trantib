@extends('layout.app')

@section('title', 'Pilih Tipe Akun - SapaTrantib')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<div class="min-h-screen bg-black relative overflow-hidden flex items-center justify-center px-4">
    <!-- Subtle vignette glow (lighter towards center-left, darker at edges) -->
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_60%_50%_at_30%_0%,rgba(78,91,68,0.25),transparent)] pointer-events-none"></div>

    <div class="relative z-10 max-w-5xl w-full">
        <h2 class="text-center text-white text-2xl md:text-3xl font-semibold tracking-wide mb-12">
            Masuk sebagai ?
        </h2>

        <div class="flex flex-wrap justify-center gap-6 md:gap-12">
            <!-- Admin -->
            <a href="{{ route('login') }}" class="group relative w-64 h-80 rounded-[1.5rem] bg-[#4e5a44] p-8 text-center shadow-2xl shadow-black/60 transition-all duration-300 hover:scale-[1.025] hover:shadow-[#4e5a45]/45 flex flex-col items-center">
                <span class="text-white text-lg md:text-xl font-medium tracking-wide mb-10">Admin</span>
                <div class="w-24 h-24 rounded-xl bg-[#161b16] flex items-center justify-center shadow-inner group-hover:bg-[#0f120f] transition-colors duration-300">
                    <div class="relative w-12 h-12 flex flex-col items-center justify-end">
                        <div class="w-7 h-7 rounded-full bg-[#94a3b8]"></div>
                        <div class="w-14 h-2.5 mt-1.5 rounded-full bg-[#94a3b8]"></div>
                    </div>
                </div>
            </a>

            <!-- Warga (selected state) -->
            <a href="{{ route('reports.index') }}" class="group relative w-64 h-80 rounded-[1.5rem] bg-[#4e5a44] p-8 text-center shadow-2xl shadow-black/60 ring-1 ring-white/10 transition-all duration-300 hover:scale-[1.025] hover:shadow-[#4e5a45]/45 flex flex-col items-center">
                <span class="text-white text-lg md:text-xl font-medium tracking-wide mb-10">Warga</span>
                <div class="w-24 h-24 rounded-xl bg-black flex items-center justify-center shadow-inner group-hover:bg-black transition-colors duration-300">
                    <div class="relative w-12 h-12 flex flex-col items-center justify-end">
                        <div class="w-7 h-7 rounded-full bg-white"></div>
                        <div class="w-14 h-2.5 mt-1.5 rounded-full bg-white"></div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection