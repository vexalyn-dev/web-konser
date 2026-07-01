@extends('layouts.admin')

@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('admin-content')
    <div class="space-y-8">
        <!-- Welcome Section -->
        <div data-aos="fade-up">
            <h1 class="text-2xl lg:text-3xl font-bold font-heading text-slate-900 dark:text-white">
                Selamat Datang, {{ auth()->user()->name }} 👋
            </h1>
            <p class="mt-2 text-slate-500 dark:text-slate-400">Berikut ringkasan aktivitas konser hari ini.</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" data-aos="fade-up" data-aos-delay="100">
            <!-- Total Tickets -->
            <div
                class="card-hover bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Total Tiket</p>
                        <p class="mt-2 text-3xl font-bold text-slate-900 dark:text-white counter"
                            data-target="{{ $stats['total'] }}">0</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-emerald-600 font-medium">+12%</span>
                    <span class="ml-2 text-slate-500">dari bulan lalu</span>
                </div>
            </div>

            <!-- Checked In -->
            <div
                class="card-hover bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Sudah Check In</p>
                        <p class="mt-2 text-3xl font-bold text-slate-900 dark:text-white counter"
                            data-target="{{ $stats['checked_in'] }}">0</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-emerald-600 font-medium">{{ $checkInPercentage }}%</span>
                    <span class="ml-2 text-slate-500">dari total tiket</span>
                </div>
            </div>

            <!-- Not Checked In -->
            <div
                class="card-hover bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Belum Check In</p>
                        <p class="mt-2 text-3xl font-bold text-slate-900 dark:text-white counter"
                            data-target="{{ $stats['unused'] }}">0</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-amber-600 font-medium">Menunggu</span>
                    <span class="ml-2 text-slate-500">untuk check in</span>
                </div>
            </div>

            <!-- Today -->
            <div
                class="card-hover bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Check In Hari Ini</p>
                        <p class="mt-2 text-3xl font-bold text-slate-900 dark:text-white counter"
                            data-target="{{ $stats['today'] }}">0</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-purple-600 font-medium">Hari ini</span>
                    <span class="ml-2 text-slate-500">{{ now()->format('d M Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" data-aos="fade-up" data-aos-delay="200">
            <!-- Main Chart -->
            <div
                class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Aktivitas 7 Hari Terakhir</h3>
                        <p class="text-sm text-slate-500">Registrasi & Check In</p>
                    </div>
                </div>
                <canvas id="activityChart" height="120"></canvas>
            </div>

            <!-- City Distribution -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Distribusi Kota</h3>
                    <p class="text-sm text-slate-500">Top 5 kota</p>
                </div>
                <canvas id="cityChart" height="200"></canvas>
            </div>
        </div>

        <!-- Recent Data -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" data-aos="fade-up" data-aos-delay="300">
            <!-- Recent Tickets -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Tiket Terbaru</h3>
                    <a href="{{ route('admin.tickets.index') }}"
                        class="text-sm text-blue-600 hover:text-blue-700 font-medium">Lihat Semua →</a>
                </div>
                <div class="space-y-4">
                    @forelse($recentTickets as $ticket)
                        <div
                            class="flex items-center gap-4 p-3 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                            <div
                                class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold text-sm">
                                {{ strtoupper(substr($ticket->full_name, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-900 dark:text-white truncate">{{ $ticket->full_name }}
                                </p>
                                <p class="text-xs text-slate-500">{{ $ticket->ticket_code }}</p>
                            </div>
                            <span
                                class="px-2.5 py-1 rounded-full text-xs font-medium {{ $ticket->status === 'checked_in' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' }}">
                                {{ $ticket->status === 'checked_in' ? 'Checked In' : 'Belum' }}
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-slate-500">Belum ada tiket</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Aktivitas Terbaru</h3>
                </div>
                <div class="space-y-4">
                    @forelse($recentActivities as $activity)
                        <div class="flex items-start gap-3">
                            <div
                                class="w-8 h-8 rounded-full bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-slate-900 dark:text-white">{{ $activity->description }}</p>
                                <p class="text-xs text-slate-500 mt-0.5">
                                    {{ $activity->user?->name ?? 'System' }} • {{ $activity->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-slate-500">Belum ada aktivitas</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Animated Counters
            document.querySelectorAll('.counter').forEach(counter => {
                const target = parseInt(counter.dataset.target);
                animateCounter(counter, target);
            });

            // Activity Chart
            const activityCtx = document.getElementById('activityChart').getContext('2d');
            new Chart(activityCtx, {
                type: 'line',
                data: {
                    labels: @json($chartData['labels']),
                    datasets: [
                        {
                            label: 'Registrasi',
                            data: @json($chartData['registrations']),
                            borderColor: '#2563eb',
                            backgroundColor: 'rgba(37, 99, 235, 0.1)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 2,
                            pointRadius: 4,
                            pointBackgroundColor: '#2563eb',
                        },
                        {
                            label: 'Check In',
                            data: @json($chartData['checkins']),
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 2,
                            pointRadius: 4,
                            pointBackgroundColor: '#10b981',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0,0,0,0.05)',
                            },
                            ticks: {
                                stepSize: 1,
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                            }
                        }
                    }
                }
            });

            // City Chart
            const cityCtx = document.getElementById('cityChart').getContext('2d');
            new Chart(cityCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($cityData->pluck('city')),
                    datasets: [{
                        data: @json($cityData->pluck('count')),
                        backgroundColor: [
                            '#2563eb',
                            '#7c3aed',
                            '#059669',
                            '#d97706',
                            '#dc2626',
                        ],
                        borderWidth: 0,
                        spacing: 2,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 15,
                                font: { size: 11 }
                            }
                        }
                    }
                }
            });
        </script>
    @endpush
@endsection