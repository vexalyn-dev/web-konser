@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="min-h-screen flex">
        <!-- Left Side - Form -->
        <div class="flex-1 flex items-center justify-center p-8">
            <div class="w-full max-w-md space-y-8">
                <!-- Logo -->
                <div class="text-center" data-aos="fade-down">
                    <div
                        class="w-16 h-16 mx-auto rounded-2xl gradient-primary flex items-center justify-center mb-4 shadow-lg shadow-blue-500/30">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold font-heading text-slate-900 dark:text-white">AGX Concert</h1>
                    <p class="mt-2 text-slate-500">Ticket Management System</p>
                </div>

                <!-- Login Form -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-8 border border-slate-200 dark:border-slate-700 shadow-xl"
                    data-aos="fade-up">
                    <h2 class="text-xl font-semibold text-slate-900 dark:text-white mb-6">Masuk ke Akun</h2>

                    <form id="loginForm" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Email</label>
                            <div class="relative">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                                <input type="email" name="email" id="email" required
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                    placeholder="admin@concert.com">
                            </div>
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Password</label>
                            <div class="relative">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <input type="password" name="password" id="password" required
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                    placeholder="••••••••">
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="remember"
                                    class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-slate-600 dark:text-slate-400">Ingat saya</span>
                            </label>
                        </div>

                        <button type="submit" id="loginBtn"
                            class="btn-ripple w-full py-3 rounded-xl gradient-primary text-white font-semibold shadow-lg shadow-blue-500/25 hover:shadow-xl hover:shadow-blue-500/30 transition-all flex items-center justify-center gap-2">
                            <span id="btnText">Masuk</span>
                            <svg id="btnSpinner" class="hidden w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </button>
                    </form>

                    <!-- Demo Credentials -->
                    <div
                        class="mt-6 p-4 rounded-xl bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800">
                        <p class="text-xs font-semibold text-blue-700 dark:text-blue-300 mb-2">Demo Credentials:</p>
                        <div class="space-y-1 text-xs text-blue-600 dark:text-blue-400">
                            <p><strong>Admin:</strong> admin@concert.com / password</p>
                            <p><strong>Staff:</strong> staff@concert.com / password</p>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <p class="text-center text-sm text-slate-500">
                    © 2026 AGX Concert. All rights reserved.
                </p>
            </div>
        </div>

        <!-- Right Side - Hero -->
        <div class="hidden lg:flex flex-1 gradient-hero items-center justify-center p-12 relative overflow-hidden">
            <!-- Decorative Elements -->
            <div class="absolute inset-0">
                <div class="absolute top-20 left-20 w-72 h-72 bg-blue-500/20 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-20 right-20 w-96 h-96 bg-purple-500/20 rounded-full blur-3xl animate-pulse"
                    style="animation-delay: 1s;"></div>
            </div>

            <div class="relative z-10 text-center text-white max-w-lg" data-aos="fade-left">
                <div
                    class="w-24 h-24 mx-auto mb-8 rounded-3xl bg-white/10 backdrop-blur-sm flex items-center justify-center border border-white/20">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                    </svg>
                </div>
                <h2 class="text-4xl font-bold font-heading mb-4">Concert Ticket<br>Management System</h2>
                <p class="text-lg text-blue-100/80 leading-relaxed">
                    Kelola tiket konser dengan mudah. Sistem check-in cepat, laporan real-time, dan pengalaman pengguna yang
                    premium.
                </p>

                <!-- Features -->
                <div class="mt-10 grid grid-cols-2 gap-4">
                    <div class="p-4 rounded-xl bg-white/10 backdrop-blur-sm border border-white/10">
                        <div class="w-10 h-10 rounded-lg bg-emerald-500/20 flex items-center justify-center mb-2">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium">QR Check-In</p>
                    </div>
                    <div class="p-4 rounded-xl bg-white/10 backdrop-blur-sm border border-white/10">
                        <div class="w-10 h-10 rounded-lg bg-blue-500/20 flex items-center justify-center mb-2">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium">Laporan Real-time</p>
                    </div>
                    <div class="p-4 rounded-xl bg-white/10 backdrop-blur-sm border border-white/10">
                        <div class="w-10 h-10 rounded-lg bg-purple-500/20 flex items-center justify-center mb-2">
                            <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium">Responsive</p>
                    </div>
                    <div class="p-4 rounded-xl bg-white/10 backdrop-blur-sm border border-white/10">
                        <div class="w-10 h-10 rounded-lg bg-amber-500/20 flex items-center justify-center mb-2">
                            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium">Aman & Terpercaya</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('loginForm').addEventListener('submit', function (e) {
                e.preventDefault();

                const btn = document.getElementById('loginBtn');
                const btnText = document.getElementById('btnText');
                const btnSpinner = document.getElementById('btnSpinner');

                btn.disabled = true;
                btnText.textContent = 'Memproses...';
                btnSpinner.classList.remove('hidden');

                const formData = new FormData(this);

                fetch('{{ route("login") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: formData,
                })
                    .then(res => res.json().then(data => ({ status: res.status, data })))
                    .then(({ status, data }) => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Login Berhasil!',
                                text: data.message,
                                timer: 1500,
                                showConfirmButton: false,
                            }).then(() => {
                                window.location.href = data.redirect;
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Login Gagal!',
                                text: data.message,
                            });
                            btn.disabled = false;
                            btnText.textContent = 'Masuk';
                            btnSpinner.classList.add('hidden');
                        }
                    })
                    .catch(() => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Terjadi kesalahan koneksi.',
                        });
                        btn.disabled = false;
                        btnText.textContent = 'Masuk';
                        btnSpinner.classList.add('hidden');
                    });
            });
        </script>
    @endpush
@endsection