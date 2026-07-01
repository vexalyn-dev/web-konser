@extends('layouts.app')

@section('title', '500 - Server Error')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-50 to-blue-50 dark:from-slate-900 dark:to-slate-800 px-4">
    <div class="max-w-md w-full text-center" data-aos="fade-up">
        <!-- Error Icon -->
        <div class="relative mb-8">
            <div class="w-32 h-32 mx-auto rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                <svg class="w-16 h-16 text-red-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div class="absolute -top-2 -right-2 w-12 h-12 rounded-full bg-red-500 flex items-center justify-center text-white font-bold text-xl shadow-lg">
                500
            </div>
        </div>
        
        <!-- Error Message -->
        <h1 class="text-3xl font-bold font-heading text-slate-900 dark:text-white mb-3">
            Server Error
        </h1>
        <p class="text-slate-600 dark:text-slate-400 mb-8 leading-relaxed">
            Maaf, terjadi kesalahan pada server kami. Tim teknis telah diberitahu dan sedang bekerja untuk memperbaikinya. Silakan coba lagi dalam beberapa saat.
        </p>
        
        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <button onclick="window.location.reload()" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 font-medium hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Coba Lagi
            </button>
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl gradient-primary text-white font-medium shadow-lg shadow-blue-500/25 hover:shadow-xl transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Ke Beranda
            </a>
        </div>
        
        <!-- Status Info -->
        <div class="mt-8 p-4 rounded-xl bg-amber-50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-800">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="text-left">
                    <p class="text-sm font-medium text-amber-900 dark:text-amber-300">Informasi Error</p>
                    <p class="text-xs text-amber-700 dark:text-amber-400 mt-1">
                        @if(app()->hasDebugModeEnabled() && isset($exception))
                            {{ $exception->getMessage() }}
                        @else
                            Error ID: #{{ substr(md5(now()->timestamp), 0, 8) }}
                        @endif
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Contact Support -->
        <div class="mt-6 text-sm text-slate-500 dark:text-slate-400">
            <p>Masih mengalami masalah? <a href="mailto:support@agxconcert.com" class="text-blue-600 hover:text-blue-700 font-medium">Hubungi support</a></p>
        </div>
    </div>
</div>
@endsection