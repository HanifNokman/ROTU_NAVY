<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class ContentSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'description',
    ];

    /**
     * Get a setting value by key with caching
     */
    public static function get(string $key, $default = null)
    {
        return Cache::remember("content_setting_{$key}", 3600, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set a setting value by key
     */
    public static function set(string $key, $value, string $type = 'text', string $description = null): self
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'description' => $description,
            ]
        );

        // Clear cache
        Cache::forget("content_setting_{$key}");
        Cache::forget('all_content_settings');

        return $setting;
    }

    /**
     * Check if application deadline banner should be shown
     */
    public static function shouldShowDeadlineBanner(): bool
    {
        $deadline = self::get('application_deadline');
        
        if (!$deadline) {
            return false;
        }

        $deadlineDate = Carbon::parse($deadline);
        $today = Carbon::today();
        $oneMonthBefore = $deadlineDate->copy()->subMonth();
        $oneDayAfter = $deadlineDate->copy()->addDay();

        return $today->between($oneMonthBefore, $oneDayAfter);
    }

    /**
     * Get formatted deadline for display
     */
    public static function getFormattedDeadline(): ?string
    {
        $deadline = self::get('application_deadline');
        
        if (!$deadline) {
            return null;
        }

        return Carbon::parse($deadline)->format('F j, Y');
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache(): void
    {
        Cache::forget('all_content_settings');
        
        $keys = self::pluck('key');
        foreach ($keys as $key) {
            Cache::forget("content_setting_{$key}");
        }
    }

    /**
     * Boot method to clear cache on model events
     */
    protected static function boot()
    {
        parent::boot();

        static::saved(function () {
            self::clearCache();
        });

        static::deleted(function () {
            self::clearCache();
        });
    }
}