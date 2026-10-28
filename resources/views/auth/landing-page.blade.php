@extends('layout.app')

@section('title', 'Landing Page - SapaTrantib')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">

    <div class="min-h-screen bg-slate-950 text-slate-200 relative overflow-hidden" style="--font-serif: 'Playfair Display', ui-serif, serif;">
        <!-- Subtle green glow on the left side -->
        <div class="absolute top-0 left-0 w-1/3 h-full via-transparent to-transparent -z-10 pointer-events-none"></div>

        <!-- Navbar (Sapa-Trantib at top-left, no login/register) -->
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center gap-3 text-left">
                <span class="text-2xl lg:text-3xl font-serif italic text-white tracking-tight">Sapa-Trantib</span>
            </div>
        </div>

        <!-- Hero -->
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-24">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-center">
                <div class="space-y-6 max-w-lg lg:max-w-none">
                    <h1 class="text-4xl lg:text-6xl font-lexend font-semibold text-white leading-[1.05] tracking-tight">
                        Membantu warga untuk membangun
                    </h1>
                    <h2 class="text-4xl lg:text-6xl font-lexend font-semibold text-white leading-[1.05] tracking-tight mt-2">
                        Masyarakat Yang
                        <span class="block leading-none">Aman dan teratur</span>
                    </h2>
                    <p class="text-slate-400 text-sm sm:text-base leading-relaxed max-w-xs lg:max-w-none whitespace-pre-line">
                        Laporkan masalah warga sekitar jaga !
                        Dan bantu masyarakat sekitar hidup lebih aman dan teratur.
                    </p>
                    <div class="mt-4 lg:mt-8">
                        <a href="{{ route('account.type') }}" class="w-full lg:w-auto inline-flex items-center justify-center px-8 py-4 text-base font-medium text-white bg-emerald-600 rounded-full hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 transition-all duration-200 shadow-xl shadow-emerald-900/40 hover:shadow-emerald-900/60">
                        Lapor
                        </a>
                    </div>
                </div>

                <div class="flex justify-center">
                    <div class="relative w-full max-w-md aspect-[4/5]">
                        <img src="https://images.unsplash.com/photo-1556742049-0cfed4f7a07d?ixlib=rb-4.0.3&auto=format&fit=crop&w=900&q=80"
                             alt="Warga melaporkan melalui ponsel"
                             class="w-full h-full object-cover rounded-[1.5rem] border border-slate-800 shadow-2xl shadow-black/60">
                        <div class="absolute -inset-0.5 rounded-[1.5rem] bg-gradient-to-r from-emerald-500 to-teal-400 blur-[80px] opacity-25 -z-10"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
