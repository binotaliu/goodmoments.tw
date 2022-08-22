<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * @mixin IdeHelperSysval
 */
final class Sysval extends Model
{
    public const CACHE_PREFIX = 'sysval:';
    public const CACHE_EXPIRES_SECONDS = 60 * 60 * 24 * 7;

    protected $primaryKey = 'key';
    public $incrementing = false;
    public $timestamps = false;

    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::remember(
            self::CACHE_PREFIX . base64_url_encode($key),
            now()->addSeconds(self::CACHE_EXPIRES_SECONDS),
            static fn () => static::where('key', $key)->value('value'),
        ) ?? $default;
    }

    public static function set(string $key, mixed $value): mixed
    {
        $sysval = static::firstOrNew(['key' => $key]);
        $sysval->value = $value;
        $sysval->save();

        Cache::forget(self::CACHE_PREFIX . base64_url_encode($key));
        return $value;
    }
}
