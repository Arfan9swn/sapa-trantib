@extends('layout.app')

@section('title', 'Login - SapaTrantib')

@section('content')
<!-- Menggunakan fixed inset-0 z-50 (atau z-40) agar menutupi seluruh layar penuh termasuk layout induknya -->
<div class="fixed inset-0 w-screen h-screen z-50 overflow-hidden flex bg-[#172111]">
    
    <!-- Background Image with Dark Gradient Overlay (Full Screen) -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/login-bg.jpg') }}" alt="Background Login"
             class="w-full h-full object-cover">
        <!-- Gradasi gelap di sebelah kiri agar form mudah dibaca, dan transparan di kanan -->
        <div class="absolute inset-0 bg-gradient-to-r from-[#172111]/95 via-[#172111]/80 to-black/50"></div>
    </div>

    <!-- Content Container -->
    <div class="relative z-10 flex w-full h-full items-center p-6 md:p-16 lg:p-24">
        <div class="w-full max-w-md">
            
            <!-- Header Text -->
            <div class="mb-8">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-2 tracking-tight">Login</h1>
                <p class="text-white/80 text-base md:text-lg">
                    Silahkan Login !
                </p>
            </div>

            <!-- Login Form -->
            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Input Nama -->
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-1.5 h-4 bg-emerald-600 rounded-full"></span>
                        <label class="block text-white text-sm font-medium">Nama</label>
                    </div>
                    <input type="text" name="name" placeholder="Ketik Nama..."
                           class="w-full px-4 py-3.5 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all shadow-inner"
                           required>
                </div>

                <!-- Input Email -->
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-1.5 h-4 bg-emerald-600 rounded-full"></span>
                        <label class="block text-white text-sm font-medium">Email</label>
                    </div>
                    <input type="email" name="email" placeholder="Masukkan Email..."
                           class="w-full px-4 py-3.5 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all shadow-inner"
                           required>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full py-3.5 rounded-xl bg-[#4b6b43] hover:bg-[#3d5835] text-white font-medium text-base transition-all duration-200 shadow-lg border border-white/10">
                    Login
                </button>
            </form>

        </div>
    </div>
</div>
@endsection