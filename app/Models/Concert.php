<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Concert extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'venue',
        'location',
        'start_date',
        'end_date',
        'ticket_sales_start',
        'ticket_sales_end',
        'capacity',
        'tickets_sold',
        'ticket_price',
        'image',
        'status',
        'lineup',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'ticket_sales_start' => 'datetime',
            'ticket_sales_end' => 'datetime',
            'lineup' => 'array',
            'ticket_price' => 'decimal:2',
        ];
    }

    // Auto-generate slug
    public static function boot()
    {
        parent::boot();

        static::creating(function ($concert) {
            if (empty($concert->slug)) {
                $concert->slug = Str::slug($concert->name) . '-' . Str::random(5);
            }
        });
    }

    // Relationships
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    // Accessors
    public function getAvailableTicketsAttribute(): int
    {
        return max(0, $this->capacity - $this->tickets_sold);
    }

    public function getIsSoldOutAttribute(): bool
    {
        return $this->tickets_sold >= $this->capacity;
    }

    public function getIsOngoingAttribute(): bool
    {
        return now()->between($this->start_date, $this->end_date ?? $this->start_date->addHours(4));
    }

    public function getIsUpcomingAttribute(): bool
    {
        return $this->start_date->isFuture();
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'published' => 'bg-blue-100 text-blue-800',
            'ongoing' => 'bg-green-100 text-green-800',
            'completed' => 'bg-gray-100 text-gray-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-yellow-100 text-yellow-800',
        };
    }

    public function getStatusNameAttribute(): string
    {
        return match ($this->status) {
            'draft' => 'Draft',
            'published' => 'Dipublikasikan',
            'ongoing' => 'Berlangsung',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => 'Unknown',
        };
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', now())->where('status', 'published');
    }

    public function scopeOngoing($query)
    {
        return $query->where('status', 'ongoing');
    }
}