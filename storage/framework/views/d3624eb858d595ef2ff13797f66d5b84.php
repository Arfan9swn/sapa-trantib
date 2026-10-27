<?php $__env->startSection('title', 'Lupa Kata Sandi - SapaTrantib'); ?>

<?php $__env->startSection('content'); ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<div class="fixed inset-0 w-screen h-screen z-50 overflow-hidden flex bg-[#172111]">

    <!-- Background Image with Dark Gradient Overlay (Full Screen) -->
    <div class="absolute inset-0 z-0">
        <img src="<?php echo e(asset('images/login-bg.jpg')); ?>" alt="Background Lupa Kata Sandi"
             class="w-full h-full object-cover">
        <!-- Gradasi gelap di sebelah kiri agar form mudah dibaca, dan transparan di kanan -->
        <div class="absolute inset-0 bg-gradient-to-r from-[#172111]/95 via-[#172111]/80 to-black/50"></div>
    </div>

    <!-- Content Container -->
    <div class="relative z-10 flex w-full h-full items-center p-6 md:p-16 lg:p-24">
        <div class="w-full max-w-md">

            <!-- Header Text -->
            <div class="mb-8">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-2 tracking-tight">Lupa kata sandi</h1>
                <p class="text-white/80 text-base md:text-lg">
                    Ubah Sandi Anda !
                </p>
            </div>

            <!-- Forgot Password Form -->
            <form action="<?php echo e(route('password.update')); ?>" method="POST" class="space-y-6">
                <?php echo csrf_field(); ?>

                <!-- Input Email -->
                <div>
                    <label class="block text-white text-sm font-medium mb-1.5">Email</label>
                    <input type="email" name="email" placeholder="Ketik Email..."
                           class="w-full px-4 py-3.5 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all shadow-inner"
                           required>
                </div>

                <!-- Input Password -->
                <div>
                    <label class="block text-white text-sm font-medium mb-1.5">Password</label>
                    <input type="password" name="password" placeholder="Ketik Password baru..."
                           class="w-full px-4 py-3.5 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all shadow-inner"
                           required>
                </div>

                <!-- Input Konfirmasi Password -->
                <div>
                    <label class="block text-white text-sm font-medium mb-1.5">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" placeholder="Konfirmasi Password baru..."
                           class="w-full px-4 py-3.5 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all shadow-inner"
                           required>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full py-3.5 rounded-xl bg-[#4b6b43] hover:bg-[#3d5835] text-white font-medium text-base transition-all duration-200 shadow-lg border border-white/10">
                    Ubah Password
                </button>
            </form>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Documents\sapa-trantip\sapa-trantib\resources\views/auth/forgot-password.blade.php ENDPATH**/ ?>