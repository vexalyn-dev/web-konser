<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'concert_id',
        'ticket_code',
        'full_name',
        'email',
        'phone',
        'gender',
        'birth_date',
        'address',
        'city',
        'identity_number',
        'emergency_contact',
        'emergency_phone',
        'status',
        'checked_in_at',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'checked_in_at' => 'datetime',
        ];
    }

    // ============================================
    // FIX: Method untuk cek status dengan validasi
    // ============================================
    
    public function getGenderNameAttribute(): string
    {
        return match($this->gender) {
            'male' => 'Laki-laki',
            'female' => 'Perempuan',
            default => '-',
        };
    }

    public function getStatusNameAttribute(): string
    {
        return match($this->status) {
            'unused' => 'Belum Check In',
            'checked_in' => 'Sudah Check In',
            default => '-',
        };
    }

    /**
     * FIX: Cek apakah tiket sudah digunakan dengan validasi ganda
     * Cek status DAN checked_in_at untuk memastikan konsistensi
     */
    public function isUsed(): bool
    {
        // Validasi ganda: status harus checked_in DAN checked_in_at harus terisi
        return $this->status === 'checked_in' && $this->checked_in_at !== null;
    }

    public function isUnused(): bool
    {
        return !$this->isUsed();
    }

    // ============================================
    // Relationships
    // ============================================

    public function concert()
    {
        return $this->belongsTo(Concert::class);
    }

    /**
     * FIX: Auto-fix data inkonsisten saat dipanggil
     * Jika status = checked_in tapi checked_in_at null, atau sebaliknya
     */
    public function ensureDataConsistency(): void
    {
        $needsFix = false;
        $data = [];

        // Kasus 1: status = checked_in tapi checked_in_at null
        if ($this->status === 'checked_in' && $this->checked_in_at === null) {
            $data['checked_in_at'] = $this->updated_at ?? now();
            $needsFix = true;
        }

        // Kasus 2: status = unused tapi checked_in_at terisi
        if ($this->status === 'unused' && $this->checked_in_at !== null) {
            $data['checked_in_at'] = null;
            $needsFix = true;
        }

        if ($needsFix) {
            $this->update($data);
            Log::warning("Ticket data inconsistency auto-fixed: {$this->ticket_code}", $data);
        }
    }

    public function markAsCheckedIn(): bool
    {
        return $this->update([
            'status' => 'checked_in',
            'checked_in_at' => now(),
        ]);
    }

    public function resetToUnused(): bool
    {
        return $this->update([
            'status' => 'unused',
            'checked_in_at' => null,
        ]);
    }

    // Scopes
    public function scopeUnused(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('status', 'unused');
    }

    public function scopeCheckedIn(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('status', 'checked_in');
    }

    public function scopeToday(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->whereDate('checked_in_at', today());
    }

    public function scopeByCity(\Illuminate\Database\Eloquent\Builder $query, ?string $city): \Illuminate\Database\Eloquent\Builder
    {
        if ($city) {
            return $query->where('city', $city);
        }
        return $query;
    }

    public function scopeByStatus(\Illuminate\Database\Eloquent\Builder $query, ?string $status): \Illuminate\Database\Eloquent\Builder
    {
        if ($status) {
            return $query->where('status', $status);
        }
        return $query;
    }

    public function scopeSearch(\Illuminate\Database\Eloquent\Builder $query, ?string $search): \Illuminate\Database\Eloquent\Builder
    {
        if ($search) {
            return $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('ticket_code', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('identity_number', 'like', "%{$search}%");
            });
        }
        return $query;
    }

    public function scopeDateRange(\Illuminate\Database\Eloquent\Builder $query, ?string $from, ?string $to): \Illuminate\Database\Eloquent\Builder
    {
        if ($from) {
            $query->whereDate('created_at', '>=', $from);
        }
        if ($to) {
            $query->whereDate('created_at', '<=', $to);
        }
        return $query;
    }

    public static function getDistinctCities(): array
    {
        return self::select('city')
            ->distinct()
            ->orderBy('city')
            ->pluck('city')
            ->toArray();
    }

    public static function getStatistics(): array
    {
        return [
            'total' => self::count(),
            'checked_in' => self::checkedIn()->count(),
            'unused' => self::unused()->count(),
            'today' => self::today()->count(),
            'this_week' => self::where('created_at', '>=', now()->startOfWeek())->count(),
            'this_month' => self::where('created_at', '>=', now()->startOfMonth())->count(),
        ];
    }
}