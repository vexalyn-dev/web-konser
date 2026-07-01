<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Lengkap - AGX Concert</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica', Arial, sans-serif;
            font-size: 10px;
            line-height: 1.5;
            color: #1e293b;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid #2563eb;
        }

        .header h1 {
            color: #0f172a;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .header p {
            color: #64748b;
            font-size: 10px;
        }

        .filter-info {
            background: #eff6ff;
            border-left: 4px solid #2563eb;
            padding: 10px 15px;
            margin-bottom: 20px;
            font-size: 9px;
        }

        .filter-info strong {
            color: #1e40af;
        }

        .summary-cards {
            display: table;
            width: 100%;
            margin-bottom: 20px;
            border-spacing: 10px 0;
        }

        .summary-card {
            display: table-cell;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 12px;
            text-align: center;
        }

        .summary-card-label {
            font-size: 9px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .summary-card-value {
            font-size: 18px;
            font-weight: bold;
            color: #0f172a;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 9px;
        }

        thead {
            background: #2563eb;
            color: white;
        }

        th {
            padding: 7px 5px;
            text-align: left;
            font-weight: 600;
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 6px 5px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: top;
        }

        tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .ticket-code {
            font-family: 'Courier New', monospace;
            font-weight: bold;
            color: #1e40af;
            font-size: 8px;
        }

        .status {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 7px;
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
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            font-size: 8px;
            color: #94a3b8;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #0f172a;
            margin: 15px 0 10px 0;
            padding-bottom: 5px;
            border-bottom: 2px solid #e2e8f0;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>AGX CONCERT</h1>
        <p>Laporan Lengkap Data Tiket Konser</p>
        <p>Dicetak: {{ now()->format('d F Y, H:i') }} WIB</p>
    </div>

    @if(!empty($filters))
        <div class="filter-info">
            <strong>Filter yang diterapkan:</strong><br>
            @if(!empty($filters['search']))
                • Pencarian: "{{ $filters['search'] }}"<br>
            @endif
            @if(!empty($filters['status']))
                • Status: {{ $filters['status'] === 'checked_in' ? 'Sudah Check In' : 'Belum Check In' }}<br>
            @endif
            @if(!empty($filters['city']))
                • Kota: {{ $filters['city'] }}<br>
            @endif
            @if(!empty($filters['date_from']) || !empty($filters['date_to']))
                • Periode: {{ $filters['date_from'] ?? 'Awal' }} s/d {{ $filters['date_to'] ?? 'Sekarang' }}<br>
            @endif
        </div>
    @endif

    <div class="summary-cards">
        <div class="summary-card">
            <div class="summary-card-label">Total Tiket</div>
            <div class="summary-card-value">{{ $tickets->count() }}</div>
        </div>
        <div class="summary-card">
            <div class="summary-card-label">Checked In</div>
            <div class="summary-card-value" style="color: #059669;">
                {{ $tickets->where('status', 'checked_in')->count() }}</div>
        </div>
        <div class="summary-card">
            <div class="summary-card-label">Belum Check In</div>
            <div class="summary-card-value" style="color: #d97706;">{{ $tickets->where('status', 'unused')->count() }}
            </div>
        </div>
    </div>

    <div class="section-title">Data Tiket</div>

    <table>
        <thead>
            <tr>
                <th width="25">No</th>
                <th width="90">Kode Tiket</th>
                <th>Nama Lengkap</th>
                <th width="110">Email</th>
                <th width="70">No. HP</th>
                <th width="60">Kota</th>
                <th width="60">Status</th>
                <th width="80">Check In</th>
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
                            {{ $ticket->status === 'checked_in' ? 'Checked' : 'Belum' }}
                        </span>
                    </td>
                    <td>{{ $ticket->checked_in_at ? $ticket->checked_in_at->format('d/m H:i') : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px; color: #94a3b8; font-style: italic;">
                        Tidak ada data tiket
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>© 2026 AGX Concert - Ticket Management System</p>
        <p>Dokumen ini dicetak secara otomatis oleh sistem pada {{ now()->format('d/m/Y H:i:s') }}</p>
        <p>Halaman 1 dari 1</p>
    </div>
</body>

</html>