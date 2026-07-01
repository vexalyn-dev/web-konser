@extends('layouts.admin')

@section('title', 'Detail Konser')
@section('breadcrumb', 'Detail Konser')

@section('admin-content')
    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4" data-aos="fade-up">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.concerts.index') }}"
                    class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold font-heading text-slate-900 dark:text-white">{{ $concert->name }}</h1>
                    <p class="mt-1 text-sm text-slate-500">Slug: <span
                            class="font-mono text-blue-600">{{ $concert->slug }}</span></p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('concert.show', $concert->slug) }}" target="_blank"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 font-medium text-sm hover:bg-blue-100 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    Lihat Publik
                </a>
                <a href="{{ route('admin.concerts.edit', $concert) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-400 font-medium text-sm hover:bg-amber-100 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4" data-aos="fade-up" data-aos-delay="100">
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-200 dark:border-slate-700">
                <p class="text-sm text-slate-500">Total Tiket</p>
                <p class="mt-1 text-2xl font-bold text-slate-900 dark:text-white">
                    {{ number_format($concert->tickets_count) }}</p>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-200 dark:border-slate-700">
                <p class="text-sm text-slate-500">Checked In</p>
                <p class="mt-1 text-2xl font-bold text-emerald-600">{{ number_format($ticketsByStatus['checked_in'] ?? 0) }}
                </p>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-200 dark:border-slate-700">
                <p class="text-sm text-slate-500">Belum Check In</p>
                <p class="mt-1 text-2xl font-bold text-amber-600">{{ number_format($ticketsByStatus['unused'] ?? 0) }}</p>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-200 dark:border-slate-700">
                <p class="text-sm text-slate-500">Pendapatan</p>
                <p class="mt-1 text-2xl font-bold text-blue-600">Rp
                    {{ number_format($concert->tickets_sold * $concert->ticket_price, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid lg:grid-cols-3 gap-6">
            <!-- Left: Details -->
            <div class="lg:col-span-2 space-y-6" data-aos="fade-up" data-aos-delay="200">
                <!-- Image -->
                @if($concert->image)
                    <div
                        class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 overflow-hidden">
                        <img src="{{ asset('storage/' . $concert->image) }}" alt="{{ $concert->name }}"
                            class="w-full h-64 object-cover">
                    </div>
                @endif

                <!-- Description -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-3">Deskripsi</h3>
                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed whitespace-pre-line">
                        {{ $concert->description }}</p>
                </div>

                <!-- Lineup -->
                @if($concert->lineup && count($concert->lineup) > 0)
                    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700">
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Line Up</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach($concert->lineup as $artist)
                                <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-700/50 flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                        {{ strtoupper(substr($artist, 0, 1)) }}
                                    </div>
                                    <span class="text-sm font-medium text-slate-900 dark:text-white truncate">{{ $artist }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right: Info Sidebar -->
            <div class="space-y-6" data-aos="fade-left" data-aos-delay="300">
                <!-- Status -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Status</h3>
                    <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold
                        @if($concert->status === 'published') bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400
                        @elseif($concert->status === 'ongoing') bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400
                        @elseif($concert->status === 'completed') bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300
                        @elseif($concert->status === 'cancelled') bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400
                        @else bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400
                        @endif">
                        {{ $concert->status_name }}
                    </span>
                </div>

                <!-- Info -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Informasi</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs text-slate-500 mb-1">Tanggal</p>
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">
                                {{ $concert->start_date->format('d F Y, H:i') }} WIB</p>
                            @if($concert->end_date)
                                <p class="text-xs text-slate-500 mt-1">s/d {{ $concert->end_date->format('d F Y, H:i') }} WIB
                                </p>
                            @endif
                        </div>

                        <div>
                            <p class="text-xs text-slate-500 mb-1">Venue</p>
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $concert->venue }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-500 mb-1">Lokasi</p>
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $concert->location }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-500 mb-1">Kapasitas</p>
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">
                                {{ number_format($concert->capacity) }} orang</p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-500 mb-1">Harga Tiket</p>
                            <p class="text-xl font-bold text-blue-600 dark:text-blue-400">Rp
                                {{ number_format($concert->ticket_price, 0, ',', '.') }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-500 mb-1">Penjualan Tiket</p>
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">
                                @if($concert->ticket_sales_start)
                                    {{ $concert->ticket_sales_start->format('d M Y') }}
                                @else
                                    -
                                @endif
                                s/d
                                @if($concert->ticket_sales_end)
                                    {{ $concert->ticket_sales_end->format('d M Y') }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Progress -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Progress Penjualan</h3>
                    <div class="mb-3">
                        <div class="flex items-center justify-between text-sm mb-2">
                            <span class="text-slate-500">Terjual</span>
                            <span
                                class="font-bold text-slate-900 dark:text-white">{{ number_format($concert->tickets_sold) }}
                                / {{ number_format($concert->capacity) }}</span>
                        </div>
                        <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-3">
                            <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-3 rounded-full transition-all"
                                style="width: {{ $concert->capacity > 0 ? min(100, ($concert->tickets_sold / $concert->capacity) * 100) : 0 }}%">
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 mt-2 text-right">
                            {{ $concert->capacity > 0 ? round(($concert->tickets_sold / $concert->capacity) * 100) : 0 }}%
                            terjual
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection