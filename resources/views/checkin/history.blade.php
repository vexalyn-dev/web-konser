@extends('layouts.admin')

@section('title', 'Riwayat Check In')
@section('breadcrumb', 'Riwayat Check In')

@section('admin-content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-3" data-aos="fade-up">
            <a href="{{ route('checkin.index') }}"
                class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold font-heading text-slate-900 dark:text-white">Riwayat Check In</h1>
                <p class="mt-1 text-slate-500">Daftar semua tiket yang sudah di-check in.</p>
            </div>
        </div>

        <!-- Search -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm"
            data-aos="fade-up" data-aos-delay="100">
            <form method="GET" action="{{ route('checkin.history') }}">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama, email, atau kode tiket..."
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500">
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden"
            data-aos="fade-up" data-aos-delay="200">
            <div class="table-container">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-700/50">
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase">
                                Kode Tiket</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase">
                                Nama</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase hidden md:table-cell">
                                Email</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase hidden lg:table-cell">
                                Kota</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase">
                                Waktu Check In</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @forelse($tickets as $ticket)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                                <td class="px-6 py-4">
                                    <span
                                        class="text-sm font-mono font-medium text-slate-900 dark:text-white">{{ $ticket->ticket_code }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold text-xs">
                                            {{ strtoupper(substr($ticket->full_name, 0, 1)) }}
                                        </div>
                                        <span
                                            class="text-sm font-medium text-slate-900 dark:text-white">{{ $ticket->full_name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 hidden md:table-cell">
                                    <span class="text-sm text-slate-600 dark:text-slate-400">{{ $ticket->email }}</span>
                                </td>
                                <td class="px-6 py-4 hidden lg:table-cell">
                                    <span class="text-sm text-slate-600 dark:text-slate-400">{{ $ticket->city }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                        <span
                                            class="text-sm text-slate-700 dark:text-slate-300">{{ $ticket->checked_in_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <p class="text-xs text-slate-500 mt-0.5">{{ $ticket->checked_in_at->diffForHumans() }}</p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <svg class="w-16 h-16 mx-auto text-slate-300 dark:text-slate-600 mb-4" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-lg font-medium text-slate-500">Belum ada riwayat</p>
                                    <p class="text-sm text-slate-400 mt-1">Tidak ada data check in yang cocok.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($tickets->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700">
                    {{ $tickets->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection