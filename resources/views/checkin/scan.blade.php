@extends('layouts.admin')

@section('title', 'Scan QR Code')
@section('breadcrumb', 'Scan QR Code')

@section('admin-content')
    <div class="max-w-2xl mx-auto space-y-6">
        <!-- Header -->
        <div class="text-center" data-aos="fade-up">
            <h1 class="text-2xl font-bold font-heading text-slate-900 dark:text-white">Scan QR Code</h1>
            <p class="mt-2 text-slate-500">Arahkan kamera ke QR Code tiket.</p>
        </div>

        <!-- Scanner -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm"
            data-aos="fade-up" data-aos-delay="100">
            <div id="reader"
                class="rounded-xl overflow-hidden bg-slate-100 dark:bg-slate-900 min-h-[300px] flex items-center justify-center">
                <p class="text-slate-500">Memuat kamera...</p>
            </div>

            <div class="mt-4 flex items-center justify-center gap-3">
                <a href="{{ route('checkin.index') }}"
                    class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-400 font-medium text-sm hover:bg-slate-50 dark:hover:bg-slate-700 transition-all">
                    ← Kembali
                </a>
                <button onclick="toggleCamera()" id="cameraBtn"
                    class="px-5 py-2.5 rounded-xl gradient-primary text-white font-medium text-sm shadow-lg shadow-blue-500/25 hover:shadow-xl transition-all">
                    Pause
                </button>
            </div>

            <div class="mt-4 p-3 rounded-lg bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800">
                <p class="text-xs text-blue-700 dark:text-blue-300">
                    💡 Pastikan kamera memiliki izin akses dan pencahayaan cukup.
                </p>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/html5-qrcode"></script>
        <script>
            let html5QrCode;
            let isScanning = true;

            function onScanSuccess(decodedText) {
                // Stop scanner temporarily
                isScanning = false;

                fetch('{{ route("checkin.process") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ ticket_code: decodedText }),
                })
                    .then(res => res.json().then(data => ({ status: res.status, data })))
                    .then(({ data }) => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Check In Berhasil!',
                                html: `
                                <div class="text-left mt-4 space-y-2 text-sm">
                                    <p><strong>Nama:</strong> ${data.ticket.full_name}</p>
                                    <p><strong>Email:</strong> ${data.ticket.email}</p>
                                    <p><strong>Kode:</strong> <code>${data.ticket.ticket_code}</code></p>
                                </div>
                            `,
                                confirmButtonColor: '#2563eb',
                            }).then(() => {
                                // Resume scanning
                                isScanning = true;
                                document.getElementById('cameraBtn').textContent = 'Pause';
                            });
                        } else if (data.type === 'already_used') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Tiket Sudah Digunakan!',
                                text: 'Tiket ini sudah pernah di-check in.',
                                confirmButtonColor: '#ef4444',
                            }).then(() => {
                                isScanning = true;
                                document.getElementById('cameraBtn').textContent = 'Pause';
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Tiket Tidak Ditemukan!',
                                text: 'QR Code tidak valid.',
                                confirmButtonColor: '#ef4444',
                            }).then(() => {
                                isScanning = true;
                                document.getElementById('cameraBtn').textContent = 'Pause';
                            });
                        }
                    });
            }

            function onScanFailure(error) {
                // Ignore scan failures (normal when no QR in frame)
            }

            function startScanner() {
                html5QrCode = new Html5Qrcode("reader");
                html5QrCode.start(
                    { facingMode: "environment" },
                    { fps: 10, qrbox: { width: 250, height: 250 } },
                    onScanSuccess,
                    onScanFailure
                ).catch(err => {
                    document.getElementById('reader').innerHTML = `
                        <div class="text-center p-8">
                            <p class="text-red-500 font-medium">Gagal mengakses kamera</p>
                            <p class="text-sm text-slate-500 mt-2">${err}</p>
                        </div>
                    `;
                });
            }

            function toggleCamera() {
                const btn = document.getElementById('cameraBtn');
                if (isScanning) {
                    html5QrCode.pause(true);
                    btn.textContent = 'Resume';
                    isScanning = false;
                } else {
                    html5QrCode.resume();
                    btn.textContent = 'Pause';
                    isScanning = true;
                }
            }

            // Start scanner on page load
            startScanner();

            // Stop scanner when leaving page
            window.addEventListener('beforeunload', () => {
                if (html5QrCode && isScanning) {
                    html5QrCode.stop().catch(err => console.log(err));
                }
            });
        </script>
    @endpush
@endsection