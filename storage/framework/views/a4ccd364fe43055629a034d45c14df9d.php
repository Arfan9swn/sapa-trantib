

<?php $__env->startSection('title', 'Kelola User Tags - SapaTrantib'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-white">Kelola tag pengguna</h1>
            <p class="text-white/60 text-sm">Buat, ubah, hapus tag pengguna dengan warna kustom</p>
        </div>
        <a href="<?php echo e(route('admin-user-tags.create')); ?>" class="inline-flex items-center justify-center w-full lg:w-auto px-6 py-3 text-sm font-medium text-white bg-emerald-600 rounded-xl hover:bg-emerald-500 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah tag
        </a>
    </div>

    <?php if(session('success')): ?>
    <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-200 text-sm"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if(session('warning')): ?>
    <div class="mb-6 p-4 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-200 text-sm"><?php echo e(session('warning')); ?></div>
    <?php endif; ?>

    <div class="bg-[#2d4a3a] rounded-2xl border border-[#4a6a56] p-6 shadow-lg mb-8">
        <h3 class="text-white font-semibold text-lg mb-4">Daftar Tag</h3>
        <?php if($tags->isEmpty()): ?>
            <p class="text-white/60 text-sm">Belum ada tag. Tambahkan tag pertama.</p>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex items-center justify-between px-4 py-3 rounded-xl bg-[#1a3326] border border-[#4a6a56]">
                    <div class="flex items-center gap-3 min-w-0">
                        <span class="inline-block w-6 h-6 rounded-full border border-white/20" style="background-color: <?php echo e($tag->color); ?>"></span>
                        <span class="text-white font-medium truncate"><?php echo e($tag->name); ?></span>
                        <span class="text-white/50 text-xs"><?php echo e($tag->color); ?></span>
                    </div>
                    <div class="flex items-center gap-2 ml-2">
                        <a href="<?php echo e(route('admin-user-tags.edit', $tag->tag_id)); ?>" class="text-emerald-300 hover:text-emerald-200 text-sm">Edit</a>
                        <form action="<?php echo e(route('admin-user-tags.destroy', $tag->tag_id)); ?>" method="POST" class="inline" onsubmit="return confirm('Hapus tag ini?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="text-red-300 hover:text-red-200 text-sm">Hapus</button>
                        </form>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="bg-[#2d4a3a] rounded-2xl border border-[#4a6a56] p-8 shadow-lg">
        <h3 class="text-white font-semibold text-lg mb-6">Terapkan Tag ke Pengguna</h3>
        <?php if($tags->isEmpty()): ?>
            <p class="text-white/60 text-sm">Buat tag terlebih dahulu sebelum menerapkan.</p>
        <?php else: ?>
        <form action="<?php echo e(route('admin-user-tags.apply')); ?>" method="POST" class="space-y-6">
            <?php echo csrf_field(); ?>
            <div>
                <label class="block text-sm font-medium text-white/90 mb-2">Pilih Tag</label>
                <select name="tag_id" class="w-full px-4 py-3 rounded-xl bg-white text-[#1a3326] text-base border-0 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors">
                    <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($tag->tag_id); ?>"><?php echo e($tag->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-white/90 mb-4">Pilih Pengguna</label>
                <div class="space-y-2 max-h-80 overflow-y-auto">
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center px-3 py-2 rounded bg-[#1a3326] hover:bg-[#2d4a3a] transition-colors" data-user-id="<?php echo e($user->user_id); ?>">
                        <input type="checkbox" name="user_ids[]" value="<?php echo e($user->user_id); ?>" class="w-4 h-4 mr-2 accent-emerald-600">
                        <div class="flex-1 min-w-0 flex items-center gap-2">
                            <span class="text-white/80 text-sm font-medium"><?php echo e($user->username); ?></span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium text-white" style="background-color: <?php echo e($user->user_type_color ?? '#6366f1'); ?>"><?php echo e($user->user_type ?? 'warga'); ?></span>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <div class="flex gap-3 pt-6 border-t border-white/10">
                <a href="<?php echo e(route('admin-users.index')); ?>" class="flex-1 py-2 rounded-xl bg-[#4a6a56] text-white text-sm font-medium hover:bg-[#3d5c4c] transition-colors text-center">Kembali</a>
                <button type="submit" class="flex-1 py-2 rounded-xl bg-emerald-600 text-white text-sm font-medium hover:bg-emerald-500 transition-colors">Terapkan Tag</button>
            </div>
        </form>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\rplsm\Downloads\sapa-trantib\resources\views/user-tags/index.blade.php ENDPATH**/ ?>