<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sapa-Trantib</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#152a20] text-gray-100 antialiased">

    <!-- Cek apakah ini BUKAN halaman landing page (root '/') -->
    @if (!request()->is('/'))
        <div class="flex h-screen overflow-hidden relative">
            <!-- BACKDROP MOBILE -->
            <div id="sidebar-backdrop" onclick="toggleMobileSidebar()" class="fixed inset-0 bg-black/50 z-20 hidden transition-opacity duration-300"></div>

            <!-- SIDEBAR -->
            <aside id="sidebar" class="w-64 bg-[#2d4a3a] border-r border-[#4a6a56] flex flex-col flex-shrink-0 z-30 fixed inset-y-0 left-0 -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out md:static h-full shadow-2xl">
                <!-- Tombol Close Mobile -->
                <button onclick="toggleMobileSidebar()" class="md:hidden absolute top-4 right-4 w-8 h-8 rounded-lg bg-[#3d5c4c] flex items-center justify-center text-white text-xs z-40">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <div class="p-6"></div>

                <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                    @php
                        $sidebarAuthUser = null;
                        if (session('auth_user_id')) {
                            $sidebarAuthUser = \App\Models\User::find(session('auth_user_id'));
                        }
                        $userRole = $sidebarAuthUser->role ?? session('auth_user_role') ?? '';
                        $isAdmin = in_array(strtolower($userRole), ['admin', 'super_admin']);
                    @endphp

                    @if ($isAdmin)
                        <a href="{{ route('admin-users.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-l-lg bg-[#3d5c4c] text-white border-l-4 border-[#8fd89b]">List user</a>
                        <a href="{{ route('reports.admin') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-l-lg hover:bg-[#3d5c4c]/50 text-[#c9e3cb]">List laporan</a>
                        <a href="{{ route('admin-user-tags.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-l-lg hover:bg-[#3d5c4c]/50 text-[#c9e3cb]">User Tags</a>
                        <a href="{{ route('admin-categories.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-l-lg hover:bg-[#3d5c4c]/50 text-[#c9e3cb]">Buat kategori</a>
                        <a href="{{ route('statistics') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-l-lg hover:bg-[#3d5c4c]/50 text-[#c9e3cb]">Statistik</a>
                        <a href="{{ route('activities.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-l-lg hover:bg-[#3d5c4c]/50 text-[#c9e3cb]">Activities</a>
                    @else
                        <a href="{{ route('reports.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-l-lg bg-[#3d5c4c] text-white border-l-4 border-[#8fd89b]">Laporan anda</a>
                        <a href="{{ route('reports.create') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-l-lg hover:bg-[#3d5c4c]/50 text-[#c9e3cb]">Kirim laporan</a>
                    @endif
                </nav>

                <div class="p-6">
                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg bg-[#a63d3d] hover:bg-[#8f3333] text-white border border-[#c96b6b]">
                            Keluar dari akun
                        </button>
                    </form>
                </div>
            </aside>
    @endif

            <!-- AREA KONTEN -->
            <div class="flex-1 flex flex-col overflow-hidden w-full">
                @if (!request()->is('/'))
                    <!-- NAVBAR -->
                    <nav class="bg-[#1a3326] border-b border-[#2d4a3a] px-6 py-4 flex items-center justify-between z-10 flex-shrink-0">
                        <span class="text-2xl font-serif italic text-white tracking-tight">Sapa-Trantib</span>
                        <button onclick="toggleMobileSidebar()" class="md:hidden w-10 h-10 rounded-lg bg-[#2d4a3a] flex items-center justify-center text-white border border-[#4a6a56]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </button>
                    </nav>
                @endif

                <main class="flex-1 overflow-y-auto p-6 bg-[#152a20]">
                    @yield('content')
                </main>
            </div>

    @if (!request()->is('/'))
        </div>
    @endif

    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            if(sidebar && backdrop) {
                sidebar.classList.toggle('-translate-x-full');
                sidebar.classList.toggle('translate-x-0');
                backdrop.classList.toggle('hidden');
            }
        }
    </script>
</body>
</html>