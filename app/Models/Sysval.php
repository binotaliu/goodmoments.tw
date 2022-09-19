<?php

namespace App\Models;

use App\Enums\SysvalKey;
use App\Models\Concerns\HasAttachments;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * @mixin IdeHelperSysval
 */
final class Sysval extends Model
{
    use HasAttachments;

    public const CACHE_PREFIX = 'sysval:';
    public const CACHE_EXPIRES_SECONDS = 60 * 60 * 24 * 7;

    protected $primaryKey = 'key';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'key',
        'value',
    ];

    protected $casts = [
        'value' => 'json',
    ];

    public static function get(SysvalKey $key, mixed $default = null): mixed
    {
        return Cache::remember(
            self::CACHE_PREFIX . $key->value,
            now()->addSeconds(self::CACHE_EXPIRES_SECONDS),
            static fn () => static::where('key', $key->value)->value('value'),
        ) ?? $default;
    }

    public static function set(SysvalKey $key, mixed $value): mixed
    {
        $sysval = static::firstOrNew(['key' => $key->value]);
        $sysval->value = $value;
        $sysval->save();

        Cache::forget(self::CACHE_PREFIX . $key->value);

        return $value;
    }

    public function scopeOfKey(Builder $query, SysvalKey $key): Builder
    {
        return $query->where('key', $key->value);
    }
}
