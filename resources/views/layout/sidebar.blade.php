<aside class="w-64 bg-[#2d4a3a] border-r border-[#4a6a56] flex flex-col min-h-[calc(100vh-4rem)] z-10 sidebar-scroll">
    <!-- Sidebar header / brand area (optional, navbar already has brand) -->
    <div class="p-6"></div>

    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
        @auth
            @php
                $userRole = auth()->user()->role ?? 'warga';
                $isAdmin = in_array($userRole, ['admin', 'super_admin']);
            @endphp

            @if ($isAdmin)
                <!-- Admin Sidebar Links (Image 2) -->
                <a href="{{ route('admin-users.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-l-lg transition-colors bg-[#3d5c4c] text-white border-l-4 border-[#8fd89b]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    List user
                </a>

                <a href="{{ route('reports.admin') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-l-lg transition-colors hover:bg-[#3d5c4c]/50 text-[#c9e3cb]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    List laporan
                </a>

                <a href="{{ route('admin-categories.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-l-lg transition-colors hover:bg-[#3d5c4c]/50 text-[#c9e3cb]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Buat kategori
                </a>

                <a href="{{ route('statistics') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-l-lg transition-colors hover:bg-[#3d5c4c]/50 text-[#c9e3cb]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Statistik
                </a>

                <a href="{{ route('activities.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-l-lg transition-colors hover:bg-[#3d5c4c]/50 text-[#c9e3cb]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Activities
                </a>
            @else
                <!-- Guest (Warga) Sidebar Links (Image 1) -->
                <a href="{{ route('reports.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-l-lg transition-colors bg-[#3d5c4c] text-white border-l-4 border-[#8fd89b]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Laporan anda
                </a>

                <a href="{{ route('reports.create') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-l-lg transition-colors hover:bg-[#3d5c4c]/50 text-[#c9e3cb]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5l12 12M5 17l12-12M17 17l-12 12M7 7l12 12"></path>
                    </svg>
                    Kirim laporan
                </a>
            @endif
        @endauth
    </nav>

    <!-- Logout button at bottom -->
    <div class="p-6">
        <form action="{{ route('logout') }}" method="POST" class="w-full">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg bg-[#a63d3d] hover:bg-[#8f3333] transition-colors text-white border border-[#c96b6b]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Keluar dari akun
            </button>
        </form>
    </div>
</aside>