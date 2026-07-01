@extends('layouts.admin')

@section('title', 'Kelola Konser')
@section('breadcrumb', 'Kelola Konser')

@section('admin-content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4" data-aos="fade-up">
            <div>
                <h1 class="text-2xl font-bold font-heading text-slate-900 dark:text-white">Kelola Konser</h1>
                <p class="mt-1 text-slate-500">Manajemen semua konser dan event.</p>
            </div>
            <a href="{{ route('admin.concerts.create') }}"
                class="btn-ripple inline-flex items-center gap-2 px-5 py-2.5 rounded-xl gradient-primary text-white font-medium text-sm shadow-lg shadow-blue-500/25 hover:shadow-xl transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Konser
            </a>
        </div>

        <!-- Filters -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm"
            data-aos="fade-up" data-aos-delay="100">
            <form method="GET" action="{{ route('admin.concerts.index') }}" class="space-y-4">
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
                                placeholder="Nama, venue, lokasi..."
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Status</label>
                        <select name="status"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Status</option>
                            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published
                            </option>
                            <option value="ongoing" {{ request('status') === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed
                            </option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Dari
                            Tanggal</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl gradient-primary text-white font-medium text-sm hover:shadow-lg transition-all">Filter</button>
                    <a href="{{ route('admin.concerts.index') }}"
                        class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-400 font-medium text-sm hover:bg-slate-50 dark:hover:bg-slate-700">Reset</a>
                </div>
            </form>
        </div>

        <!-- Concerts Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6" data-aos="fade-up" data-aos-delay="200">
            @forelse($concerts as $concert)
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden hover:shadow-lg transition-all">
                    <!-- Image -->
                    <div class="relative h-48 bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 overflow-hidden">
                        @if($concert->image)
                            <img src="{{ asset('storage/' . $concert->image) }}" alt="{{ $concert->name }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center">
                                <svg class="w-16 h-16 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                        d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                </svg>
                            </div>
                        @endif

                        <!-- Status Badge -->
                        <div class="absolute top-3 right-3">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($concert->status === 'published') bg-blue-500 text-white
                                @elseif($concert->status === 'ongoing') bg-emerald-500 text-white
                                @elseif($concert->status === 'completed') bg-slate-500 text-white
                                @elseif($concert->status === 'cancelled') bg-red-500 text-white
                                @else bg-amber-500 text-white
                                @endif">
                                {{ $concert->status_name }}
                            </span>
                        </div>

                        <!-- Date Badge -->
                        <div class="absolute top-3 left-3">
                            <span class="px-3 py-1 rounded-full bg-white/90 backdrop-blur text-slate-900 text-xs font-bold">
                                {{ $concert->start_date->format('d M Y') }}
                            </span>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-5 space-y-4">
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1 line-clamp-1">{{ $concert->name }}
                            </h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">
                                {{ Str::limit($concert->description, 60) }}</p>
                        </div>

                        <div class="space-y-2">
                            <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                                <span class="truncate">{{ $concert->venue }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500">Kapasitas</span>
                                <span
                                    class="font-semibold text-slate-900 dark:text-white">{{ number_format($concert->capacity) }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500">Tiket Terjual</span>
                                <span class="font-semibold text-emerald-600">{{ number_format($concert->tickets_sold) }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500">Harga</span>
                                <span class="font-bold text-blue-600 dark:text-blue-400">Rp
                                    {{ number_format($concert->ticket_price, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div>
                            <div class="flex items-center justify-between text-xs mb-1">
                                <span class="text-slate-500">Terjual</span>
                                <span class="font-semibold text-slate-700 dark:text-slate-300">
                                    {{ $concert->capacity > 0 ? round(($concert->tickets_sold / $concert->capacity) * 100) : 0 }}%
                                </span>
                            </div>
                            <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-2">
                                <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-2 rounded-full transition-all"
                                    style="width: {{ $concert->capacity > 0 ? min(100, ($concert->tickets_sold / $concert->capacity) * 100) : 0 }}%">
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-2 pt-3 border-t border-slate-200 dark:border-slate-700">
                            <a href="{{ route('admin.concerts.show', $concert) }}"
                                class="flex-1 px-3 py-2 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 text-sm font-medium text-center hover:bg-blue-100 transition-all">
                                Detail
                            </a>
                            <a href="{{ route('admin.concerts.edit', $concert) }}"
                                class="flex-1 px-3 py-2 rounded-lg bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-400 text-sm font-medium text-center hover:bg-amber-100 transition-all">
                                Edit
                            </a>
                            <button onclick="deleteConcert({{ $concert->id }}, '{{ addslashes($concert->name) }}')"
                                class="px-3 py-2 rounded-lg bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 text-sm font-medium hover:bg-red-100 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="md:col-span-2 lg:col-span-3">
                    <div
                        class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-16 text-center">
                        <svg class="w-20 h-20 mx-auto text-slate-300 dark:text-slate-600 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                        </svg>
                        <p class="text-lg font-medium text-slate-500">Belum ada konser</p>
                        <p class="text-sm text-slate-400 mt-1">Klik "Tambah Konser" untuk membuat konser baru.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($concerts->hasPages())
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-4">
                {{ $concerts->links() }}
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            function deleteConcert(id, name) {
                Swal.fire({
                    title: 'Hapus Konser?',
                    html: `Konser <strong>${name}</strong> akan dihapus.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/admin/concerts/${id}`;
                        form.innerHTML = `@csrf @method('DELETE')`;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            }
        </script>
    @endpush
@endsection