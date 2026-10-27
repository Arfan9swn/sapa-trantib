<?php $__env->startSection('title', 'Verifikasi OTP - SapaTrantib'); ?>

<?php $__env->startSection('content'); ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<div class="fixed inset-0 w-screen h-screen z-50 overflow-hidden flex bg-[#172111]">

    <!-- Background Image with Dark Gradient Overlay (Full Screen) -->
    <div class="absolute inset-0 z-0">
        <img src="<?php echo e(asset('images/login-bg.jpg')); ?>" alt="Background OTP"
             class="w-full h-full object-cover">
        <!-- Gradasi gelap di sebelah kiri agar form mudah dibaca, dan transparan di kanan -->
        <div class="absolute inset-0 bg-gradient-to-r from-[#172111]/95 via-[#172111]/80 to-black/50"></div>
    </div>

    <!-- Content Container -->
    <div class="relative z-10 flex w-full h-full items-center p-6 md:p-16 lg:p-24">
        <div class="w-full max-w-md">

            <!-- Header Text -->
            <div class="mb-8">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-2 tracking-tight">Verifikasi OTP</h1>
                <p class="text-white/80 text-base md:text-lg">
                    Mohon lanjutkan verifikasi menggunakan Kode OTP yang sudah dikirim ke
                </p>
                <p class="text-white text-base md:text-lg font-medium mt-2">
                    <<?php echo e($phone ?? 'no.telp user'); ?>>
                </p>
            </div>

            <!-- OTP Form -->
            <form action="<?php echo e(route('otp.verify')); ?>" method="POST" class="space-y-6">
                <?php echo csrf_field(); ?>

                <!-- OTP Input Boxes -->
                <div class="flex gap-3 justify-center mb-8">
                    <?php for($i = 1; $i <= 6; $i++): ?>
                        <input type="text" name="otp[<?php echo e($i); ?>]" maxlength="1"
                               class="w-12 h-12 rounded-xl bg-white border-0 text-2xl font-bold text-center text-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all"
                               inputmode="numeric" pattern="[0-9]*">
                    <?php endfor; ?>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full py-3.5 rounded-xl bg-[#4b6b43] hover:bg-[#3d5835] text-white font-medium text-base transition-all duration-200 shadow-lg border border-white/10">
                    Masuk
                </button>
            </form>

            <!-- Link to change phone number -->
            <div class="mt-8 text-center text-white/70 text-sm">
                Salah Email ?
                <a href="<?php echo e(route('register')); ?>" class="text-emerald-400 hover:text-emerald-300 font-medium ml-1">
                    Klik di sini untuk mengganti Email anda.
                </a>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Documents\sapa-trantip\sapa-trantib\resources\views/auth/otp.blade.php ENDPATH**/ ?>