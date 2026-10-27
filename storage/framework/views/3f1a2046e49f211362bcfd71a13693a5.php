<aside class="w-64 bg-[#2d4a3a] border-r border-[#4a6a56] flex flex-col h-screen z-10 sidebar-scroll">
    <!-- Sidebar header / brand area (optional, navbar already has brand) -->
    <div class="p-6"></div>

    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
        <?php if(auth()->guard()->check()): ?>
            <?php
                $userRole = auth()->user()->role ?? 'warga';
                $isAdmin = in_array($userRole, ['admin', 'super_admin']);
            ?>

            <?php if($isAdmin): ?>
                <!-- Admin Sidebar Links -->
                <a href="<?php echo e(route('users.index')); ?>" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-l-lg transition-colors bg-[#3d5c4c] text-white border-l-4 border-[#8fd89b]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    List user
                </a>

                <a href="<?php echo e(route('reports.admin')); ?>" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-l-lg transition-colors hover:bg-[#3d5c4c]/50 text-[#c9e3cb]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    List laporan
                </a>

                <a href="<?php echo e(route('categories.index')); ?>" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-l-lg transition-colors hover:bg-[#3d5c4c]/50 text-[#c9e3cb]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Buat kategori
                </a>

                <a href="<?php echo e(route('statistics')); ?>" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-l-lg transition-colors hover:bg-[#3d5c4c]/50 text-[#c9e3cb]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Statistik
                </a>

                <a href="<?php echo e(route('activities.index')); ?>" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-l-lg transition-colors hover:bg-[#3d5c4c]/50 text-[#c9e3cb]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Activities
                </a>
            <?php else: ?>
                <!-- Guest (Warga) Sidebar Links -->
                <a href="<?php echo e(route('reports.index')); ?>" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-l-lg transition-colors bg-[#3d5c4c] text-white border-l-4 border-[#8fd89b]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    List laporan
                </a>

                <a href="<?php echo e(route('reports.create')); ?>" class="sidebar-link flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-l-lg transition-colors hover:bg-[#3d5c4c]/50 text-[#c9e3cb]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Kirim laporan
                </a>
            <?php endif; ?>
        <?php endif; ?>
    </nav>

    <!-- Logout button at bottom -->
    <div class="p-6">
        <form action="<?php echo e(route('logout')); ?>" method="POST" class="w-full">
            <?php echo csrf_field(); ?>
            <?php echo method_field('POST'); ?>
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg bg-[#a63d3d] hover:bg-[#8f3333] transition-colors text-white border border-[#c96b6b]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Keluar dari akun
            </button>
        </form>
    </div>
</aside><?php /**PATH C:\Users\Administrator\Documents\sapa-trantip\sapa-trantib\resources\views/layout/sidebar.blade.php ENDPATH**/ ?>