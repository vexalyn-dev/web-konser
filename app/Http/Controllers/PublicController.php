<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Models\Concert;
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
     * Landing page dengan daftar konser
     */
    public function index(): View
    {
        $concerts = Concert::published()
            ->upcoming()
            ->orderBy('start_date')
            ->paginate(9);

        $featuredConcert = Concert::published()
            ->upcoming()
            ->orderBy('start_date')
            ->first();

        return view('public.index', compact('concerts', 'featuredConcert'));
    }

    /**
     * Detail konser
     */
    public function showConcert(string $slug): View
    {
        $concert = Concert::published()->where('slug', $slug)->firstOrFail();

        return view('public.concert-detail', compact('concert'));
    }

    /**
     * Form pemesanan tiket untuk konser tertentu
     */
    public function order(?string $concertSlug = null): View
    {
        $concert = null;

        if ($concertSlug) {
            $concert = Concert::published()->where('slug', $concertSlug)->firstOrFail();
        }

        $concerts = Concert::published()
            ->upcoming()
            ->orderBy('start_date')
            ->get();

        return view('public.order', compact('concert', 'concerts'));
    }

    /**
     * Store new ticket order
     */
    public function store(TicketRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Jika ada concert_id, tambahkan ke data
        if ($request->filled('concert_id')) {
            $validated['concert_id'] = $request->concert_id;
        }

        $ticket = $this->ticketService->createTicket($validated);

        return redirect()->route('ticket.show', $ticket->ticket_code)
            ->with('success', 'Tiket berhasil dipesan! Silakan simpan kode tiket Anda.');
    }

    /**
     * Show ticket details
     */
    public function show(string $ticketCode): View
    {
        $ticket = Ticket::with('concert')->where('ticket_code', $ticketCode)->firstOrFail();

        // Generate QR Code
        $qrCodeBase64 = 'data:image/png;base64,' . base64_encode(
            QrCode::format('png')
                ->size(300)
                ->margin(1)
                ->generate($ticket->ticket_code)
        );

        return view('public.ticket', compact('ticket', 'qrCodeBase64'));
    }

    /**
     * Download ticket as PDF
     */
    public function downloadPdf(string $ticketCode)
    {
        $ticket = Ticket::with('concert')->where('ticket_code', $ticketCode)->firstOrFail();

        $qrCodeBase64 = 'data:image/png;base64,' . base64_encode(
            QrCode::format('png')
                ->size(400)
                ->margin(1)
                ->generate($ticket->ticket_code)
        );

        $pdf = Pdf::loadView('pdf.ticket', compact('ticket', 'qrCodeBase64'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download("Tiket-{$ticket->ticket_code}.pdf");
    }

    public function about(): View
    {
        return view('public.about');
    }

    public function faq(): View
    {
        return view('public.faq');
    }

    public function contact(): View
    {
        return view('public.contact');
    }
}