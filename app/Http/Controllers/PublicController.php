<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Models\Ticket;
use App\Services\TicketService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PublicController extends Controller
{
    public function __construct(
        private TicketService $ticketService
    ) {
    }

    /**
     * Show landing page.
     */
    public function index(): View
    {
        return view('public.index');
    }

    /**
     * Show order form.
     */
    public function order(): View
    {
        return view('public.order');
    }

    /**
     * Store new ticket order.
     */
    public function store(TicketRequest $request): RedirectResponse
    {
        try {
            $ticket = $this->ticketService->createTicket($request->validated());

            return redirect()->route('ticket.show', $ticket->ticket_code)
                ->with('success', 'Tiket berhasil dipesan! Silakan simpan kode tiket Anda.');
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memproses pemesanan. Silakan coba lagi.');
        }
    }

    /**
     * Show ticket details.
     */
    public function show(string $ticketCode): View
    {
        $ticket = Ticket::where('ticket_code', $ticketCode)->firstOrFail();

        // Generate QR Code as SVG (no Imagick needed)
        $qrCodeSvg = QrCode::format('svg')
            ->size(300)
            ->margin(1)
            ->generate($ticket->ticket_code);

        // Convert SVG to Base64 for display
        $qrCodeBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrCodeSvg);

        return view('public.ticket', compact('ticket', 'qrCodeBase64'));
    }

    /**
     * Download ticket as PDF.
     */
    public function downloadPdf(string $ticketCode)
    {
        $ticket = Ticket::where('ticket_code', $ticketCode)->firstOrFail();

        // Generate QR Code as SVG (no Imagick needed)
        $qrCodeSvg = QrCode::format('svg')
            ->size(400)
            ->margin(1)
            ->generate($ticket->ticket_code);

        // Convert SVG to Base64 for PDF
        $qrCodeBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrCodeSvg);

        // Pass as collection for the report view
        $tickets = collect([$ticket]);

        $pdf = Pdf::loadView('pdf.ticket', compact('tickets', 'qrCodeBase64'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download("Tiket-{$ticket->ticket_code}.pdf");
    }

    /**
     * Download QR Code as SVG image.
     */
    public function downloadQrCode(string $ticketCode)
    {
        $ticket = Ticket::where('ticket_code', $ticketCode)->firstOrFail();

        // Generate QR Code as SVG
        $qrCodeSvg = QrCode::format('svg')
            ->size(400)
            ->margin(1)
            ->generate($ticket->ticket_code);

        // Return SVG as downloadable file
        return response($qrCodeSvg, 200)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', "attachment; filename=QRCode-{$ticket->ticket_code}.svg");
    }

    /**
     * Show about page.
     */
    public function about(): View
    {
        return view('public.about');
    }

    /**
     * Show FAQ page.
     */
    public function faq(): View
    {
        return view('public.faq');
    }

    /**
     * Show contact page.
     */
    public function contact(): View
    {
        return view('public.contact');
    }
}