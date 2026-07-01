@extends('layouts.admin')

@section('title', 'Data Pemesan')
@section('breadcrumb', 'Data Pemesan')

@section('admin-content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4" data-aos="fade-up">
            <div>
                <h1 class="text-2xl font-bold font-heading text-slate-900 dark:text-white">Data Pemesan Tiket</h1>
                <p class="mt-1 text-slate-500">Kelola semua data pemesanan tiket konser.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.tickets.create') }}"
                    class="btn-ripple inline-flex items-center gap-2 px-5 py-2.5 rounded-xl gradient-primary text-white font-medium text-sm shadow-lg shadow-blue-500/25 hover:shadow-xl hover:shadow-blue-500/30 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Tiket
                </a>
            </div>
        </div>

        <!-- Filters Card -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm"
            data-aos="fade-up" data-aos-delay="100">
            <form method="GET" action="{{ route('admin.tickets.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Search -->
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
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Status</label>
                        <select name="status"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Status</option>
                            <option value="unused" {{ request('status') === 'unused' ? 'selected' : '' }}>Belum Check In
                            </option>
                            <option value="checked_in" {{ request('status') === 'checked_in' ? 'selected' : '' }}>Sudah Check
                                In</option>
                        </select>
                    </div>

                    <!-- City Filter -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Kota</label>
                        <select name="city"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Kota</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}" {{ request('city') === $city ? 'selected' : '' }}>{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl gradient-primary text-white font-medium text-sm hover:shadow-lg transition-all">
                        Filter
                    </button>
                    <a href="{{ route('admin.tickets.index') }}"
                        class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-400 font-medium text-sm hover:bg-slate-50 dark:hover:bg-slate-700 transition-all">
                        Reset
                    </a>

                    <div class="ml-auto flex items-center gap-2">
                        <a href="{{ route('admin.tickets.export.excel', request()->query()) }}"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 font-medium text-sm hover:bg-emerald-100 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Excel
                        </a>
                        <a href="{{ route('admin.tickets.export.pdf', request()->query()) }}"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 font-medium text-sm hover:bg-red-100 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            PDF
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden"
            data-aos="fade-up" data-aos-delay="200">
            <!-- Bulk Actions -->
            <div id="bulkActions"
                class="hidden px-6 py-3 bg-blue-50 dark:bg-blue-900/20 border-b border-blue-100 dark:border-blue-800">
                <div class="flex items-center gap-3">
                    <span class="text-sm text-blue-700 dark:text-blue-300 font-medium"><span id="selectedCount">0</span>
                        item dipilih</span>
                    <button onclick="bulkDelete()"
                        class="px-4 py-1.5 rounded-lg bg-red-500 text-white text-sm font-medium hover:bg-red-600 transition-colors">
                        Hapus Terpilih
                    </button>
                </div>
            </div>

            <div class="table-container">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-700/50">
                            <th class="px-6 py-4 text-left">
                                <input type="checkbox" id="selectAll"
                                    class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                Kode Tiket</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                Nama</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider hidden lg:table-cell">
                                Email</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider hidden md:table-cell">
                                Kota</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider hidden xl:table-cell">
                                Tanggal</th>
                            <th
                                class="px-6 py-4 text-right text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @forelse($tickets as $ticket)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                                <td class="px-6 py-4">
                                    <input type="checkbox"
                                        class="ticket-checkbox w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                                        value="{{ $ticket->id }}">
                                </td>
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
                                        {{ $ticket->status === 'checked_in' ? 'Checked In' : 'Belum' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 hidden xl:table-cell">
                                    <span class="text-sm text-slate-500">{{ $ticket->created_at->format('d M Y') }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('admin.tickets.show', $ticket) }}"
                                            class="p-2 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors"
                                            title="Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.tickets.edit', $ticket) }}"
                                            class="p-2 rounded-lg text-slate-400 hover:text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-900/20 transition-colors"
                                            title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <button onclick="deleteTicket({{ $ticket->id }})"
                                            class="p-2 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors"
                                            title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-16 h-16 text-slate-300 dark:text-slate-600 mb-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        <p class="text-lg font-medium text-slate-500">Tidak ada data</p>
                                        <p class="text-sm text-slate-400 mt-1">Belum ada data pemesanan tiket.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($tickets->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700">
                    {{ $tickets->links() }}
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            // Select All Checkbox
            document.getElementById('selectAll').addEventListener('change', function () {
                const checkboxes = document.querySelectorAll('.ticket-checkbox');
                checkboxes.forEach(cb => cb.checked = this.checked);
                updateBulkActions();
            });

            // Individual Checkbox
            document.querySelectorAll('.ticket-checkbox').forEach(cb => {
                cb.addEventListener('change', updateBulkActions);
            });

            function updateBulkActions() {
                const checked = document.querySelectorAll('.ticket-checkbox:checked');
                const bulkActions = document.getElementById('bulkActions');
                const count = document.getElementById('selectedCount');

                if (checked.length > 0) {
                    bulkActions.classList.remove('hidden');
                    count.textContent = checked.length;
                } else {
                    bulkActions.classList.add('hidden');
                }
            }

            function bulkDelete() {
                const ids = Array.from(document.querySelectorAll('.ticket-checkbox:checked')).map(cb => cb.value);

                Swal.fire({
                    title: 'Hapus Terpilih?',
                    text: `${ids.length} tiket akan dihapus.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('{{ route("admin.tickets.bulk-delete") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                            },
                            body: JSON.stringify({ ids }),
                        })
                            .then(res => res.json())
                            .then(data => {
                                Swal.fire('Dihapus!', data.message, 'success').then(() => location.reload());
                            });
                    }
                });
            }

            function deleteTicket(id) {
                Swal.fire({
                    title: 'Hapus Tiket?',
                    text: 'Tiket yang dihapus dapat dipulihkan.',
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
                        form.action = `/admin/tickets/${id}`;
                        form.innerHTML = `@csrf @method('DELETE')`;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            }
        </script>
    @endpush
@endsection