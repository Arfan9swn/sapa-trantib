<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'SapaTrantib')</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Archivo+Narrow:wght@400;500;600;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        @vite('resources/css/app.css')
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
    @php($isAuthRoute = in_array(request()->path(), ['otp', '/admin/login', 'admin/login', 'forgot-password', 'admin/register', 'admin/register-success', '/']))
    <body class="antialiased bg-[#1a3326] text-white min-h-screen {{ $isAuthRoute ? 'flex items-center justify-center' : '' }}">

        @if (!$isAuthRoute)
            <!-- Navbar -->
            @include('layout.navbar')

            <div class="flex h-screen overflow-hidden">
                <!-- Sidebar -->
                @include('layout.sidebar')

                <!-- Main Content -->
                <main class="flex-1 overflow-y-auto bg-[#1a3326] relative z-0">
                    @yield('content')
                </main>
            </div>
        @else
            <!-- Auth page: full screen content, no navbar/sidebar -->
            <div class="flex-1 w-full h-screen relative z-0">
                @yield('content')
            </div>
        @endif
    </body>
</html>