<?php

namespace App\Http\Controllers\Admin;

use App\Exports\TicketExport;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Services\TicketService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function __construct(
        private TicketService $ticketService
    ) {
    }

    /**
     * Display report page.
     */
    public function index(Request $request): View
    {
        $query = Ticket::query();

        // Apply filters
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        if ($request->filled('city')) {
            $query->byCity($request->city);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $tickets = $query->latest()->paginate(20)->withQueryString();
        $cities = $this->ticketService->getCities();

        // Calculate summary
        $summary = [
            'total' => $query->count(),
            'checked_in' => (clone $query)->where('status', 'checked_in')->count(),
            'unused' => (clone $query)->where('status', 'unused')->count(),
        ];

        return view('admin.reports.index', compact('tickets', 'cities', 'summary'));
    }

    /**
     * Export report to PDF.
     */
    public function exportPdf(Request $request)
    {
        $tickets = $this->getFilteredTickets($request);
        $filters = $request->only(['search', 'status', 'city', 'date_from', 'date_to']);

        $pdf = Pdf::loadView('pdf.report', compact('tickets', 'filters'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('Laporan-Concert-' . date('Y-m-d-His') . '.pdf');
    }

    /**
     * Export report to Excel.
     */
    public function exportExcel(Request $request)
    {
        $filename = 'Laporan-Concert-' . date('Y-m-d-His') . '.xlsx';

        return Excel::download(new TicketExport($request), $filename);
    }

    /**
     * Print report.
     */
    public function print(Request $request): View
    {
        $tickets = $this->getFilteredTickets($request);
        $filters = $request->only(['search', 'status', 'city', 'date_from', 'date_to']);

        return view('admin.reports.print', compact('tickets', 'filters'));
    }

    /**
     * Get filtered tickets.
     */
    protected function getFilteredTickets(Request $request)
    {
        $query = Ticket::query();

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        if ($request->filled('city')) {
            $query->byCity($request->city);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        return $query->latest()->get();
    }
}