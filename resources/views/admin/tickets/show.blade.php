@extends('layouts.admin')

@section('title', 'Detail Tiket')
@section('breadcrumb', 'Detail Tiket')

@section('admin-content')
    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4" data-aos="fade-up">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.tickets.index') }}"
                    class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold font-heading text-slate-900 dark:text-white">Detail Tiket</h1>
                    <p class="mt-1 text-sm text-slate-500">Kode: <span
                            class="font-mono font-semibold text-blue-600">{{ $ticket->ticket_code }}</span></p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.tickets.edit', $ticket) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-400 font-medium text-sm hover:bg-amber-100 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                <button onclick="deleteTicket('{{ $ticket->id }}')"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 font-medium text-sm hover:bg-red-100 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Hapus
                </button>
            </div>
        </div>

        <!-- Ticket Card -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Info -->
            <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden"
                data-aos="fade-up" data-aos-delay="100">
                <!-- Status Header -->
                <div class="gradient-primary p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-blue-200">Status Tiket</p>
                            <h2 class="text-2xl font-bold font-heading mt-1">
                                {{ $ticket->status === 'checked_in' ? 'Sudah Check In' : 'Belum Check In' }}
                            </h2>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                            @if($ticket->status === 'checked_in')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @else
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Info Sections -->
                <div class="p-6 lg:p-8 space-y-6">
                    <!-- Personal Info -->
                    <div>
                        <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-4">Informasi Pribadi
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-700/30">
                                <p class="text-xs text-slate-500 mb-1">Nama Lengkap</p>
                                <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $ticket->full_name }}</p>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-700/30">
                                <p class="text-xs text-slate-500 mb-1">Email</p>
                                <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $ticket->email }}</p>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-700/30">
                                <p class="text-xs text-slate-500 mb-1">Nomor HP</p>
                                <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $ticket->phone }}</p>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-700/30">
                                <p class="text-xs text-slate-500 mb-1">Jenis Kelamin</p>
                                <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $ticket->gender_name }}
                                </p>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-700/30">
                                <p class="text-xs text-slate-500 mb-1">Tanggal Lahir</p>
                                <p class="text-sm font-semibold text-slate-900 dark:text-white">
                                    {{ $ticket->birth_date->format('d F Y') }}</p>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-700/30">
                                <p class="text-xs text-slate-500 mb-1">Nomor Identitas</p>
                                <p class="text-sm font-semibold text-slate-900 dark:text-white font-mono">
                                    {{ $ticket->identity_number }}</p>
                            </div>
                        </div>
                    </div>

                    <hr class="border-slate-200 dark:border-slate-700">

                    <!-- Address Info -->
                    <div>
                        <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-4">Alamat</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2 p-4 rounded-xl bg-slate-50 dark:bg-slate-700/30">
                                <p class="text-xs text-slate-500 mb-1">Alamat Lengkap</p>
                                <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $ticket->address }}</p>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-700/30">
                                <p class="text-xs text-slate-500 mb-1">Kota</p>
                                <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $ticket->city }}</p>
                            </div>
                        </div>
                    </div>

                    <hr class="border-slate-200 dark:border-slate-700">

                    <!-- Emergency Contact -->
                    <div>
                        <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-4">Kontak Darurat</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-700/30">
                                <p class="text-xs text-slate-500 mb-1">Nama Kontak</p>
                                <p class="text-sm font-semibold text-slate-900 dark:text-white">
                                    {{ $ticket->emergency_contact }}</p>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-700/30">
                                <p class="text-xs text-slate-500 mb-1">Nomor Kontak</p>
                                <p class="text-sm font-semibold text-slate-900 dark:text-white">
                                    {{ $ticket->emergency_phone }}</p>
                            </div>
                        </div>
                    </div>

                    <hr class="border-slate-200 dark:border-slate-700">

                    <!-- Timestamps -->
                    <div>
                        <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-4">Informasi Sistem</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-700/30">
                                <p class="text-xs text-slate-500 mb-1">Tanggal Pemesanan</p>
                                <p class="text-sm font-semibold text-slate-900 dark:text-white">
                                    {{ $ticket->created_at->format('d F Y, H:i') }}</p>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-700/30">
                                <p class="text-xs text-slate-500 mb-1">Terakhir Update</p>
                                <p class="text-sm font-semibold text-slate-900 dark:text-white">
                                    {{ $ticket->updated_at->format('d F Y, H:i') }}</p>
                            </div>
                            @if($ticket->checked_in_at)
                                <div
                                    class="sm:col-span-2 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800">
                                    <p class="text-xs text-emerald-600 dark:text-emerald-400 mb-1">Waktu Check In</p>
                                    <p class="text-sm font-semibold text-emerald-900 dark:text-emerald-300">
                                        {{ $ticket->checked_in_at->format('d F Y, H:i:s') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- QR Code Sidebar -->
            <div class="space-y-6">
                <!-- QR Code Card -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm p-6 text-center"
                    data-aos="fade-up" data-aos-delay="200">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">QR Code</h3>
                    <div
                        class="inline-block p-4 bg-white rounded-xl border-2 border-dashed border-slate-300 dark:border-slate-600">
                        @php
                            use SimpleSoftwareIO\QrCode\Facades\QrCode;
                            
                            // Generate QR Code as SVG (no Imagick needed)
                            $qrCodeSvg = QrCode::format('svg')
                                ->size(250)
                                ->margin(1)
                                ->generate($ticket->ticket_code);
                            
                            $qrCodeBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrCodeSvg);
                        @endphp
                        <img src="{{ $qrCodeBase64 }}" alt="QR Code" class="w-48 h-48">
                    </div>
                    <p class="mt-4 font-mono text-sm font-bold text-slate-900 dark:text-white">{{ $ticket->ticket_code }}
                    </p>
                    <p class="mt-1 text-xs text-slate-500">Scan untuk check-in</p>
                </div>

                <!-- Status Card -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm p-6"
                    data-aos="fade-up" data-aos-delay="300">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Status</h3>
                    <div
                        class="flex items-center gap-3 p-4 rounded-xl {{ $ticket->status === 'checked_in' ? 'bg-emerald-50 dark:bg-emerald-900/20' : 'bg-amber-50 dark:bg-amber-900/20' }}">
                        <div
                            class="w-10 h-10 rounded-full {{ $ticket->status === 'checked_in' ? 'bg-emerald-100 dark:bg-emerald-900/40' : 'bg-amber-100 dark:bg-amber-900/40' }} flex items-center justify-center">
                            @if($ticket->status === 'checked_in')
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @endif
                        </div>
                        <div>
                            <p
                                class="text-sm font-semibold {{ $ticket->status === 'checked_in' ? 'text-emerald-900 dark:text-emerald-300' : 'text-amber-900 dark:text-amber-300' }}">
                                {{ $ticket->status_name }}
                            </p>
                            <p class="text-xs text-slate-500">
                                @if($ticket->checked_in_at)
                                    Check in: {{ $ticket->checked_in_at->diffForHumans() }}
                                @else
                                    Menunggu check in
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Actions Card -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm p-6"
                    data-aos="fade-up" data-aos-delay="400">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Aksi</h3>
                    <div class="space-y-2">
                        <a href="{{ route('admin.tickets.edit', $ticket) }}"
                            class="flex items-center gap-3 w-full px-4 py-2.5 rounded-xl bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-400 font-medium text-sm hover:bg-amber-100 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Tiket
                        </a>
                        <a href="{{ route('ticket.download', $ticket->ticket_code) }}"
                            class="flex items-center gap-3 w-full px-4 py-2.5 rounded-xl bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 font-medium text-sm hover:bg-blue-100 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Download PDF
                        </a>
                        <button onclick="deleteTicket('{{ $ticket->id }}')"
                            class="flex items-center gap-3 w-full px-4 py-2.5 rounded-xl bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 font-medium text-sm hover:bg-red-100 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus Tiket
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
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