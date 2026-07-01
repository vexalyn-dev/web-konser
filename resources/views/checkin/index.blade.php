@extends('layouts.admin')

@section('title', 'Check In')
@section('breadcrumb', 'Check In')

@section('admin-content')
    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Header -->
        <div class="text-center" data-aos="fade-up">
            <div
                class="w-16 h-16 mx-auto rounded-2xl gradient-primary flex items-center justify-center mb-4 shadow-lg shadow-blue-500/30">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold font-heading text-slate-900 dark:text-white">Check In Tiket</h1>
            <p class="mt-2 text-slate-500">Masukkan kode tiket atau scan QR Code.</p>
        </div>

        <!-- Today Stats -->
        <div class="grid grid-cols-2 gap-4" data-aos="fade-up" data-aos-delay="50">
            <div
                class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-200 dark:border-slate-700 text-center">
                <p class="text-sm text-slate-500">Check In Hari Ini</p>
                <p class="mt-1 text-3xl font-bold text-emerald-600">{{ $todayCount }}</p>
            </div>
            <div
                class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-200 dark:border-slate-700 text-center">
                <p class="text-sm text-slate-500">Tanggal</p>
                <p class="mt-1 text-lg font-bold text-slate-900 dark:text-white">{{ now()->format('d M Y') }}</p>
            </div>
        </div>

        <!-- Manual Input -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm"
            data-aos="fade-up" data-aos-delay="100">
            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Input Kode Tiket</h3>

            <form action="{{ route('checkin.process') }}" method="POST" id="checkinForm">
                @csrf
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1 relative">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                        </svg>
                        <input type="text" name="ticket_code" id="ticketCode" placeholder="AGX-2026-000001"
                            class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white text-lg font-mono focus:ring-2 focus:ring-blue-500"
                            autofocus required>
                    </div>
                    <button type="submit"
                        class="btn-ripple px-6 py-3 rounded-xl gradient-primary text-white font-medium shadow-lg shadow-blue-500/25 hover:shadow-xl transition-all whitespace-nowrap">
                        Check In
                    </button>
                </div>
            </form>
        </div>

        <!-- OR Divider -->
        <div class="flex items-center gap-4" data-aos="fade-up" data-aos-delay="150">
            <div class="flex-1 h-px bg-slate-200 dark:bg-slate-700"></div>
            <span class="text-sm text-slate-500 font-medium">ATAU</span>
            <div class="flex-1 h-px bg-slate-200 dark:bg-slate-700"></div>
        </div>

        <!-- QR Scanner -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm"
            data-aos="fade-up" data-aos-delay="200">
            <a href="{{ route('checkin.scan') }}"
                class="flex items-center justify-center gap-3 w-full py-6 rounded-xl border-2 border-dashed border-slate-300 dark:border-slate-600 text-slate-600 dark:text-slate-400 hover:border-blue-500 hover:text-blue-600 transition-all">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <div>
                    <p class="font-semibold">Scan QR Code dengan Kamera</p>
                    <p class="text-xs mt-1">Klik untuk membuka kamera</p>
                </div>
            </a>
        </div>

        <!-- Recent Check-ins -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm"
            data-aos="fade-up" data-aos-delay="300">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Check In Terakhir</h3>
                <a href="{{ route('checkin.history') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Lihat
                    Semua →</a>
            </div>

            <div class="space-y-3">
                @forelse($todayCheckIns as $ticket)
                    <div class="flex items-center gap-4 p-3 rounded-xl bg-slate-50 dark:bg-slate-700/50">
                        <div
                            class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-900 dark:text-white truncate">{{ $ticket->full_name }}</p>
                            <p class="text-xs text-slate-500 font-mono">{{ $ticket->ticket_code }}</p>
                        </div>
                        <span class="text-xs text-slate-500">{{ $ticket->checked_in_at->format('H:i') }}</span>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 mx-auto text-slate-300 dark:text-slate-600 mb-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-slate-500">Belum ada check in hari ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('checkinForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                
                fetch('{{ route("checkin.process") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: formData,
                })
                .then(res => res.json().then(data => ({ status: res.status, data })))
                .then(({ status, data }) => {
                    if (data.success) {
                        // ✅ SUKSES
                        Swal.fire({
                            icon: 'success',
                            title: 'Check In Berhasil!',
                            html: `
                                <div class="text-left mt-4 space-y-2 text-sm">
                                    <p><strong>Nama:</strong> ${data.ticket.full_name}</p>
                                    <p><strong>Email:</strong> ${data.ticket.email}</p>
                                    <p><strong>Kode:</strong> <code>${data.ticket.ticket_code}</code></p>
                                    <p><strong>Waktu:</strong> ${data.ticket.checked_in_at}</p>
                                </div>
                            `,
                            confirmButtonColor: '#10b981',
                        }).then(() => location.reload());
                        
                    } else if (data.type === 'already_used') {
                        // ❌ TIKET SUDAH DIPAKAI - FIX: Tampilkan info kapan dipakainya
                        let infoHtml = '<p class="text-sm text-slate-600 mt-2">Tiket ini sudah pernah di-check in sebelumnya.</p>';
                        
                        if (data.checked_in_at) {
                            infoHtml += `
                                <div class="mt-3 p-3 bg-red-50 rounded-lg text-left">
                                    <p class="text-xs text-red-700"><strong>Check-in pertama:</strong></p>
                                    <p class="text-sm text-red-900 font-mono">${data.checked_in_at}</p>
                                    <p class="text-xs text-red-600 mt-1">(${data.checked_in_human})</p>
                                </div>
                            `;
                        }
                        
                        if (data.ticket) {
                            infoHtml += `
                                <div class="mt-3 p-3 bg-slate-50 rounded-lg text-left text-sm">
                                    <p><strong>Nama:</strong> ${data.ticket.full_name}</p>
                                    <p><strong>Email:</strong> ${data.ticket.email}</p>
                                </div>
                            `;
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Tiket Sudah Digunakan!',
                            html: infoHtml,
                            confirmButtonColor: '#ef4444',
                        });
                        
                    } else if (data.type === 'deleted') {
                        // ❌ TIKET DIHAPUS
                        Swal.fire({
                            icon: 'warning',
                            title: 'Tiket Sudah Dihapus',
                            text: 'Tiket ini sudah dihapus oleh administrator.',
                            confirmButtonColor: '#f59e0b',
                        });
                        
                    } else {
                        // ❌ TIKET TIDAK DITEMUKAN
                        Swal.fire({
                            icon: 'error',
                            title: 'Tiket Tidak Ditemukan!',
                            text: data.message || 'Kode tiket yang dimasukkan tidak valid.',
                            footer: '<p class="text-xs text-slate-500">Periksa kembali kode tiket Anda. Format: AGX-2026-XXXXXX</p>',
                            confirmButtonColor: '#ef4444',
                        });
                    }
                    
                    // Reset input & fokus
                    document.getElementById('ticketCode').value = '';
                    document.getElementById('ticketCode').focus();
                })
                .catch((error) => {
                    console.error('Check-in error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan koneksi. Silakan coba lagi.',
                    });
                });
            });
        </script>
    @endpush
@endsection