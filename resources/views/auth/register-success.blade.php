@extends('layout.app')

@section('title', 'Registrasi Berhasil - SapaTrantib')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<div class="fixed inset-0 w-screen h-screen z-50 overflow-hidden flex bg-[#172111]">

    <!-- Background Image with Dark Gradient Overlay -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/login-bg.jpg') }}" alt="Background Success"
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-[#172111]/95 via-[#172111]/80 to-black/50"></div>
    </div>

    <!-- Content Container -->
    <div class="relative z-10 flex w-full h-full items-center p-6 md:p-16 lg:p-24">
        <div class="w-full max-w-md">
            <!-- Success Card -->
            <div class="bg-white/10 border border-white/20 rounded-2xl p-8 backdrop-blur-sm">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-emerald-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Registrasi Berhasil!</h1>
                    <p class="text-emerald-300 text-sm">Akun admin Anda telah dibuat.</p>
                </div>

                <!-- Notice Box -->
                <div class="bg-amber-500/10 border border-amber-500/20 rounded-xl p-6 mb-8">
                    <h3 class="text-amber-300 font-semibold mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Menunggu Persetujuan
                    </h3>
                    <p class="text-white/80 text-sm leading-relaxed">
                        Akun Anda masih <strong>belum dapat digunakan</strong> karena menunggu verifikasi dari super admin. 
                        Silakan tunggu hingga super admin menyetujui akun Anda sebelum dapat masuk.
                    </p>
                </div>

                <!-- Steps -->
                <div class="space-y-4 mb-8">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-500 text-white text-xs font-bold flex items-center justify-center mt-0.5">1</div>
                        <div>
                            <p class="text-white text-sm font-medium">Akun berhasil dibuat</p>
                            <p class="text-white/60 text-xs">Role: Admin (menunggu verifikasi)</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-6 h-6 rounded-full bg-white/20 text-white text-xs font-bold flex items-center justify-center mt-0.5">2</div>
                        <div>
                            <p class="text-white text-sm font-medium">Tunggu super admin</p>
                            <p class="text-white/60 text-xs">Akun akan disetujui oleh super admin</p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="space-y-3">
                    <a href="{{ route('admin.login') }}" class="w-full py-3.5 rounded-xl bg-white/10 border border-white/20 text-white font-semibold text-center hover:bg-white/20 transition-all duration-200 block text-decoration-none">
                        Kembali ke Halaman Masuk
                    </a>
                </div>
            </div>

            <p class="mt-8 text-center text-white/50 text-xs">
                SapaTrantib &mdash; Sistem Admin
            </p>
        </div>
    </div>
</div>
@endsection