@extends('layouts.app')

@section('title', $concert->name)

@section('content')
<!-- Navigation -->
<nav class="fixed top-0 left-0 right-0 z-50 glass border-b border-white/20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl gradient-primary flex items-center justify-center shadow-lg shadow-blue-500/30">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold font-heading bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">AGX Concert</h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400 -mt-1">Ticket Management</p>
                </div>
            </a>
            
            <div class="flex items-center gap-3">
                <button onclick="toggleDarkMode()" class="p-2.5 rounded-xl text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
                    <svg class="w-5 h-5 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                    <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </button>
                <a href="{{ route('order', $concert->slug) }}" class="btn-ripple inline-flex items-center gap-2 px-6 py-2.5 rounded-xl gradient-primary text-white font-medium text-sm shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transition-all">
                    Pesan Tiket
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- Hero Banner -->
<section class="relative pt-32 pb-20 overflow-hidden">
    <div class="absolute inset-0 gradient-hero"></div>
    <div class="absolute inset-0">
        <div class="absolute top-20 left-20 w-96 h-96 bg-blue-500/30 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-20 w-80 h-80 bg-purple-500/30 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div data-aos="fade-right">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 mb-6">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-sm font-medium text-white">{{ $concert->status_name }}</span>
                </div>
                
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold font-heading text-white leading-tight mb-6">
                    {{ $concert->name }}
                </h1>
                
                <p class="text-xl text-blue-100/90 leading-relaxed mb-8">
                    {{ $concert->description }}
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('order', $concert->slug) }}" class="btn-ripple inline-flex items-center justify-center gap-3 px-8 py-4 rounded-2xl bg-white text-slate-900 font-bold text-lg shadow-2xl hover:scale-105 transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                        </svg>
                        Pesan Tiket
                    </a>
                    <a href="#info" class="inline-flex items-center justify-center gap-3 px-8 py-4 rounded-2xl bg-white/10 backdrop-blur-md border-2 border-white/30 text-white font-bold text-lg hover:bg-white/20 transition-all">
                        Info Lengkap
                    </a>
                </div>
            </div>
            
            <div class="hidden lg:block" data-aos="fade-left">
                <div class="relative">
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 rounded-3xl blur opacity-30"></div>
                    <div class="relative bg-white/10 backdrop-blur-xl rounded-3xl p-8 border border-white/20">
                        <div class="space-y-6 text-white">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-2xl bg-blue-500/20 flex items-center justify-center">
                                    <svg class="w-7 h-7 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-blue-200">Tanggal</p>
                                    <p class="text-lg font-bold">{{ $concert->start_date->format('d F Y') }}</p>
                                    <p class="text-sm text-blue-200">{{ $concert->start_date->format('H:i') }} WIB</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-2xl bg-purple-500/20 flex items-center justify-center">
                                    <svg class="w-7 h-7 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-blue-200">Lokasi</p>
                                    <p class="text-lg font-bold">{{ $concert->venue }}</p>
                                    <p class="text-sm text-blue-200">{{ $concert->location }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-2xl bg-emerald-500/20 flex items-center justify-center">
                                    <svg class="w-7 h-7 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-blue-200">Harga Tiket</p>
                                    <p class="text-3xl font-bold">Rp {{ number_format($concert->ticket_price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            
                            <div class="pt-4 border-t border-white/20">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-blue-200">Tiket Tersedia</p>
                                        <p class="text-xl font-bold">{{ number_format($concert->available_tickets) }} / {{ number_format($concert->capacity) }}</p>
                                    </div>
                                    @if($concert->is_sold_out)
                                        <span class="px-4 py-2 rounded-xl bg-red-500/20 text-red-300 font-bold border border-red-500/30">SOLD OUT</span>
                                    @else
                                        <span class="px-4 py-2 rounded-xl bg-emerald-500/20 text-emerald-300 font-bold border border-emerald-500/30">AVAILABLE</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Concert Info -->
<section id="info" class="py-20 bg-white dark:bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8" data-aos="fade-up">
                <div>
                    <h2 class="text-3xl font-bold font-heading text-slate-900 dark:text-white mb-6">Tentang Konser</h2>
                    <div class="prose prose-lg dark:prose-invert max-w-none text-slate-600 dark:text-slate-400">
                        <p class="leading-relaxed">{{ $concert->description }}</p>
                    </div>
                </div>
                
                @if($concert->lineup && count($concert->lineup) > 0)
                <div>
                    <h2 class="text-3xl font-bold font-heading text-slate-900 dark:text-white mb-6">Line Up</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        @foreach($concert->lineup as $artist)
                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-center hover:shadow-lg transition-all">
                            <div class="w-16 h-16 mx-auto rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-xl mb-3">
                                {{ strtoupper(substr($artist, 0, 1)) }}
                            </div>
                            <p class="font-semibold text-slate-900 dark:text-white text-sm">{{ $artist }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Sidebar -->
            <div class="space-y-6" data-aos="fade-left">
                <div class="sticky top-24 bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-lg">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Informasi Tiket</h3>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex items-center justify-between pb-4 border-b border-slate-200 dark:border-slate-700">
                            <span class="text-slate-600 dark:text-slate-400">Harga</span>
                            <span class="text-2xl font-bold text-slate-900 dark:text-white">Rp {{ number_format($concert->ticket_price, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between pb-4 border-b border-slate-200 dark:border-slate-700">
                            <span class="text-slate-600 dark:text-slate-400">Tanggal</span>
                            <span class="font-semibold text-slate-900 dark:text-white text-right">{{ $concert->start_date->format('d M Y') }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between pb-4 border-b border-slate-200 dark:border-slate-700">
                            <span class="text-slate-600 dark:text-slate-400">Waktu</span>
                            <span class="font-semibold text-slate-900 dark:text-white">{{ $concert->start_date->format('H:i') }} WIB</span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-slate-600 dark:text-slate-400">Tersedia</span>
                            <span class="font-semibold {{ $concert->is_sold_out ? 'text-red-600' : 'text-emerald-600' }}">
                                {{ $concert->is_sold_out ? 'SOLD OUT' : number_format($concert->available_tickets) . ' tiket' }}
                            </span>
                        </div>
                    </div>
                    
                    @if(!$concert->is_sold_out)
                    <a href="{{ route('order', $concert->slug) }}" class="btn-ripple w-full inline-flex items-center justify-center gap-2 px-6 py-4 rounded-2xl gradient-primary text-white font-bold text-lg shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transition-all">
                        Pesan Tiket Sekarang
                    </a>
                    @else
                    <button disabled class="w-full px-6 py-4 rounded-2xl bg-slate-300 dark:bg-slate-700 text-slate-500 font-bold text-lg cursor-not-allowed">
                        Tiket Habis
                    </button>
                    @endif
                    
                    <div class="mt-4 p-4 rounded-xl bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800">
                        <p class="text-xs text-blue-700 dark:text-blue-300">
                            💡 Tiket dapat di-download dalam format PDF setelah pemesanan berhasil.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 gradient-hero relative overflow-hidden">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10" data-aos="zoom-in">
        <h2 class="text-4xl sm:text-5xl font-bold font-heading text-white mb-6">
            Jangan Sampai Kehabisan!
        </h2>
        <p class="text-xl text-blue-100 mb-10">
            Pesan tiketmu sekarang dan rasakan pengalaman konser yang tak terlupakan.
        </p>
        <a href="{{ route('order', $concert->slug) }}" class="btn-ripple inline-flex items-center justify-center gap-3 px-10 py-5 rounded-2xl bg-white text-slate-900 font-bold text-lg shadow-2xl hover:scale-105 transition-all">
            Pesan Tiket Sekarang
        </a>
    </div>
</section>

<!-- Footer -->
<footer class="bg-slate-900 text-white py-12 border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="flex items-center justify-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl gradient-primary flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                </svg>
            </div>
            <span class="text-xl font-bold font-heading">AGX Concert</span>
        </div>
        <p class="text-slate-400 text-sm">© {{ date('Y') }} AGX Concert. All rights reserved.</p>
    </div>
</footer>
@endsection