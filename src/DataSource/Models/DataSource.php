<?php
namespace Taecontrol\Histodata\DataSource\Models;

use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Taecontrol\Histodata\DataSource\DataTransferObjects\DataSourceDTO;
use Taecontrol\Histodata\Support\Traits\UsesUuid;

class DataSource extends Model
{
    use HasFactory;
    use UsesUuid;
    use QueryCacheable;

    protected static bool $flushCacheOnUpdate = true;

    protected $guarded = [];

    protected $casts = [
        'configuration' => 'array',
    ];

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

    public function getUpdatePeriodInSecondsAttribute(): int
    {
        return (int)CarbonInterval::fromString(
            "{$this->configuration['update_period']} {$this->configuration['update_period_type']}"
        )->totalSeconds;
    }
}
