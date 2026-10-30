<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Complaint extends Model
{
    public const STATUSES = ['baru', 'diproses', 'selesai', 'ditolak'];

    protected $fillable = [
        'ticket_number',
        'name',
        'student_id',
        'faculty',
        'email',
        'phone',
        'category',
        'subject',
        'message',
        'attachment_path',
        'is_anonymous',
        'status',
        'response',
        'responded_at',
        'ip_address',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_anonymous' => 'boolean',
            'responded_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Complaint $complaint): void {
            if (blank($complaint->ticket_number)) {
                $complaint->ticket_number = static::generateTicketNumber();
            }
        });
    }

    public static function generateTicketNumber(): string
    {
        do {
            $ticket = 'DPM-'.now()->format('ymd').'-'.Str::upper(Str::random(4));
        } while (static::query()->where('ticket_number', $ticket)->exists());

        return $ticket;
    }

    public function scopeOpen(Builder $query): Builder
    {
        return $query->whereIn('status', ['baru', 'diproses']);
    }

    public function getAttachmentUrlAttribute(): ?string
    {
        return $this->attachment_path ? asset($this->attachment_path) : null;
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'baru' => 'Baru',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
            default => ucfirst((string) $this->status),
        };
    }
}
