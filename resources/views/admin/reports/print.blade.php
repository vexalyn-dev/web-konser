<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Tiket - AGX Concert</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 15px;
        }

        .header h1 {
            color: #2563eb;
            font-size: 24px;
            margin-bottom: 5px;
        }

        .header p {
            color: #64748b;
            font-size: 12px;
        }

        .info-box {
            background: #f8fafc;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .info-box strong {
            color: #0f172a;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        thead {
            background: #2563eb;
            color: white;
        }

        th {
            padding: 10px 8px;
            text-align: left;
            font-weight: 600;
        }

        td {
            padding: 8px;
            border-bottom: 1px solid #e2e8f0;
        }

        tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .status {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }

        .status.checked {
            background: #d1fae5;
            color: #065f46;
        }

        .status.unused {
            background: #fef3c7;
            color: #92400e;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 11px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
        }

        @media print {
            body {
                padding: 0;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="no-print" style="text-align: right; margin-bottom: 20px;">
        <button onclick="window.print()"
            style="padding: 8px 20px; background: #2563eb; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">
            🖨️ Print
        </button>
        <button onclick="window.close()"
            style="padding: 8px 20px; background: #64748b; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; margin-left: 5px;">
            Tutup
        </button>
    </div>

    <div class="header">
        <h1>AGX CONCERT</h1>
        <p>Laporan Data Tiket Konser</p>
        <p>Dicetak: {{ now()->format('d F Y, H:i') }} WIB</p>
    </div>

    <div class="info-box">
        <strong>Total Data:</strong> {{ $tickets->count() }} tiket &nbsp;|&nbsp;
        @if(!empty($filters['status']))
            <strong>Status:</strong> {{ $filters['status'] === 'checked_in' ? 'Sudah Check In' : 'Belum Check In' }}
            &nbsp;|&nbsp;
        @endif
        @if(!empty($filters['city']))
            <strong>Kota:</strong> {{ $filters['city'] }} &nbsp;|&nbsp;
        @endif
        @if(!empty($filters['date_from']) || !empty($filters['date_to']))
            <strong>Periode:</strong> {{ $filters['date_from'] ?? '...' }} s/d {{ $filters['date_to'] ?? '...' }}
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th width="40">No</th>
                <th>Kode Tiket</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>No. HP</th>
                <th>Kota</th>
                <th>Status</th>
                <th>Check In</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tickets as $index => $ticket)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="font-family: monospace; font-weight: 600;">{{ $ticket->ticket_code }}</td>
                    <td>{{ $ticket->full_name }}</td>
                    <td>{{ $ticket->email }}</td>
                    <td>{{ $ticket->phone }}</td>
                    <td>{{ $ticket->city }}</td>
                    <td>
                        <span class="status {{ $ticket->status }}">
                            {{ $ticket->status_name }}
                        </span>
                    </td>
                    <td>{{ $ticket->checked_in_at ? $ticket->checked_in_at->format('d/m/Y H:i') : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px;">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>© 2026 AGX Concert - Ticket Management System</p>
        <p>Dokumen ini dicetak secara otomatis oleh sistem.</p>
    </div>

    <script>
        window.onload = function () {
            // Auto print when page loads (optional)
            // window.print();
        };
    </script>
</body>

</html>