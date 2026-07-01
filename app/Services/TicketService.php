<?php

namespace App\Services;

use App\Models\Ticket;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TicketService
{
    /**
     * Generate unique ticket code
     * Format: AGX-YYYY-NNNNNN (e.g., AGX-2026-000001)
     */
    public function generateTicketCode(): string
    {
        $year = date('Y');
        $prefix = "AGX-{$year}-";

        // Use database transaction to prevent race conditions
        return DB::transaction(function () use ($year, $prefix) {
            // Get the highest ticket number for this year
            $lastTicket = Ticket::withTrashed()
                ->where('ticket_code', 'like', "{$prefix}%")
                ->orderByRaw("CAST(SUBSTRING(ticket_code, -6) AS UNSIGNED) DESC")
                ->first();

            $nextNumber = $lastTicket
                ? ((int) substr($lastTicket->ticket_code, -6)) + 1
                : 1;

            return $prefix . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
        });
    }

    /**
     * Create a new ticket
     */
    public function createTicket(array $data): Ticket
    {
        try {
            return DB::transaction(function () use ($data) {
                $data['ticket_code'] = $this->generateTicketCode();
                $data['status'] = 'unused';

                $ticket = Ticket::create($data);

                // Log the activity
                if (auth()->check()) {
                    \App\Models\ActivityLog::log(
                        action: 'create',
                        description: "Created ticket {$ticket->ticket_code} for {$ticket->full_name}",
                        modelType: Ticket::class,
                        modelId: $ticket->id,
                        properties: ['ticket_code' => $ticket->ticket_code]
                    );
                }

                return $ticket;
            });
        } catch (\Throwable $e) {
            Log::error('Failed to create ticket: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update an existing ticket
     */
    public function updateTicket(Ticket $ticket, array $data): Ticket
    {
        try {
            return DB::transaction(function () use ($ticket, $data) {
                $ticket->update($data);

                // Log the activity
                if (auth()->check()) {
                    \App\Models\ActivityLog::log(
                        action: 'update',
                        description: "Updated ticket {$ticket->ticket_code}",
                        modelType: Ticket::class,
                        modelId: $ticket->id
                    );
                }

                return $ticket->fresh();
            });
        } catch (\Throwable $e) {
            Log::error('Failed to update ticket: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete a ticket (soft delete)
     */
    public function deleteTicket(Ticket $ticket): bool
    {
        try {
            return DB::transaction(function () use ($ticket) {
                $ticketCode = $ticket->ticket_code;
                $result = $ticket->delete();

                // Log the activity
                if (auth()->check()) {
                    \App\Models\ActivityLog::log(
                        action: 'delete',
                        description: "Deleted ticket {$ticketCode}",
                        modelType: Ticket::class,
                        modelId: $ticket->id
                    );
                }

                return $result;
            });
        } catch (\Throwable $e) {
            Log::error('Failed to delete ticket: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Bulk delete tickets
     */
    public function bulkDelete(array $ids): int
    {
        try {
            return DB::transaction(function () use ($ids) {
                $count = Ticket::whereIn('id', $ids)->delete();

                // Log the activity
                if (auth()->check()) {
                    \App\Models\ActivityLog::log(
                        action: 'delete',
                        description: "Bulk deleted {$count} tickets",
                        properties: ['ids' => $ids, 'count' => $count]
                    );
                }

                return $count;
            });
        } catch (\Throwable $e) {
            Log::error('Failed to bulk delete tickets: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Restore a soft-deleted ticket
     */
    public function restoreTicket(int $id): ?Ticket
    {
        try {
            return DB::transaction(function () use ($id) {
                $ticket = Ticket::withTrashed()->findOrFail($id);
                $ticket->restore();

                // Log the activity
                if (auth()->check()) {
                    \App\Models\ActivityLog::log(
                        action: 'restore',
                        description: "Restored ticket {$ticket->ticket_code}",
                        modelType: Ticket::class,
                        modelId: $ticket->id
                    );
                }

                return $ticket;
            });
        } catch (\Throwable $e) {
            Log::error('Failed to restore ticket: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get distinct cities from tickets
     */
    public function getCities(): array
    {
        return Ticket::select('city')
            ->distinct()
            ->orderBy('city')
            ->pluck('city')
            ->toArray();
    }

    /**
     * Get dashboard statistics
     */
    public function getStatistics(): array
    {
        return [
            'total' => Ticket::count(),
            'checked_in' => Ticket::checkedIn()->count(),
            'unused' => Ticket::unused()->count(),
            'today' => Ticket::today()->count(),
            'this_week' => Ticket::where('created_at', '>=', now()->startOfWeek())->count(),
            'this_month' => Ticket::where('created_at', '>=', now()->startOfMonth())->count(),
        ];
    }

    /**
     * Get chart data for last N days
     */
    public function getChartData(int $days = 7): array
    {
        $data = [
            'labels' => [],
            'registrations' => [],
            'checkins' => [],
        ];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dateStr = $date->format('Y-m-d');

            $data['labels'][] = $date->format('d M');
            $data['registrations'][] = Ticket::whereDate('created_at', $dateStr)->count();
            $data['checkins'][] = Ticket::whereDate('checked_in_at', $dateStr)->count();
        }

        return $data;
    }

    /**
     * Get city distribution for chart
     */
    public function getCityDistribution(int $limit = 5): Collection
    {
        return Ticket::select('city', DB::raw('count(*) as count'))
            ->groupBy('city')
            ->orderByDesc('count')
            ->limit($limit)
            ->get();
    }

    /**
     * Get recent tickets
     */
    public function getRecentTickets(int $limit = 5): Collection
    {
        return Ticket::latest()->limit($limit)->get();
    }

    /**
     * Find ticket by code
     */
    public function findByCode(string $code): ?Ticket
    {
        return Ticket::where('ticket_code', $code)->first();
    }
}