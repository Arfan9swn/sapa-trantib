<?php $__env->startSection('title', 'Masuk - SapaTrantib'); ?>

<?php $__env->startSection('content'); ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<div class="min-h-screen w-full relative overflow-hidden flex">
    <!-- Left: Login form panel (dark green tinted) -->
    <div class="md:w-1/2 bg-gradient-to-r from-[#1a2e1a] via-black/70 to-black/80 p-8 md:p-16 flex flex-col justify-center text-white relative z-10">
        <div class="max-w-md">
            <h2 class="text-3xl font-bold text-white mb-2">Masuk</h2>
            <p class="text-white/90 text-sm mb-8">
                Silahkan masuk dengan akun Anda.
            </p>

            <form action="<?php echo e(route('login')); ?>" method="POST" class="space-y-5">
                <?php echo csrf_field(); ?>

                <div>
                    <label class="block text-white text-sm font-medium mb-1.5">E-mail</label>
                    <div class="relative">
                        <input type="email" name="email" placeholder="Masukkan e-mail anda"
                               class="w-full pr-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all px-[20px]"
                               required>
                    </div>
                </div>

                <div>
                    <label class="block text-white text-sm font-medium mb-1.5">Kata Sandi</label>
                    <input type="password" name="password" placeholder="••••••••"
                           class="w-full pr-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all px-[20px]"
                           required>
                </div>

                <div class="flex items-center justify-between text-xs text-white/70 mb-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded text-emerald-400 bg-white/10 border-white/20 focus:ring-emerald-400">
                        Ingatkan saya
                    </label>
                    <a href="#" class="text-emerald-400 hover:text-emerald-300">Lupa kata sandi?</a>
                </div>

                <button type="submit"
                        class="w-full py-3.5 rounded-xl bg-emerald-600 text-white font-semibold hover:bg-emerald-500 transition-all duration-200 shadow-lg shadow-emerald-900/40">
                    Masuk
                </button>
            </form>

            <p class="mt-10 text-center text-white/80 text-sm">
                Belum punya akun?
                <a href="<?php echo e(route('register')); ?>" class="text-emerald-400 hover:text-emerald-300 font-medium ml-1">
                    Daftar sekarang
                </a>
            </p>
        </div>
    </div>

    <!-- Right: Photo panel -->
    <div class="md:w-1/2 hidden md:block relative">
        <img src="<?php echo e(asset('images/login-bg.jpg')); ?>" alt="Masyarakat dan petugas"
             class="w-full h-full object-cover opacity-80">
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="absolute bottom-8 left-8 z-10">
            <h3 class="text-white text-xl font-bold">SapaTrantib</h3>
            <p class="text-white/90 text-sm">Membangun Masyarakat Yang Aman dan teratur.</p>
        </div>
    </div>

    <!-- Mobile: image as full background with overlay -->
    <div class="md:hidden absolute inset-0 z-0">
        <img src="<?php echo e(asset('images/login-bg.jpg')); ?>" alt="Masyarakat dan petugas"
             class="w-full h-full object-cover opacity-60">
        <div class="absolute inset-0 bg-black/60"></div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Documents\sapa-trantip\sapa-trantib\resources\views/auth/login.blade.php ENDPATH**/ ?>