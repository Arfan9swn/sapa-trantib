

<?php $__env->startSection('title', 'User List - SapaTrantib'); ?>

<?php $__env->startSection('content'); ?>



<div>
    <div class="flex flex-col lg:flex-row lg:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-white">List pengguna yang terdaftar</h1>
            <p class="text-white/60 text-sm">Kelola akun pengguna</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <?php if($isSuperAdmin): ?>
            <a href="<?php echo e(route('admin-user-tags.index')); ?>" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-white bg-[#4a6a56] rounded-xl hover:bg-[#3d5c4c] transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                Kelola User Tags
            </a>
            <?php endif; ?>
            <a href="<?php echo e(route('admin-users.create')); ?>" class="inline-flex items-center justify-center w-full lg:w-auto px-6 py-3 text-sm font-medium text-white bg-emerald-600 rounded-xl hover:bg-emerald-500 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah user
            </a>
        </div>
    </div>

    <?php if(session('success')): ?>
    <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-200 text-sm"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if(session('error')): ?>
    <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-200 text-sm"><?php echo e(session('error')); ?></div>
    <?php endif; ?>
    <?php if(session('info')): ?>
    <div class="mb-6 p-4 rounded-xl bg-blue-500/10 border border-blue-500/20 text-blue-200 text-sm"><?php echo e(session('info')); ?></div>
    <?php endif; ?>
    <?php if(session('status')): ?>
    <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-200 text-sm"><?php echo e(session('status')); ?></div>
    <?php endif; ?>
    <?php if($errors->any()): ?>
    <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-200 text-sm">
        <ul class="list-disc list-inside text-sm">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
    <?php endif; ?>

    <div class="bg-[#2d4a3a] rounded-2xl border border-[#4a6a56] overflow-hidden shadow-lg">
        <div class="p-6">
            <form action="<?php echo e(route('admin-users.index')); ?>" method="GET" class="flex flex-col sm:flex-row gap-4 mb-6">
                <div class="flex-1 relative"><input type="text" name="search" value="<?php echo e($search ?? ''); ?>" placeholder="Cari pengguna..." class="w-full px-4 py-3 rounded-xl bg-white text-[#1a3326] text-base border-0 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors"></div>
                <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-600 text-white text-sm font-medium hover:bg-emerald-500 transition-colors whitespace-nowrap">Cari</button>
            </form>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-[#4a6a56]">
                            <th class="px-4 py-3 text-white/70 text-sm font-medium">ID</th>
                            <th class="px-4 py-3 text-white/70 text-sm font-medium">Nama</th>
                            <th class="px-4 py-3 text-white/70 text-sm font-medium">Role</th>
                            <th class="px-4 py-3 text-white/70 text-sm font-medium">Tag</th>
                            <?php if($isSuperAdmin): ?><th class="px-4 py-3 text-white/70 text-sm font-medium text-center">Aksi</th><?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($users->isEmpty()): ?>
                            <tr><td colspan="<?php echo e($isSuperAdmin ? 5 : 4); ?>" class="px-4 py-8 text-center text-white/50">Tidak ada pengguna ditemukan.</td></tr>
                        <?php else: ?>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $isOwn = $user->user_id == $currentUserId; ?>
                                <tr class="border-b border-[#4a6a56]/50 last:border-0 hover:bg-[#3d5c4c]/30 transition-colors" data-user-id="<?php echo e($user->user_id); ?>">
                                    <td class="px-4 py-3 text-white text-sm"><?php echo e($user->user_id); ?></td>
                                    <td class="px-4 py-3 text-white text-sm">
                                        <?php echo e($user->username); ?>

                                        <?php if($isOwn): ?>
                                            <span class="ml-2 px-2 py-0.5 rounded bg-[#8fd89b] text-[#1a3326] text-[10px] font-bold uppercase">Anda</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-3 text-sm"><span class="px-2 py-1 rounded bg-[#4a6a56] text-white/80 text-xs font-medium uppercase"><?php echo e(strtolower($user->role)); ?></span></td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="inline-flex items-center px-2 py-1 rounded text-white text-xs font-medium" style="background-color: <?php echo e($user->user_type_color ?? '#6366f1'); ?>"><?php echo e($user->user_type ?? 'warga'); ?></span>
                                    </td>
                                    <?php if($isSuperAdmin && !$isOwn): ?>
                                        <td class="px-4 py-3 text-center">
                                            <div class="flex items-center justify-center gap-1">
                                                <a href="<?php echo e(route('admin-users.edit', $user->user_id)); ?>" class="w-8 h-8 rounded-lg bg-[#4a6a56] flex items-center justify-center text-white/80 hover:text-white hover:bg-[#4a6a56]/80 transition-colors text-xs" title="Edit pengguna"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></a>
                                                <a href="<?php echo e(route('admin-users.show', $user->user_id)); ?>" class="w-8 h-8 rounded-lg bg-[#4a6a56] flex items-center justify-center text-white/80 hover:text-white hover:bg-[#4a6a56]/80 transition-colors text-xs" title="Lihat detail"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></a>
                                                    <?php if(strtolower($user->role) === 'admin' && $isSuperAdmin && !$user->email_verified_at): ?>
                                                    <form method="POST" action="<?php echo e(route('admin.verify', $user->user_id)); ?>" class="inline">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit" class="w-8 h-8 rounded-lg bg-[#3d5c4c] flex items-center justify-center text-white hover:bg-[#4a6a56] transition-colors text-xs" title="Verifikasi Admin">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                        </button>
                                                    </form>
                                                    <?php endif; ?>
                                                <button onclick="confirmDeleteUser(<?php echo e($user->user_id); ?>, '<?php echo e($user->username); ?>')" class="w-8 h-8 rounded-lg bg-[#a63d3d]/20 flex items-center justify-center text-red-400/80 hover:bg-red-500/30 hover:text-red-400 transition-colors text-xs" title="Hapus"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                            </div>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <style>
                nav[aria-label="Pagination Navigation"] a.inline-flex,
                nav[aria-label="Pagination Navigation"] span.inline-flex {
                    background: #1a3326 !important;
                    border: 1px solid #4a6a56 !important;
                    color: #8fd89b !important;
                }
                nav[aria-label="Pagination Navigation"] a.inline-flex:hover:not(.cursor-not-allowed) {
                    background: #4a6a56 !important;
                    color: #fff !important;
                    border-color: #4a6a56 !important;
                }
                nav[aria-label="Pagination Navigation"] span[aria-current="page"],
                nav[aria-label="Pagination Navigation"] .bg-gray-200 {
                    background: #10b981 !important;
                    border-color: #10b981 !important;
                    color: #fff !important;
                }
                nav[aria-label="Pagination Navigation"] .cursor-not-allowed {
                    color: #6b7a70 !important;
                    border-color: #4a6a56 !important;
                    opacity: 0.6;
                }
            </style>
            <?php echo e($users->links()); ?>

        </div>
    </div>
</div>

<!-- Delete confirmation modal -->
<div id="deleteUserModal" class="fixed inset-0 z-50 hidden">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeDeleteUserModal()"></div>
    <div class="fixed inset-0 z-10 flex items-center justify-center">
        <div class="bg-[#2d4a3a] rounded-2xl border border-[#4a6a56] p-6 w-full max-w-sm shadow-xl">
            <h3 class="text-white font-semibold text-lg mb-1">Hapus Pengguna</h3>
            <p class="text-white/60 text-sm mb-6">Apakah Anda yakin ingin menghapus pengguna <span id="deleteUserName" class="text-white font-medium"></span>?</p>
            <form id="deleteUserForm" method="POST" class="flex gap-3">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <input type="hidden" name="user_id" id="deleteUserId">
                <button type="button" onclick="closeDeleteUserModal()" class="flex-1 py-2 rounded-xl bg-[#4a6a56] text-white text-sm font-medium hover:bg-[#4a6a56]/80 transition-colors">Batal</button>
                <button type="submit" class="flex-1 py-2 rounded-xl bg-[#a63d3d] text-white text-sm font-medium hover:bg-[#8f3333] transition-colors">Hapus</button>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    function confirmDeleteUser(userId, username) {
        document.getElementById('deleteUserName').textContent = username;
        document.getElementById('deleteUserForm').action = '<?php echo e(route('admin-users.destroy', ':id')); ?>'.replace(':id', userId);
        document.getElementById('deleteUserModal').classList.remove('hidden');
    }
    function closeDeleteUserModal() {
        document.getElementById('deleteUserModal').classList.add('hidden');
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\rplsm\Downloads\sapa-trantib\resources\views/users/user-index.blade.php ENDPATH**/ ?>