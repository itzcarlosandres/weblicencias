<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value', 'group'];

    protected static ?array $loadedSettings = null;

    public static function get(string $key, $default = null)
    {
        if (self::$loadedSettings === null) {
            try {
                self::$loadedSettings = Cache::rememberForever('settings_all_dict', function () {
                    return static::pluck('value', 'key')->toArray();
                });
            } catch (\Exception $e) {
                // Fallback for migrations or db issues
                return $default;
            }
        }
        return self::$loadedSettings[$key] ?? $default;
    }

    public static function set(string $key, $value, string $group = 'general'): void
    {
        static::updateOrCreate(['key' => $key], [
            'value' => $value,
            'group' => $group,
        ]);
        self::clearCache();
    }

    public static function getGroup(string $group): array
    {
        try {
            return Cache::rememberForever("settings_group_{$group}", function () use ($group) {
                return static::where('group', $group)->pluck('value', 'key')->toArray();
            });
        } catch (\Exception $e) {
            return [];
        }
    }

    public static function clearCache(): void
    {
        self::$loadedSettings = null;
        Cache::forget('settings_all_dict');
        $groups = ['general', 'seo', 'appearance', 'points', 'payment', 'ai', 'emails'];
        foreach ($groups as $g) {
            Cache::forget("settings_group_{$g}");
        }
    }
}
