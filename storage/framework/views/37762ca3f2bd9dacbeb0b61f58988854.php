

<?php $__env->startSection('title', 'Tambah User Tag - SapaTrantib'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="<?php echo e(route('admin-user-tags.index')); ?>" class="inline-flex items-center text-sm text-white/70 hover:text-white">← Kembali ke daftar tag</a>
    </div>
    <div class="bg-[#2d4a3a] rounded-2xl border border-[#4a6a56] p-8 shadow-xl">
        <h2 class="text-xl font-bold text-white mb-6">Tambah User Tag</h2>
        <form action="<?php echo e(route('admin-user-tags.store')); ?>" method="POST" class="space-y-6">
            <?php echo csrf_field(); ?>
            <div>
                <label class="block text-sm font-medium text-white/90 mb-2">Nama Tag</label>
                <input type="text" name="name" value="<?php echo e(old('name')); ?>" required class="w-full px-4 py-3 rounded-xl bg-white text-[#1a3326] text-base border-0 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors" placeholder="cth: Kelurahan">
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-300 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <label class="block text-sm font-medium text-white/90 mb-2">Warna Tag</label>
                <input type="color" name="color" value="<?php echo e(old('color', '#6366f1')); ?>" required class="w-full h-12 rounded-xl bg-white p-2 border-0 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-colors">
                <p class="text-white/60 text-sm mt-1">Pilih warna kustom untuk tag</p>
                <?php $__errorArgs = ['color'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-300 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="flex gap-3 pt-4">
                <a href="<?php echo e(route('admin-user-tags.index')); ?>" class="flex-1 py-2 rounded-xl bg-[#4a6a56] text-white text-sm font-medium text-center hover:bg-[#3d5c4c] transition-colors">Batal</a>
                <button type="submit" class="flex-1 py-2 rounded-xl bg-emerald-600 text-white text-sm font-medium hover:bg-emerald-500 transition-colors">Simpan</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\rplsm\Downloads\sapa-trantib\resources\views/user-tags/create.blade.php ENDPATH**/ ?>