

<?php $__env->startSection('title', 'Masuk Admin - SapaTrantib'); ?>

<?php $__env->startSection('content'); ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<div class="fixed inset-0 w-screen h-screen z-50 overflow-hidden flex bg-[#172111]">

    <!-- Background Image with Dark Gradient Overlay -->
    <div class="absolute inset-0 z-0">
        <img src="<?php echo e(asset('images/login-bg.jpg')); ?>" alt="Background Admin Login"
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-[#172111]/95 via-[#172111]/80 to-black/50"></div>
    </div>

    <!-- Content Container -->
    <div class="relative z-10 flex w-full h-full items-center p-6 md:p-16 lg:p-24">
        <div class="w-full max-w-md">
            <div class="mb-8">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-2 tracking-tight">Masuk Admin</h1>
                <p class="text-white/80 text-base md:text-lg">
                    Silahkan masuk dengan akun admin Anda.
                </p>
            </div>

            <form action="<?php echo e(route('admin.login.post')); ?>" method="POST" class="space-y-5">
                <?php echo csrf_field(); ?>

                <div>
                    <label class="block text-white text-sm font-medium mb-1.5">E-mail</label>
                    <div class="relative">
                        <input type="email" name="email" placeholder="Masukkan e-mail admin Anda..."
                               class="w-full pl-10 pr-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all"
                               required>
                    </div>
                </div>

                <div>
                    <label class="block text-white text-sm font-medium mb-1.5">Kata Sandi</label>
                    <input type="password" name="password" placeholder="••••••••"
                           class="w-full pl-10 pr-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all"
                           required>
                </div>

                <div class="flex items-center justify-between text-xs text-white/70 mb-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded text-emerald-400 bg-white/10 border-white/20 focus:ring-emerald-400">
                        Ingatkan saya
                    </label>
                </div>

                <?php if($errors->any()): ?>
                <div class="p-3 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
                    <?php echo e($errors->first()); ?>

                </div>
                <?php endif; ?>

                <button type="submit"
                        class="w-full py-3.5 rounded-xl bg-emerald-600 text-white font-semibold hover:bg-emerald-500 transition-all duration-200 shadow-lg shadow-emerald-900/40">
                    Masuk Admin
                </button>
            </form>

            <p class="mt-10 text-center text-white/80 text-sm">
                Masuk sebagai warga?
                <a href="<?php echo e(route('login')); ?>" class="text-emerald-400 hover:text-emerald-300 font-medium ml-1">
                    Masuk sebagai warga
                </a>
            </p>

            <p class="mt-6 text-center text-white/60 text-sm">
                Belum punya akun admin?
                <a href="<?php echo e(route('register')); ?>" class="text-emerald-400 hover:text-emerald-300 font-medium ml-1">
                    Daftar admin
                </a>
            </p>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\rplsm\Downloads\sapa-trantib\resources\views/auth/admin-login.blade.php ENDPATH**/ ?>