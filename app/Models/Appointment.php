<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'service_id',
        'service_name',
        'vehicle_type',
        'vehicle_year',
        'vehicle_make',
        'vehicle_model',
        'tire_size',
        'preferred_date',
        'preferred_time',
        'message',
        'status',
        'is_read',
        'notes',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'preferred_date' => 'date',
        'is_read' => 'boolean',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
