<?php

namespace App\Http\Controllers\Admin;

use App\Exports\TicketExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\TicketRequest;
use App\Models\Ticket;
use App\Services\TicketService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class TicketController extends Controller
{
    public function __construct(
        private TicketService $ticketService
    ) {
    }

    /**
     * Display a listing of tickets.
     */
    public function index(Request $request): View
    {
        $query = Ticket::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->search($search);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        // City filter
        if ($request->filled('city')) {
            $query->byCity($request->city);
        }

        // Date range filter
        if ($request->filled('date_from') || $request->filled('date_to')) {
            $query->dateRange($request->date_from, $request->date_to);
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $allowedSorts = ['created_at', 'full_name', 'ticket_code', 'city', 'status'];

        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortDirection);
        } else {
            $query->latest();
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $tickets = $query->paginate($perPage)->withQueryString();

        // Get cities for filter
        $cities = $this->ticketService->getCities();

        return view('admin.tickets.index', compact('tickets', 'cities'));
    }

    /**
     * Show the form for creating a new ticket.
     */
    public function create(): View
    {
        return view('admin.tickets.create');
    }

    /**
     * Store a newly created ticket.
     */
    public function store(TicketRequest $request): RedirectResponse
    {
        try {
            $ticket = $this->ticketService->createTicket($request->validated());

            return redirect()->route('admin.tickets.index')
                ->with('success', "Tiket berhasil ditambahkan dengan kode: {$ticket->ticket_code}");
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan tiket. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified ticket.
     */
    public function show(Ticket $ticket): View
    {
        return view('admin.tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified ticket.
     */
    public function edit(Ticket $ticket): View
    {
        return view('admin.tickets.edit', compact('ticket'));
    }

    /**
     * Update the specified ticket.
     */
    public function update(TicketRequest $request, Ticket $ticket): RedirectResponse
    {
        try {
            $this->ticketService->updateTicket($ticket, $request->validated());

            return redirect()->route('admin.tickets.index')
                ->with('success', 'Tiket berhasil diperbarui.');
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui tiket. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified ticket (soft delete).
     */
    public function destroy(Ticket $ticket): RedirectResponse
    {
        try {
            $this->ticketService->deleteTicket($ticket);

            return redirect()->route('admin.tickets.index')
                ->with('success', 'Tiket berhasil dihapus.');
        } catch (\Throwable $e) {
            report($e);

            return back()->with('error', 'Gagal menghapus tiket.');
        }
    }

    /**
     * Bulk delete tickets.
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:tickets,id',
        ]);

        try {
            $count = $this->ticketService->bulkDelete($request->ids);

            return response()->json([
                'success' => true,
                'message' => "{$count} tiket berhasil dihapus.",
                'count' => $count,
            ]);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus tiket.',
            ], 500);
        }
    }

    /**
     * Restore a soft-deleted ticket.
     */
    public function restore(int $id): RedirectResponse
    {
        try {
            $ticket = $this->ticketService->restoreTicket($id);

            return redirect()->back()
                ->with('success', 'Tiket berhasil dipulihkan.');
        } catch (\Throwable $e) {
            report($e);

            return back()->with('error', 'Gagal memulihkan tiket.');
        }
    }

    /**
     * Show trashed tickets.
     */
    public function trashed(Request $request): View
    {
        $query = Ticket::onlyTrashed();

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $tickets = $query->latest('deleted_at')->paginate(15)->withQueryString();

        return view('admin.tickets.trashed', compact('tickets'));
    }

    /**
     * Export tickets to PDF.
     */
    public function exportPdf(Request $request)
    {
        $tickets = $this->getFilteredTickets($request);

        $pdf = Pdf::loadView('pdf.tickets', compact('tickets'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('Laporan-Tiket-' . date('Y-m-d-His') . '.pdf');
    }

    /**
     * Export tickets to Excel.
     */
    public function exportExcel(Request $request)
    {
        $filename = 'Laporan-Tiket-' . date('Y-m-d-His') . '.xlsx';

        return Excel::download(new TicketExport($request), $filename);
    }

    /**
     * Get filtered tickets based on request.
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

        if ($request->filled('date_from') || $request->filled('date_to')) {
            $query->dateRange($request->date_from, $request->date_to);
        }

        return $query->latest()->get();
    }
}