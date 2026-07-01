<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckInService
{
    /**
     * FIX: Process check-in dengan logging detail & info lengkap
     */
    public function checkIn(string $ticketCode, ?int $userId = null): array
    {
        // Normalisasi input
        $ticketCode = trim(strtoupper($ticketCode));
        
        Log::info("Check-in attempt", [
            'ticket_code' => $ticketCode,
            'user_id' => $userId,
            'ip' => request()->ip(),
        ]);

        try {
            return DB::transaction(function () use ($ticketCode, $userId) {
                // Cari tiket (include soft deleted untuk info)
                $ticket = Ticket::where('ticket_code', $ticketCode)->first();

                // FIX: Jika tidak ditemukan, cek apakah ada di trash
                if (!$ticket) {
                    $trashedTicket = Ticket::withTrashed()
                        ->where('ticket_code', $ticketCode)
                        ->first();
                    
                    if ($trashedTicket) {
                        Log::warning("Check-in attempt on deleted ticket", [
                            'ticket_code' => $ticketCode,
                            'deleted_at' => $trashedTicket->deleted_at,
                        ]);
                        
                        return [
                            'success' => false,
                            'message' => 'Tiket ini sudah dihapus oleh administrator.',
                            'type' => 'deleted',
                            'ticket' => $trashedTicket,
                        ];
                    }
                    
                    return [
                        'success' => false,
                        'message' => 'Tiket tidak ditemukan. Periksa kembali kode tiket Anda.',
                        'type' => 'not_found',
                    ];
                }

                // FIX: Auto-fix data inkonsisten sebelum cek
                $ticket->ensureDataConsistency();
                $ticket->refresh();

                // FIX: Cek status dengan validasi ganda
                if ($ticket->isUsed()) {
                    Log::warning("Check-in attempt on already used ticket", [
                        'ticket_code' => $ticketCode,
                        'checked_in_at' => $ticket->checked_in_at,
                        'user_id' => $userId,
                    ]);
                    
                    return [
                        'success' => false,
                        'message' => 'Tiket sudah digunakan.',
                        'type' => 'already_used',
                        'ticket' => $ticket,
                        'checked_in_at' => $ticket->checked_in_at?->format('d/m/Y H:i:s'),
                        'checked_in_human' => $ticket->checked_in_at?->diffForHumans(),
                    ];
                }

                // Mark as checked in
                $ticket->markAsCheckedIn();

                Log::info("Check-in successful", [
                    'ticket_code' => $ticketCode,
                    'user_id' => $userId,
                    'checked_in_at' => $ticket->checked_in_at,
                ]);

                // Log activity
                ActivityLog::log(
                    action: 'check_in',
                    description: "Checked in ticket {$ticket->ticket_code} for {$ticket->full_name}",
                    userId: $userId,
                    modelType: Ticket::class,
                    modelId: $ticket->id,
                    properties: [
                        'ticket_code' => $ticket->ticket_code,
                        'full_name' => $ticket->full_name,
                        'email' => $ticket->email,
                    ]
                );

                return [
                    'success' => true,
                    'message' => 'Check in berhasil!',
                    'type' => 'success',
                    'ticket' => $ticket->fresh(),
                ];
            });
        } catch (\Throwable $e) {
            Log::error('Check-in failed', [
                'ticket_code' => $ticketCode,
                'user_id' => $userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage(),
                'type' => 'error',
            ];
        }
    }

    /**
     * Reset check-in (admin only)
     */
    public function resetCheckIn(string $ticketCode): array
    {
        $ticketCode = trim(strtoupper($ticketCode));
        
        try {
            return DB::transaction(function () use ($ticketCode) {
                $ticket = Ticket::where('ticket_code', $ticketCode)->first();

                if (!$ticket) {
                    return [
                        'success' => false,
                        'message' => 'Tiket tidak ditemukan.',
                    ];
                }

                if ($ticket->isUnused()) {
                    return [
                        'success' => false,
                        'message' => 'Tiket belum di-check in.',
                    ];
                }

                $ticket->resetToUnused();

                ActivityLog::log(
                    action: 'update',
                    description: "Reset check-in for ticket {$ticket->ticket_code}",
                    modelType: Ticket::class,
                    modelId: $ticket->id
                );

                return [
                    'success' => true,
                    'message' => 'Check-in berhasil direset.',
                    'ticket' => $ticket->fresh(),
                ];
            });
        } catch (\Throwable $e) {
            Log::error('Reset check-in failed: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan sistem.',
            ];
        }
    }

    public function getTodayCheckIns(int $limit = 20): \Illuminate\Support\Collection
    {
        return Ticket::checkedIn()
            ->whereDate('checked_in_at', today())
            ->latest('checked_in_at')
            ->limit($limit)
            ->get();
    }

    public function getCheckInHistory(int $perPage = 20): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Ticket::checkedIn()
            ->whereNotNull('checked_in_at')
            ->latest('checked_in_at')
            ->paginate($perPage);
    }

    public function validateTicket(string $ticketCode): array
    {
        $ticketCode = trim(strtoupper($ticketCode));
        
        $ticket = Ticket::where('ticket_code', $ticketCode)->first();

        if (!$ticket) {
            $trashedTicket = Ticket::withTrashed()
                ->where('ticket_code', $ticketCode)
                ->first();
            
            if ($trashedTicket) {
                return [
                    'valid' => false,
                    'message' => 'Tiket ini sudah dihapus.',
                    'type' => 'deleted',
                    'ticket' => $trashedTicket,
                ];
            }
            
            return [
                'valid' => false,
                'message' => 'Tiket tidak ditemukan.',
                'type' => 'not_found',
            ];
        }

        // Auto-fix data inkonsisten
        $ticket->ensureDataConsistency();
        $ticket->refresh();

        if ($ticket->isUsed()) {
            return [
                'valid' => false,
                'message' => 'Tiket sudah digunakan.',
                'type' => 'already_used',
                'ticket' => $ticket,
            ];
        }

        return [
            'valid' => true,
            'message' => 'Tiket valid.',
            'type' => 'success',
            'ticket' => $ticket,
        ];
    }
}