<?php

namespace App\Exports;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class TicketExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithTitle,
    ShouldAutoSize,
    WithCustomStartCell
{
    protected Request $request;
    protected int $rowNumber = 0;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get the data collection
     */
    public function collection()
    {
        $query = Ticket::query();

        // Apply filters
        if ($this->request->filled('search')) {
            $query->search($this->request->search);
        }

        if ($this->request->filled('status')) {
            $query->byStatus($this->request->status);
        }

        if ($this->request->filled('city')) {
            $query->byCity($this->request->city);
        }

        if ($this->request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $this->request->date_from);
        }

        if ($this->request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $this->request->date_to);
        }

        return $query->latest()->get();
    }

    /**
     * Define column headings
     */
    public function headings(): array
    {
        return [
            'No',
            'Kode Tiket',
            'Nama Lengkap',
            'Email',
            'No. HP',
            'Jenis Kelamin',
            'Tanggal Lahir',
            'Alamat',
            'Kota',
            'No. Identitas',
            'Kontak Darurat',
            'No. Kontak Darurat',
            'Status',
            'Waktu Check In',
            'Tanggal Pesan',
        ];
    }

    /**
     * Map data to columns
     */
    public function map($ticket): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,
            $ticket->ticket_code,
            $ticket->full_name,
            $ticket->email,
            $ticket->phone,
            $ticket->gender === 'male' ? 'Laki-laki' : 'Perempuan',
            $ticket->birth_date->format('d/m/Y'),
            $ticket->address,
            $ticket->city,
            $ticket->identity_number,
            $ticket->emergency_contact,
            $ticket->emergency_phone,
            $ticket->status === 'unused' ? 'Belum Check In' : 'Sudah Check In',
            $ticket->checked_in_at ? $ticket->checked_in_at->format('d/m/Y H:i:s') : '-',
            $ticket->created_at->format('d/m/Y H:i:s'),
        ];
    }

    /**
     * Apply styles to worksheet
     */
    public function styles(Worksheet $sheet)
    {
        // Header row styling
        $sheet->getStyle('A1:O1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2563EB'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '1E40AF'],
                ],
            ],
        ]);

        // Data rows styling
        $lastRow = $sheet->getHighestRow();
        if ($lastRow > 1) {
            $sheet->getStyle("A2:O{$lastRow}")->applyFromArray([
                'font' => [
                    'size' => 10,
                ],
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => 'E5E7EB'],
                    ],
                ],
            ]);

            // Alternate row colors
            for ($i = 2; $i <= $lastRow; $i++) {
                if ($i % 2 === 0) {
                    $sheet->getStyle("A{$i}:O{$i}")->applyFromArray([
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'F9FAFB'],
                        ],
                    ]);
                }
            }
        }

        // Freeze header row
        $sheet->freezePane('A2');

        return [];
    }

    /**
     * Set worksheet title
     */
    public function title(): string
    {
        return 'Data Tiket Konser';
    }

    /**
     * Set custom start cell
     */
    public function startCell(): string
    {
        return 'A1';
    }
}