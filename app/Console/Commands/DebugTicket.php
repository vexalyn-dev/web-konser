<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use Illuminate\Console\Command;

class DebugTicket extends Command
{
    protected $signature = 'ticket:debug {code?} {--fix : Auto-fix inconsistent data}';
    protected $description = 'Debug ticket status dan konsistensi data';

    public function handle()
    {
        $code = $this->argument('code');
        $fixMode = $this->option('fix');

        if (!$code) {
            // Tampilkan summary semua tiket
            $this->info("\n📊 TICKET STATUS SUMMARY\n");
            
            $total = Ticket::count();
            $unused = Ticket::where('status', 'unused')->count();
            $checkedIn = Ticket::where('status', 'checked_in')->count();
            
            // Cek inkonsistensi
            $inconsistent1 = Ticket::where('status', 'checked_in')
                ->whereNull('checked_in_at')
                ->count();
            $inconsistent2 = Ticket::where('status', 'unused')
                ->whereNotNull('checked_in_at')
                ->count();
            
            $this->table(
                ['Metric', 'Count'],
                [
                    ['Total Tickets', $total],
                    ['Status: UNUSED', $unused],
                    ['Status: CHECKED_IN', $checkedIn],
                    ['⚠️  Inconsistent (checked_in tapi checked_in_at NULL)', $inconsistent1],
                    ['⚠️  Inconsistent (unused tapi checked_in_at terisi)', $inconsistent2],
                ]
            );
            
            if (($inconsistent1 + $inconsistent2) > 0) {
                $this->warn("\n⚠️  Ditemukan data inkonsisten!");
                $this->line("Jalankan: php artisan ticket:debug --fix");
            } else {
                $this->info("\n✅ Semua data konsisten!");
            }
            
            return 0;
        }

        // Debug tiket spesifik
        $code = strtoupper(trim($code));
        $this->info("\n🔍 DEBUGGING TICKET: {$code}\n");
        
        $ticket = Ticket::withTrashed()->where('ticket_code', $code)->first();
        
        if (!$ticket) {
            $this->error("❌ Tiket tidak ditemukan: {$code}");
            return 1;
        }
        
        $data = [
            ['Field', 'Value'],
            ['ID', $ticket->id],
            ['Ticket Code', $ticket->ticket_code],
            ['Full Name', $ticket->full_name],
            ['Email', $ticket->email],
            ['Status', $ticket->status],
            ['Checked In At', $ticket->checked_in_at ?? 'NULL'],
            ['Created At', $ticket->created_at],
            ['Updated At', $ticket->updated_at],
            ['Deleted At', $ticket->deleted_at ?? 'NULL'],
            ['isUsed() returns', $ticket->isUsed() ? 'TRUE' : 'FALSE'],
        ];
        
        $this->table(['Field', 'Value'], $data);
        
        // Cek konsistensi
        $isConsistent = true;
        if ($ticket->status === 'checked_in' && $ticket->checked_in_at === null) {
            $this->warn("⚠️  INCONSISTENT: status = checked_in tapi checked_in_at = NULL");
            $isConsistent = false;
        }
        if ($ticket->status === 'unused' && $ticket->checked_in_at !== null) {
            $this->warn("⚠️  INCONSISTENT: status = unused tapi checked_in_at terisi");
            $isConsistent = false;
        }
        
        if ($isConsistent) {
            $this->info("✅ Data konsisten");
        }
        
        // Auto-fix
        if ($fixMode && !$isConsistent) {
            $this->info("\n🔧 Auto-fixing...");
            $ticket->ensureDataConsistency();
            $this->info("✅ Fixed!");
        }
        
        return 0;
    }
}