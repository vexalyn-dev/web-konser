<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>E-Ticket - {{ $ticket->ticket_code }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            background-color: #f8fafc;
            padding: 40px 30px;
        }
        .ticket-card {
            background-color: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            max-width: 600px;
            margin: 0 auto;
        }
        .ticket-header {
            background: #2563eb;
            padding: 24px;
            color: #ffffff;
        }
        .ticket-header h1 {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }
        .ticket-header p {
            font-size: 14px;
            color: #bfdbfe;
            margin-top: 4px;
        }
        .ticket-body {
            padding: 24px;
        }
        .qr-section {
            text-align: center;
            margin-bottom: 24px;
        }
        .qr-wrapper {
            display: inline-block;
            padding: 16px;
            background: #ffffff;
            border-radius: 12px;
            border: 2px dashed #cbd5e1;
        }
        .qr-image {
            width: 180px;
            height: 180px;
        }
        .ticket-code {
            font-family: 'Courier New', monospace;
            font-size: 22px;
            font-weight: bold;
            color: #1e293b;
            margin-top: 12px;
            letter-spacing: 2px;
        }
        .ticket-info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .ticket-info-table td {
            padding: 10px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .label {
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .value {
            font-size: 14px;
            font-weight: bold;
            color: #0f172a;
            text-align: right;
        }
        .footer-note {
            text-align: center;
            font-size: 11px;
            color: #94a3b8;
            margin-top: 30px;
            line-height: 1.6;
        }
        .concert-banner-info {
            font-size: 12px;
            opacity: 0.9;
        }
        .concert-banner-info table {
            width: 100%;
            border: none;
            margin: 0;
        }
        .concert-banner-info td {
            border: none;
            padding: 0;
            color: white;
        }
    </style>
</head>
<body>

<div class="ticket-card">
    <div class="ticket-header">
        <table style="width: 100%; border: none;">
            <tr>
                <td style="border: none; padding: 0; color: white;">
                    <h1>AGX Concert 2026</h1>
                    <p>Official E-Ticket</p>
                </td>
                <td style="border: none; padding: 0; color: white; text-align: right; vertical-align: middle;">
                    <span style="font-size: 12px; background: rgba(255,255,255,0.2); padding: 6px 12px; border-radius: 20px;">
                        {{ $ticket->status === 'checked_in' ? 'Checked In' : 'Belum Check In' }}
                    </span>
                </td>
            </tr>
        </table>
    </div>

    <div class="ticket-body">
        <!-- Concert Info in PDF -->
        @if($ticket->concert)
        <div style="background: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%); padding: 15px; border-radius: 8px; margin-bottom: 20px; color: white;">
            <p style="font-size: 10px; margin: 0; opacity: 0.8; text-transform: uppercase; letter-spacing: 1px;">Tiket Untuk Konser</p>
            <h2 style="font-size: 18px; margin: 5px 0 10px 0; font-weight: bold;">{{ $ticket->concert->name }}</h2>
            <div class="concert-banner-info">
                <table>
                    <tr>
                        <td style="width: 50%;">📅 {{ $ticket->concert->start_date->format('d M Y, H:i') }} WIB</td>
                        <td style="width: 50%; text-align: right;">📍 {{ $ticket->concert->venue }}</td>
                    </tr>
                </table>
            </div>
        </div>
        @endif

        <div class="qr-section">
            <div class="qr-wrapper">
                <img class="qr-image" src="{{ $qrCodeBase64 }}" alt="QR Code">
            </div>
            <div class="ticket-code">{{ $ticket->ticket_code }}</div>
            <p style="font-size: 11px; color: #64748b; margin-top: 4px;">Scan QR Code ini pada pintu masuk lokasi konser</p>
        </div>

        <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 16px 0;">

        <table class="ticket-info-table">
            <tr>
                <td class="label">Nama Pemesan</td>
                <td class="value">{{ $ticket->full_name }}</td>
            </tr>
            <tr>
                <td class="label">Email</td>
                <td class="value">{{ $ticket->email }}</td>
            </tr>
            <tr>
                <td class="label">Nomor HP</td>
                <td class="value">{{ $ticket->phone }}</td>
            </tr>
            <tr>
                <td class="label">Kota asal</td>
                <td class="value">{{ $ticket->city }}</td>
            </tr>
            <tr>
                <td class="label">Nomor Identitas</td>
                <td class="value">{{ $ticket->identity_number }}</td>
            </tr>
        </table>
    </div>
</div>

<div class="footer-note">
    <p>Dilarang menyebarluaskan QR Code tiket ini untuk menghindari penyalahgunaan.</p>
    <p>© 2026 AGX Concert. All rights reserved.</p>
</div>

</body>
</html>