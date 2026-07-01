@extends('layouts.admin')

@section('title', 'Laporan')
@section('breadcrumb', 'Laporan')

@section('admin-content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4" data-aos="fade-up">
            <div>
                <h1 class="text-2xl font-bold font-heading text-slate-900 dark:text-white">Laporan</h1>
                <p class="mt-1 text-slate-500">Laporan data tiket konser dengan filter lengkap.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.reports.export.excel', request()->query()) }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 font-medium text-sm hover:bg-emerald-100 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Excel
                </a>
                <a href="{{ route('admin.reports.export.pdf', request()->query()) }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 font-medium text-sm hover:bg-red-100 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    PDF
                </a>
                <a href="{{ route('admin.reports.print', request()->query()) }}" target="_blank"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 font-medium text-sm hover:bg-blue-100 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print
                </a>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" data-aos="fade-up" data-aos-delay="50">
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-200 dark:border-slate-700">
                <p class="text-sm text-slate-500">Total Data</p>
                <p class="mt-1 text-2xl font-bold text-slate-900 dark:text-white">{{ number_format($summary['total']) }}</p>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-200 dark:border-slate-700">
                <p class="text-sm text-slate-500">Sudah Check In</p>
                <p class="mt-1 text-2xl font-bold text-emerald-600">{{ number_format($summary['checked_in']) }}</p>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-200 dark:border-slate-700">
                <p class="text-sm text-slate-500">Belum Check In</p>
                <p class="mt-1 text-2xl font-bold text-amber-600">{{ number_format($summary['unused']) }}</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm"
            data-aos="fade-up" data-aos-delay="100">
            <form method="GET" action="{{ route('admin.reports.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Cari</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Nama, email, kode tiket..."
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Status</label>
                        <select name="status"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Status</option>
                            <option value="unused" {{ request('status') === 'unused' ? 'selected' : '' }}>Belum Check In
                            </option>
                            <option value="checked_in" {{ request('status') === 'checked_in' ? 'selected' : '' }}>Sudah Check
                                In</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Kota</label>
                        <select name="city"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Kota</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}" {{ request('city') === $city ? 'selected' : '' }}>{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Dari
                            Tanggal</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Sampai
                            Tanggal</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl gradient-primary text-white font-medium text-sm hover:shadow-lg transition-all">Filter</button>
                    <a href="{{ route('admin.reports.index') }}"
                        class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-400 font-medium text-sm hover:bg-slate-50 dark:hover:bg-slate-700">Reset</a>
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
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase hidden lg:table-cell">
                                Email</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase hidden md:table-cell">
                                Kota</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase">
                                Status</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase hidden xl:table-cell">
                                Check In</th>
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
                                <td class="px-6 py-4 hidden lg:table-cell">
                                    <span class="text-sm text-slate-600 dark:text-slate-400">{{ $ticket->email }}</span>
                                </td>
                                <td class="px-6 py-4 hidden md:table-cell">
                                    <span class="text-sm text-slate-600 dark:text-slate-400">{{ $ticket->city }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $ticket->status === 'checked_in' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' }}">
                                        {{ $ticket->status_name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 hidden xl:table-cell">
                                    <span class="text-sm text-slate-500">
                                        {{ $ticket->checked_in_at ? $ticket->checked_in_at->format('d/m/Y H:i') : '-' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <p class="text-lg font-medium text-slate-500">Tidak ada data</p>
                                    <p class="text-sm text-slate-400 mt-1">Coba ubah filter pencarian Anda.</p>
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