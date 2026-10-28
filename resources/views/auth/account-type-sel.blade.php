@extends('layout.app')

@section('title', 'Pilih Tipe Akun - SapaTrantib')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<div class="fixed inset-0 w-screen h-screen z-50 overflow-hidden flex bg-[#172111]">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/login-bg.jpg') }}" alt="Background Account Type"
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-[#172111]/95 via-[#172111]/80 to-black/50"></div>
    </div>

    <div class="relative z-10 flex w-full h-full items-center p-6 md:p-16 lg:p-24">
        <div class="w-full max-w-md">
            <div class="mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">Pilih Tipe Akun</h1>
                <p class="text-white/80 text-sm">Anda mendaftar sebagai siapa?</p>
            </div>

            <div class="space-y-4">
                <a href="{{ route('admin.register') }}" class="block w-full py-4 rounded-xl bg-emerald-600 text-white font-semibold text-center hover:bg-emerald-500 transition-colors shadow-lg shadow-emerald-900/40">
                    Sebagai Admin
                </a>

                <a href="{{ route('reports.create') }}" class="block w-full py-4 rounded-xl border border-white/20 text-white text-center hover:bg-white/10 transition-colors">
                    Sebagai Warga
                </a>
            </div>

            <div class="mt-8 text-center">
                <p class="text-white/50 text-sm">
                    Sudah punya akun admin?
                    <a href="{{ route('admin.login') }}" class="text-emerald-400 hover:text-emerald-300 font-medium ml-1">
                        Masuk di sini
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection