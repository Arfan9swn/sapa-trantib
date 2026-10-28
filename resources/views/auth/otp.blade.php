@extends('layout.app')

@section('title', 'Verifikasi OTP - SapaTrantib')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

@if(session('status'))
<div class="absolute top-6 left-1/2 -translate-x-1/2 z-50">
    <div class="bg-[#3d5c4c] text-white px-6 py-3 rounded-lg shadow-lg border border-[#4a6a56]">
        {{ session('status') }}
    </div>
</div>
@endif

<div class="fixed inset-0 w-screen h-screen z-50 overflow-hidden flex bg-[#172111]">

    <!-- Background Image with Dark Gradient Overlay (Full Screen) -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/login-bg.jpg') }}" alt="Background OTP"
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
                    {{ session('email', 'no.email user') }}
                </p>
            </div>

            <!-- OTP Form -->
            <form action="{{ route('otp.verify') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="email" value="{{ session('email') }}">

                <!-- OTP Input Boxes -->
                <div class="flex gap-3 justify-center mb-8">
                    @for ($i = 1; $i <= 6; $i++)
                        <input type="text" name="otp[{{ $i }}]" maxlength="1"
                               class="w-12 h-12 rounded-xl bg-white border-0 text-2xl font-bold text-center text-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-all"
                               inputmode="numeric" pattern="[0-9]*"
                               data-otp-slot="{{ $i }}">
                    @endfor
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full py-3.5 rounded-xl bg-[#4b6b43] hover:bg-[#3d5835] text-white font-medium text-base transition-all duration-200 shadow-lg border border-white/10">
                    Masuk
                </button>

                <!-- Resend OTP Button & Cooldown -->
                <button type="button" id="resendBtn"
                        class="w-full py-3 rounded-xl bg-[#4b6b43]/20 hover:bg-[#4b6b43]/40 text-white font-medium text-sm transition-all border border-white/10 disabled:opacity-50 disabled:cursor-not-allowed"
                        @if(session('otp_resend_at') && (now()->getTimestamp() - session('otp_resend_at')) < 60) disabled @endif>
                    Kirim Ulang Kode
                </button>
                <span id="resendTimer" class="text-white/60 text-xs mt-2 block @if(!(session('otp_resend_at') && (now()->getTimestamp() - session('otp_resend_at')) < 60)) hidden @endif"></span>
            </form>

            <!-- Link to change email -->
            <div class="mt-8 text-center text-white/70 text-sm">
                Salah Email ?
                <a href="{{ route('admin.login') }}" class="text-emerald-400 hover:text-emerald-300 font-medium ml-1">
                    Klik di sini untuk kembali ke halaman masuk admin.
                </a>
            </div>

        </div>
    </div>
</div>

<script>
    // Warn and redirect to register when the OTP page is refreshed
    document.addEventListener('DOMContentLoaded', function () {
        var navEntries = performance.getEntriesByType('navigation');
        if (navEntries.length > 0 && navEntries[0].type === 'reload') {
            var accepted = confirm(
                'Anda sedang merefresh halaman verifikasi OTP. ' +
                'Jika Anda melanjutkan, Anda akan dikembalikan ke halaman masuk admin.'
            );
            if (accepted) {
                window.location.href = '{{ route('admin.login') }}';
            }
        }
    });

    // Resend OTP cooldown + AJAX
    (function () {
        var btn = document.getElementById('resendBtn');
        var timer = document.getElementById('resendTimer');
        var remaining = {{ session('otp_resend_at') ? max(0, 60 - (now()->getTimestamp() - session('otp_resend_at'))) : 0 }};

        function updateTimer() {
            if (remaining <= 0) {
                btn.disabled = false;
                timer.classList.add('hidden');
                return false;
            }
            btn.disabled = true;
            timer.classList.remove('hidden');
            timer.textContent = 'Kirim ulang dalam ' + remaining + ' detik';
            remaining--;
            return true;
        }

        if (updateTimer()) {
            var intervalId = setInterval(function () {
                if (!updateTimer()) clearInterval(intervalId);
            }, 1000);
        }

        btn.addEventListener('click', function (e) {
            e.preventDefault();
            if (btn.disabled) return;

            fetch('{{ route('otp.resend') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                credentials: 'same-origin'
            })
            .then(function (response) {
                if (!response.ok) throw new Error('Gagal mengirim ulang');
                // Navigate normally (not reload) to show flash messages
                window.location.href = '{{ route('otp') }}';
            })
            .catch(function () {
                alert('Gagal mengirim ulang kode. Silakan coba lagi.');
            });
        });
    })();

    // OTP auto-advance slots
    (function () {
        var slots = document.querySelectorAll('input[data-otp-slot]');

        slots.forEach(function (slot, index) {
            slot.addEventListener('input', function (e) {
                var value = e.target.value;

                // Only allow single digit
                if (!/^\d$/.test(value)) {
                    e.target.value = '';
                    return;
                }

                // Auto-advance to next slot
                if (index < slots.length - 1) {
                    slots[index + 1].focus();
                }
            });

            slot.addEventListener('keydown', function (e) {
                // Backspace on empty slot → move to previous
                if (e.key === 'Backspace' && e.target.value === '' && index > 0) {
                    e.preventDefault();
                    slots[index - 1].focus();
                }

                // Arrow keys navigation
                if (e.key === 'ArrowLeft' && index > 0) {
                    e.preventDefault();
                    slots[index - 1].focus();
                }
                if (e.key === 'ArrowRight' && index < slots.length - 1) {
                    e.preventDefault();
                    slots[index + 1].focus();
                }
            });

            // Paste support: distribute across remaining slots
            slot.addEventListener('paste', function (e) {
                e.preventDefault();
                var paste = (e.clipboardData || window.clipboardData).getData('text');
                var digits = paste.replace(/\D/g, '').slice(0, slots.length - index);

                digits.split('').forEach(function (digit, i) {
                    slots[index + i].value = digit;
                });

                var nextIndex = index + digits.length;
                if (nextIndex < slots.length) {
                    slots[nextIndex].focus();
                }
            });
        });

        // Focus first slot on load
        if (slots.length > 0) {
            slots[0].focus();
        }
    })();
</script>
@endsection