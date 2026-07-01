@extends('layouts.app')

@section('title', 'Tiket Anda')

@section('content')
    <!-- Navigation -->
    <nav
        class="fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-b border-slate-200/50 dark:border-slate-700/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl gradient-primary flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                    </div>
                    <span class="text-lg font-bold font-heading text-slate-900 dark:text-white">AGX Concert</span>
                </a>

                <button onclick="toggleDarkMode()"
                    class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800">
                    <svg class="w-5 h-5 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen pt-24 pb-16 bg-slate-50 dark:bg-slate-900">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success Message -->
            <div class="text-center mb-8" data-aos="fade-up">
                <div
                    class="w-16 h-16 mx-auto rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold font-heading text-slate-900 dark:text-white">Tiket Berhasil
                    Dipesan!</h1>
                <p class="mt-2 text-slate-600 dark:text-slate-400">Simpan kode tiket ini untuk check-in di lokasi.</p>
            </div>

            <!-- Ticket Card -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xl overflow-hidden"
                data-aos="fade-up" data-aos-delay="100">
                <!-- Ticket Header -->
                <div class="gradient-primary p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-blue-200">AGX Concert 2026</p>
                            <h2 class="text-2xl font-bold font-heading">E-Ticket</h2>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Ticket Body -->
                <div class="p-6 lg:p-8">
                    <!-- QR Code -->
                    <div class="flex justify-center mb-6">
                        <div class="p-4 bg-white rounded-xl border-2 border-dashed border-slate-300">
                            <img src="{{ $qrCodeBase64 }}" alt="QR Code" class="w-48 h-48">
                        </div>
                    </div>

                    <!-- Ticket Code -->
                    <div class="text-center mb-6">
                        <p class="text-sm text-slate-500 mb-1">Kode Tiket</p>
                        <p class="text-2xl font-bold font-mono text-slate-900 dark:text-white">{{ $ticket->ticket_code }}
                        </p>
                    </div>

                    <hr class="border-slate-200 dark:border-slate-700 my-6">

                    <!-- Ticket Details -->
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-slate-400 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <div>
                                <p class="text-xs text-slate-500">Nama</p>
                                <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $ticket->full_name }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-slate-400 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                            <div>
                                <p class="text-xs text-slate-500">Email</p>
                                <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $ticket->email }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-slate-400 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <div>
                                <p class="text-xs text-slate-500">No. HP</p>
                                <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $ticket->phone }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-slate-400 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <div>
                                <p class="text-xs text-slate-500">Kota</p>
                                <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $ticket->city }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-slate-400 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="text-xs text-slate-500">Status</p>
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $ticket->status === 'checked_in' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' }}">
                                    {{ $ticket->status_name }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ticket Footer -->
                <div
                    class="px-6 lg:px-8 py-5 bg-slate-50 dark:bg-slate-700/30 border-t border-slate-200 dark:border-slate-700 flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a href="{{ route('ticket.download-qrcode', $ticket->ticket_code) }}"
                        class="btn-ripple w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl gradient-primary text-white font-medium shadow-lg shadow-blue-500/25 hover:shadow-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Download QR
                    </a>
                    <button onclick="window.print()"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-400 font-medium hover:bg-slate-100 dark:hover:bg-slate-700 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Print
                    </button>
                </div>
            </div>

            <!-- Info Card -->
            <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 rounded-xl p-5 border border-blue-100 dark:border-blue-800"
                data-aos="fade-up" data-aos-delay="200">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-blue-900 dark:text-blue-300">Informasi Penting</p>
                        <ul class="mt-2 text-sm text-blue-700 dark:text-blue-400 space-y-1">
                            <li>• Tunjukkan QR Code atau kode tiket saat check-in</li>
                            <li>• Satu tiket hanya dapat digunakan satu kali</li>
                            <li>• Datanglah 30 menit sebelum acara dimulai</li>
                            <li>• Hubungi kami jika ada kendala dengan tiket Anda</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Back to Home -->
            <div class="mt-8 text-center" data-aos="fade-up" data-aos-delay="300">
                <a href="{{ route('home') }}" class="text-sm text-slate-500 hover:text-blue-600 transition-colors">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>
    </main>
@endsection