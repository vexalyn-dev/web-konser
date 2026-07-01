<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Data Tiket - AGX Concert</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica', Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #1e293b;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #2563eb;
        }

        .header h1 {
            color: #0f172a;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }

        .header p {
            color: #64748b;
            font-size: 11px;
        }

        .summary {
            background: #f1f5f9;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 10px;
        }

        .summary-row {
            display: inline-block;
            margin-right: 20px;
        }

        .summary-label {
            color: #64748b;
            font-weight: normal;
        }

        .summary-value {
            color: #0f172a;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 10px;
        }

        thead {
            background: #2563eb;
            color: white;
        }

        th {
            padding: 8px 6px;
            text-align: left;
            font-weight: 600;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 7px 6px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: top;
        }

        tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        tbody tr:hover {
            background: #eff6ff;
        }

        .ticket-code {
            font-family: 'Courier New', monospace;
            font-weight: bold;
            color: #1e40af;
            font-size: 9px;
        }

        .status {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status.checked_in {
            background: #d1fae5;
            color: #065f46;
        }

        .status.unused {
            background: #fef3c7;
            color: #92400e;
        }

        .footer {
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            font-size: 9px;
            color: #94a3b8;
        }

        .page-break {
            page-break-after: always;
        }

        .no-data {
            text-align: center;
            padding: 30px;
            color: #94a3b8;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>AGX CONCERT</h1>
        <p>Laporan Data Tiket Konser</p>
        <p>Dicetak: {{ now()->format('d F Y, H:i') }} WIB</p>
    </div>

    <div class="summary">
        <div class="summary-row">
            <span class="summary-label">Total Data:</span>
            <span class="summary-value">{{ $tickets->count() }} tiket</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Sudah Check In:</span>
            <span class="summary-value">{{ $tickets->where('status', 'checked_in')->count() }}</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Belum Check In:</span>
            <span class="summary-value">{{ $tickets->where('status', 'unused')->count() }}</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th width="100">Kode Tiket</th>
                <th>Nama Lengkap</th>
                <th width="120">Email</th>
                <th width="80">No. HP</th>
                <th width="70">Kota</th>
                <th width="70">Status</th>
                <th width="90">Check In</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tickets as $index => $ticket)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="ticket-code">{{ $ticket->ticket_code }}</td>
                    <td>{{ $ticket->full_name }}</td>
                    <td>{{ $ticket->email }}</td>
                    <td>{{ $ticket->phone }}</td>
                    <td>{{ $ticket->city }}</td>
                    <td>
                        <span class="status {{ $ticket->status }}">
                            {{ $ticket->status === 'checked_in' ? 'Checked In' : 'Belum' }}
                        </span>
                    </td>
                    <td>{{ $ticket->checked_in_at ? $ticket->checked_in_at->format('d/m/Y H:i') : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="no-data">Tidak ada data tiket</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>© 2026 AGX Concert - Ticket Management System</p>
        <p>Dokumen ini dicetak secara otomatis oleh sistem pada {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>

</html>