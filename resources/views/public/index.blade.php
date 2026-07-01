@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Navigation -->
<nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-b border-slate-200/50 dark:border-slate-700/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl gradient-primary flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                    </svg>
                </div>
                <span class="text-lg font-bold font-heading text-slate-900 dark:text-white">AGX Concert</span>
            </div>
            
            <div class="hidden md:flex items-center gap-8">
                <a href="#home" class="text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-blue-600 transition-colors">Home</a>
                <a href="#about" class="text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-blue-600 transition-colors">About</a>
                <a href="#features" class="text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-blue-600 transition-colors">Features</a>
                <a href="#faq" class="text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-blue-600 transition-colors">FAQ</a>
            </div>
            
            <div class="flex items-center gap-3">
                <button onclick="toggleDarkMode()" class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800">
                    <svg class="w-5 h-5 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                    <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </button>
                <a href="{{ route('login') }}" class="btn-ripple px-5 py-2 rounded-xl gradient-primary text-white font-medium text-sm shadow-lg shadow-blue-500/25 hover:shadow-xl transition-all">
                    Login
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section id="home" class="relative min-h-screen flex items-center pt-16 overflow-hidden">
    <!-- Background -->
    <div class="absolute inset-0 gradient-hero"></div>
    <div class="absolute inset-0">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-purple-500/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
    </div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center max-w-4xl mx-auto">
            <div data-aos="fade-up">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-sm text-blue-200 mb-6">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Tiket Tersedia Sekarang
                </span>
            </div>
            
            <h1 class="text-4xl sm:text-5xl lg:text-7xl font-bold font-heading text-white leading-tight" data-aos="fade-up" data-aos-delay="100">
                Pengalaman Konser<br>
                <span class="bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">Tak Terlupakan</span>
            </h1>
            
            <p class="mt-6 text-lg sm:text-xl text-blue-100/80 max-w-2xl mx-auto leading-relaxed" data-aos="fade-up" data-aos-delay="200">
                Pesan tiket konser favorit Anda dengan mudah. Sistem check-in cepat menggunakan QR Code, dan nikmati pengalaman musik yang luar biasa.
            </p>
            
            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4" data-aos="fade-up" data-aos-delay="300">
                <a href="{{ route('order') }}" class="btn-ripple px-8 py-4 rounded-xl bg-white text-slate-900 font-semibold shadow-xl hover:shadow-2xl hover:scale-105 transition-all">
                    Pesan Tiket Sekarang
                </a>
                <a href="#about" class="px-8 py-4 rounded-xl border border-white/30 text-white font-semibold hover:bg-white/10 transition-all">
                    Pelajari Lebih Lanjut
                </a>
                <a href="{{ route('contact') }}" class="px-8 py-4 rounded-xl border border-white/30 text-white font-semibold hover:bg-white/10 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Hubungi Kami
                </a>
            </div>
            
            <!-- Stats -->
            <div class="mt-16 grid grid-cols-3 gap-8 max-w-lg mx-auto" data-aos="fade-up" data-aos-delay="400">
                <div>
                    <p class="text-3xl font-bold text-white">10K+</p>
                    <p class="text-sm text-blue-200/70">Tiket Terjual</p>
                </div>
                <div>
                    <p class="text-3xl font-bold text-white">50+</p>
                    <p class="text-sm text-blue-200/70">Event</p>
                </div>
                <div>
                    <p class="text-3xl font-bold text-white">99%</p>
                    <p class="text-sm text-blue-200/70">Puas</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-24 bg-white dark:bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16" data-aos="fade-up">
            <span class="text-sm font-semibold text-blue-600 uppercase tracking-wider">Fitur Unggulan</span>
            <h2 class="mt-3 text-3xl sm:text-4xl font-bold font-heading text-slate-900 dark:text-white">
                Semua yang Anda Butuhkan
            </h2>
            <p class="mt-4 text-lg text-slate-500">
                Sistem manajemen tiket konser yang lengkap dan modern.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="card-hover bg-white dark:bg-slate-800 rounded-2xl p-8 border border-slate-200 dark:border-slate-700 shadow-sm" data-aos="fade-up" data-aos-delay="100">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center mb-5">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-3">QR Code Check-In</h3>
                <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                    Check-in cepat dan aman menggunakan QR Code. Cukup scan dan masuk ke area konser.
                </p>
            </div>
            
            <!-- Feature 2 -->
            <div class="card-hover bg-white dark:bg-slate-800 rounded-2xl p-8 border border-slate-200 dark:border-slate-700 shadow-sm" data-aos="fade-up" data-aos-delay="200">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center mb-5">
                    <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-3">Laporan Real-time</h3>
                <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                    Monitor penjualan dan check-in secara real-time dengan dashboard analytics yang powerful.
                </p>
            </div>
            
            <!-- Feature 3 -->
            <div class="card-hover bg-white dark:bg-slate-800 rounded-2xl p-8 border border-slate-200 dark:border-slate-700 shadow-sm" data-aos="fade-up" data-aos-delay="300">
                <div class="w-14 h-14 rounded-2xl bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center mb-5">
                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-3">Mobile Friendly</h3>
                <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                    Akses dari perangkat manapun. Responsif dan optimal di desktop, tablet, dan mobile.
                </p>
            </div>
            
            <!-- Feature 4 -->
            <div class="card-hover bg-white dark:bg-slate-800 rounded-2xl p-8 border border-slate-200 dark:border-slate-700 shadow-sm" data-aos="fade-up" data-aos-delay="400">
                <div class="w-14 h-14 rounded-2xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center mb-5">
                    <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-3">Keamanan Terjamin</h3>
                <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                    Data Anda aman dengan enkripsi modern dan proteksi berlapis. Privasi terjaga.
                </p>
            </div>
            
            <!-- Feature 5 -->
            <div class="card-hover bg-white dark:bg-slate-800 rounded-2xl p-8 border border-slate-200 dark:border-slate-700 shadow-sm" data-aos="fade-up" data-aos-delay="500">
                <div class="w-14 h-14 rounded-2xl bg-red-50 dark:bg-red-900/30 flex items-center justify-center mb-5">
                    <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-3">Performa Cepat</h3>
                <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                    Dibangun dengan teknologi terbaru untuk pengalaman yang cepat dan smooth.
                </p>
            </div>
            
            <!-- Feature 6 -->
            <div class="card-hover bg-white dark:bg-slate-800 rounded-2xl p-8 border border-slate-200 dark:border-slate-700 shadow-sm" data-aos="fade-up" data-aos-delay="600">
                <div class="w-14 h-14 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center mb-5">
                    <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-3">Multi-User</h3>
                <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                    Kelola tim check-in dengan mudah. Role-based access control untuk keamanan.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-slate-50 dark:bg-slate-800/50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-aos="fade-up">
        <h2 class="text-3xl sm:text-4xl font-bold font-heading text-slate-900 dark:text-white mb-4">
            Siap Memesan Tiket?
        </h2>
        <p class="text-lg text-slate-600 dark:text-slate-400 mb-8">
            Jangan lewatkan kesempatan untuk menjadi bagian dari konser terbaik tahun ini.
        </p>
        <a href="{{ route('order') }}" class="btn-ripple inline-flex items-center gap-2 px-8 py-4 rounded-xl gradient-primary text-white font-semibold shadow-xl shadow-blue-500/25 hover:shadow-2xl transition-all">
            Pesan Tiket Sekarang
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
            </svg>
        </a>
    </div>
</section>

<!-- Footer -->
<footer class="bg-slate-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl gradient-primary flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold font-heading">AGX Concert</span>
                </div>
                <p class="text-slate-400 text-sm leading-relaxed">
                    Sistem manajemen tiket konser modern untuk pengalaman terbaik.
                </p>
            </div>
            
            <div>
                <h4 class="font-semibold mb-4">Quick Links</h4>
                <ul class="space-y-2 text-sm text-slate-400">
                    <li><a href="#home" class="hover:text-white transition-colors">Home</a></li>
                    <li><a href="#about" class="hover:text-white transition-colors">About</a></li>
                    <li><a href="#features" class="hover:text-white transition-colors">Features</a></li>
                    <li><a href="{{ route('order') }}" class="hover:text-white transition-colors">Order Ticket</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="font-semibold mb-4">Contact</h4>
                <ul class="space-y-2 text-sm text-slate-400">
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        info@agxconcert.com
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        +62 812-3456-7890
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="mt-12 pt-8 border-t border-slate-800 text-center text-sm text-slate-500">
            <p>© 2026 AGX Concert. All rights reserved.</p>
        </div>
    </div>
</footer>
@endsection