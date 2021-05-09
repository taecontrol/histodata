<?php
namespace Taecontrol\Histodata\DataSource\Models;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Taecontrol\Histodata\DataPoint\Models\DataPoint;
use Taecontrol\Histodata\DataSource\DataTransferObjects\DataSourceDTO;

class DataSource extends Model
{
    use HasFactory;
    use QueryCacheable;

    protected static bool $flushCacheOnUpdate = true;

    protected $guarded = [];

    protected $casts = [
        'configuration' => 'array',
    ];

    public function dataPoints(): HasMany
    {
        return $this->hasMany(DataPoint::class);
    }

    public function getUpdatePeriodInSecondsAttribute(): int
    {
        return (int)CarbonInterval::fromString(
            "{$this->configuration['update_period']} {$this->configuration['update_period_type']}"
        )->totalSeconds;
    }

    public function getLastPoll(): mixed
    {
        return Cache::get("{$this->id}_last_poll_at");
    }

    public function getNextPoll(): mixed
    {
        return Cache::get("{$this->id}_next_poll_at");
    }

    public function setLastPoll(Carbon $timestamp): void
    {
        Cache::put("{$this->id}_last_poll_at", $timestamp);
    }

    public function setNextPoll(Carbon $timestamp): void
    {
        Cache::put("{$this->id}_next_poll_at", $timestamp);
    }

    /**
     * @throws UnknownProperties
     */
    public function toDTO(): DataSourceDTO
    {
        return new DataSourceDTO(
            id: $this->id,
            name: $this->name,
            enabled: $this->enabled,
            polling: $this->polling,
            configuration: $this->configuration
        );
    }
}
