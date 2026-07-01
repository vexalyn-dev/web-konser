<?php

namespace App\Http\Controllers\CheckIn;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Services\CheckInService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckInController extends Controller
{
    public function __construct(
        private CheckInService $checkInService
    ) {}

    public function index(): View
    {
        $todayCheckIns = $this->checkInService->getTodayCheckIns(10);
        $todayCount = Ticket::checkedIn()->whereDate('checked_in_at', today())->count();

        return view('checkin.index', compact('todayCheckIns', 'todayCount'));
    }

    public function scan(): View
    {
        return view('checkin.scan');
    }

    /**
     * FIX: Process check-in dengan response lebih detail
     */
    public function process(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'ticket_code' => ['required', 'string', 'max:30'],
        ], [
            'ticket_code.required' => 'Kode tiket wajib diisi.',
        ]);

        $userId = $request->user()?->id;
        
        $result = $this->checkInService->checkIn(
            $validated['ticket_code'],
            $userId
        );

        // Handle AJAX request
        if ($request->expectsJson() || $request->ajax()) {
            $statusCode = $result['success'] ? 200 : 400;
            
            $response = [
                'success' => $result['success'],
                'message' => $result['message'],
                'type' => $result['type'],
            ];

            if (isset($result['ticket'])) {
                $response['ticket'] = [
                    'id' => $result['ticket']->id,
                    'ticket_code' => $result['ticket']->ticket_code,
                    'full_name' => $result['ticket']->full_name,
                    'email' => $result['ticket']->email,
                    'phone' => $result['ticket']->phone,
                    'city' => $result['ticket']->city,
                    'status' => $result['ticket']->status,
                    'status_name' => $result['ticket']->status_name,
                    'checked_in_at' => $result['ticket']->checked_in_at?->format('d/m/Y H:i:s'),
                ];
            }

            // FIX: Tambahkan info tambahan untuk error "already_used"
            if ($result['type'] === 'already_used') {
                $response['checked_in_at'] = $result['checked_in_at'] ?? null;
                $response['checked_in_human'] = $result['checked_in_human'] ?? null;
            }

            return response()->json($response, $statusCode);
        }

        // Handle regular request
        if ($result['success']) {
            return back()->with('success', $result['message']);
        }

        return back()->with('error', $result['message']);
    }

    public function history(Request $request): View
    {
        $query = Ticket::checkedIn()
            ->whereNotNull('checked_in_at');

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $tickets = $query->latest('checked_in_at')
            ->paginate(20)
            ->withQueryString();

        return view('checkin.history', compact('tickets'));
    }

    public function validate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'ticket_code' => ['required', 'string'],
        ]);

        $result = $this->checkInService->validateTicket($validated['ticket_code']);

        $response = [
            'valid' => $result['valid'],
            'message' => $result['message'],
            'type' => $result['type'],
        ];

        if (isset($result['ticket'])) {
            $response['ticket'] = [
                'ticket_code' => $result['ticket']->ticket_code,
                'full_name' => $result['ticket']->full_name,
                'email' => $result['ticket']->email,
                'status' => $result['ticket']->status,
            ];
        }

        return response()->json($response);
    }
}