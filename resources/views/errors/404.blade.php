@extends('layouts.app')

@section('title', '404 - Halaman Tidak Ditemukan')

@section('content')
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-50 to-blue-50 dark:from-slate-900 dark:to-slate-800 px-4">
        <div class="max-w-md w-full text-center" data-aos="fade-up">
            <!-- Error Icon -->
            <div class="relative mb-8">
                <div
                    class="w-32 h-32 mx-auto rounded-full bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                    <svg class="w-16 h-16 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div
                    class="absolute -top-2 -right-2 w-12 h-12 rounded-full bg-amber-500 flex items-center justify-center text-white font-bold text-xl shadow-lg">
                    404
                </div>
            </div>

            <!-- Error Message -->
            <h1 class="text-3xl font-bold font-heading text-slate-900 dark:text-white mb-3">
                Halaman Tidak Ditemukan
            </h1>
            <p class="text-slate-600 dark:text-slate-400 mb-8 leading-relaxed">
                Oops! Halaman yang Anda cari tidak ditemukan atau mungkin telah dipindahkan. Silakan periksa kembali URL
                atau kembali ke beranda.
            </p>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ url()->previous() }}"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 font-medium hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
                <a href="{{ route('home') }}"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl gradient-primary text-white font-medium shadow-lg shadow-blue-500/25 hover:shadow-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Ke Beranda
                </a>
            </div>

            <!-- Search Suggestion -->
            <div class="mt-8 p-4 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-3">Mungkin Anda sedang mencari:</p>
                <div class="flex flex-wrap gap-2 justify-center">
                    <a href="{{ route('home') }}"
                        class="px-3 py-1.5 rounded-lg bg-white dark:bg-slate-700 text-sm text-slate-700 dark:text-slate-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors">
                        Beranda
                    </a>
                    <a href="{{ route('order') }}"
                        class="px-3 py-1.5 rounded-lg bg-white dark:bg-slate-700 text-sm text-slate-700 dark:text-slate-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors">
                        Pesan Tiket
                    </a>
                    <a href="{{ route('login') }}"
                        class="px-3 py-1.5 rounded-lg bg-white dark:bg-slate-700 text-sm text-slate-700 dark:text-slate-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection