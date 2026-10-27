<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $__env->yieldContent('title', 'SapaTrantib'); ?></title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Archivo+Narrow:wght@400;500;600;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
        <style>
            /* Custom sidebar scrollbar */
            .sidebar-scroll::-webkit-scrollbar {
                width: 6px;
            }
            .sidebar-scroll::-webkit-scrollbar-track {
                background: transparent;
            }
            .sidebar-scroll::-webkit-scrollbar-thumb {
                background: rgba(255, 255, 255, 0.1);
                border-radius: 3px;
            }
            .sidebar-scroll::-webkit-scrollbar-thumb:hover {
                background: rgba(255, 255, 255, 0.2);
            }
        </style>
    </head>
    <?php ($isAuthRoute = in_array(request()->path(), ['login', 'register', 'otp', 'account-type', 'landing', 'forgot-password'])); ?>
    <body class="antialiased bg-[#1a3326] text-white min-h-screen <?php echo e($isAuthRoute ? 'flex items-center justify-center' : ''); ?>">

        <?php if(!$isAuthRoute): ?>
            <!-- Navbar -->
            <?php echo $__env->make('layout.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <div class="flex h-screen overflow-hidden">
                <!-- Sidebar -->
                <?php echo $__env->make('layout.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                <!-- Main Content -->
                <main class="flex-1 overflow-y-auto bg-[#1a3326] relative z-0">
                    <?php echo $__env->yieldContent('content'); ?>
                </main>
            </div>
        <?php else: ?>
            <!-- Auth page: full screen content, no navbar/sidebar -->
            <div class="flex-1 w-full h-screen relative z-0">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        <?php endif; ?>
    </body>
</html><?php /**PATH C:\Users\rplsm\Downloads\sapa-trantib\resources\views/layout/app.blade.php ENDPATH**/ ?>