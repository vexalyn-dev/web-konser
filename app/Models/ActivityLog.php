<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'description',
        'properties',
        'ip_address',
        'user_agent',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'properties' => 'array',
        ];
    }

    /**
     * Relationship: User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: Subject (polymorphic)
     */
    public function subject()
    {
        return $this->morphTo(null, 'model_type', 'model_id');
    }

    /**
     * Get action icon
     */
    public function getActionIconAttribute(): string
    {
        return match ($this->action) {
            'login' => 'login',
            'logout' => 'logout',
            'create' => 'plus-circle',
            'update' => 'edit',
            'delete' => 'trash-2',
            'check_in' => 'check-circle',
            'restore' => 'refresh-cw',
            'export' => 'download',
            default => 'activity',
        };
    }

    /**
     * Get action color
     */
    public function getActionColorAttribute(): string
    {
        return match ($this->action) {
            'login' => 'blue',
            'logout' => 'gray',
            'create' => 'green',
            'update' => 'yellow',
            'delete' => 'red',
            'check_in' => 'emerald',
            'restore' => 'purple',
            'export' => 'indigo',
            default => 'slate',
        };
    }

    /**
     * Scope: By user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope: By action
     */
    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope: Recent activities
     */
    public function scopeRecent($query, $limit = 10)
    {
        return $query->latest()->limit($limit);
    }

    /**
     * Log activity helper
     */
    public static function log(
        string $action,
        ?string $description = null,
        ?int $userId = null,
        ?string $modelType = null,
        ?int $modelId = null,
        ?array $properties = null
    ): self {
        return self::create([
            'user_id' => $userId ?? auth()->id(),
            'action' => $action,
            'description' => $description,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'properties' => $properties,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}