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
    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm" data-aos="fade-up" data-aos-delay="100">
        <div id="reader" class="rounded-xl overflow-hidden bg-slate-100 dark:bg-slate-900 min-h-[300px] flex items-center justify-center">
            <p class="text-slate-500">Memuat kamera...</p>
        </div>
        
        <div class="mt-4 flex items-center justify-center gap-3">
            <a href="{{ route('checkin.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-400 font-medium text-sm hover:bg-slate-50 dark:hover:bg-slate-700 transition-all">
                ← Kembali
            </a>
            <button onclick="toggleCamera()" id="cameraBtn" class="px-5 py-2.5 rounded-xl gradient-primary text-white font-medium text-sm shadow-lg shadow-blue-500/25 hover:shadow-xl transition-all">
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
    let isProcessing = false; // FIX: Prevent double processing
    
    function onScanSuccess(decodedText, decodedResult) {
        // FIX: Prevent multiple scans while processing
        if (isProcessing) {
            console.log('Already processing, ignoring scan');
            return;
        }
        
        console.log('QR Code scanned:', decodedText);
        isProcessing = true;
        
        // Pause scanner while processing
        if (isScanning) {
            html5QrCode.pause(true);
            isScanning = false;
            document.getElementById('cameraBtn').textContent = 'Resume';
        }
        
        // Send to server
        fetch('{{ route("checkin.process") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ 
                ticket_code: decodedText.trim() // FIX: Trim whitespace
            }),
        })
        .then(res => {
            console.log('Response status:', res.status);
            return res.json().then(data => ({ status: res.status, data }));
        })
        .then(({ status, data }) => {
            console.log('Response data:', data);
            
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
                    allowOutsideClick: false,
                }).then(() => {
                    // Resume scanning
                    isProcessing = false;
                    if (!isScanning) {
                        html5QrCode.resume();
                        isScanning = true;
                        document.getElementById('cameraBtn').textContent = 'Pause';
                    }
                });
                
            } else if (data.type === 'already_used') {
                // ❌ TIKET SUDAH DIPAKAI
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
                    allowOutsideClick: false,
                }).then(() => {
                    isProcessing = false;
                    if (!isScanning) {
                        html5QrCode.resume();
                        isScanning = true;
                        document.getElementById('cameraBtn').textContent = 'Pause';
                    }
                });
                
            } else if (data.type === 'deleted') {
                // ❌ TIKET DIHAPUS
                Swal.fire({
                    icon: 'warning',
                    title: 'Tiket Sudah Dihapus',
                    text: 'Tiket ini sudah dihapus oleh administrator.',
                    confirmButtonColor: '#f59e0b',
                    allowOutsideClick: false,
                }).then(() => {
                    isProcessing = false;
                    if (!isScanning) {
                        html5QrCode.resume();
                        isScanning = true;
                        document.getElementById('cameraBtn').textContent = 'Pause';
                    }
                });
                
            } else {
                // ❌ TIKET TIDAK DITEMUKAN
                Swal.fire({
                    icon: 'error',
                    title: 'Tiket Tidak Ditemukan!',
                    text: data.message || 'Kode tiket yang dimasukkan tidak valid.',
                    footer: '<p class="text-xs text-slate-500">Periksa kembali kode tiket Anda. Format: AGX-2026-XXXXXX</p>',
                    confirmButtonColor: '#ef4444',
                    allowOutsideClick: false,
                }).then(() => {
                    isProcessing = false;
                    if (!isScanning) {
                        html5QrCode.resume();
                        isScanning = true;
                        document.getElementById('cameraBtn').textContent = 'Pause';
                    }
                });
            }
        })
        .catch((error) => {
            console.error('Scan error:', error);
            isProcessing = false;
            
            // Resume scanner on error
            if (!isScanning) {
                html5QrCode.resume();
                isScanning = true;
                document.getElementById('cameraBtn').textContent = 'Pause';
            }
            
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan koneksi. Silakan coba lagi.',
            });
        });
    }
    
    function onScanFailure(error) {
        // Ignore scan failures (normal when no QR in frame)
        // console.warn(`Code scan error = ${error}`);
    }
    
    function startScanner() {
        html5QrCode = new Html5Qrcode("reader");
        
        const config = {
            fps: 10,
            qrbox: { width: 250, height: 250 },
            aspectRatio: 1.0,
            disableFlip: false,
        };
        
        html5QrCode.start(
            { facingMode: "environment" }, // Use back camera
            config,
            onScanSuccess,
            onScanFailure
        )
        .catch(err => {
            console.error('Failed to start scanner:', err);
            document.getElementById('reader').innerHTML = `
                <div class="text-center p-8">
                    <svg class="w-16 h-16 mx-auto text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-red-500 font-medium">Gagal mengakses kamera</p>
                    <p class="text-sm text-slate-500 mt-2">${err}</p>
                    <button onclick="location.reload()" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Reload Halaman
                    </button>
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
    document.addEventListener('DOMContentLoaded', startScanner);
    
    // Stop scanner when leaving page
    window.addEventListener('beforeunload', () => {
        if (html5QrCode && isScanning) {
            html5QrCode.stop().catch(err => console.log('Scanner stopped:', err));
        }
    });
</script>
@endpush
@endsection