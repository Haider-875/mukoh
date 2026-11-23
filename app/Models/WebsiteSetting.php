<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
        'type',
        'label',
        'description',
    ];

    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();
        if (!$setting) {
            return $default;
        }

        return match ($setting->type) {
            'boolean' => filter_var($setting->value, FILTER_VALIDATE_BOOLEAN),
            'number' => is_numeric($setting->value) ? (float) $setting->value : $default,
            'json' => json_decode($setting->value, true) ?: $default,
            default => $setting->value ?? $default,
        };
    }

    public static function set(string $key, mixed $value, string $group = 'general', string $type = 'text', ?string $label = null): static
    {
        $stringValue = match ($type) {
            'boolean' => $value ? '1' : '0',
            'json' => is_array($value) ? json_encode($value) : (string) $value,
            default => (string) $value,
        };

        return static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $stringValue,
                'group' => $group,
                'type' => $type,
                'label' => $label ?? ucfirst(str_replace('_', ' ', $key)),
            ]
        );
    }
}
