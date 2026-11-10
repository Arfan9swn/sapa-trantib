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
                        <a href="{{ route('admin-users.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-l-lg bg-[#3d5c4c] text-white border-l-4 border-[#8fd89b]">
                            <div class="w-6 h-6 bg-[#3d5c4c] rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path><circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2"></circle><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"></path></svg>
                            </div>
                            List user
                        </a>
                        <a href="{{ route('reports.admin') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-l-lg hover:bg-[#3d5c4c]/50 text-[#c9e3cb]">
                            <div class="w-6 h-6 bg-[#3d5c4c] rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            List laporan
                        </a>
                        <a href="{{ route('admin-user-tags.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-l-lg hover:bg-[#3d5c4c]/50 text-[#c9e3cb]">
                            <div class="w-6 h-6 bg-[#3d5c4c] rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </div>
                            User Tags
                        </a>
                        <a href="{{ route('admin-categories.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-l-lg hover:bg-[#3d5c4c]/50 text-[#c9e3cb]">
                            <div class="w-6 h-6 bg-[#3d5c4c] rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            Buat kategori
                        </a>
                        <a href="{{ route('statistics') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-l-lg hover:bg-[#3d5c4c]/50 text-[#c9e3cb]">
                            <div class="w-6 h-6 bg-[#3d5c4c] rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            </div>
                            Statistik
                        </a>
                        <a href="{{ route('activities.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-l-lg hover:bg-[#3d5c4c]/50 text-[#c9e3cb]">
                            <div class="w-6 h-6 bg-[#3d5c4c] rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            Activities
                        </a>
                    @else
                        <a href="{{ route('reports.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-l-lg bg-[#3d5c4c] text-white border-l-4 border-[#8fd89b]">
                            <div class="w-6 h-6 bg-[#3d5c4c] rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            Laporan anda
                        </a>
                        <a href="{{ route('reports.create') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-l-lg hover:bg-[#3d5c4c]/50 text-[#c9e3cb]">
                            <div class="w-6 h-6 bg-[#3d5c4c] rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </div>
                            Kirim laporan
                        </a>
                    @endif
                </nav>

                <div class="p-6">
                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg bg-[#a63d3d] hover:bg-[#8f3333] text-white border border-[#c96b6b]">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H3"></path></svg>
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