<?php
namespace Taecontrol\Histodata\DataPoint\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Taecontrol\Histodata\DataPoint\DataTransferObjects\DataPointDTO;
use Taecontrol\Histodata\DataSource\Models\DataSource;
use Taecontrol\Histodata\PointValue\Enums\PointValueType;
use Taecontrol\Histodata\PointValue\Models\AlphanumericPointValue;
use Taecontrol\Histodata\PointValue\Models\BinaryPointValue;
use Taecontrol\Histodata\PointValue\Models\NumericPointValue;

class DataPoint extends Model
{
    use HasFactory;
    use QueryCacheable;

    protected static bool $flushCacheOnUpdate = true;

    protected $guarded = [];

    protected $casts = [
        'data_type' => PointValueType::class,
        'configuration' => 'array',
    ];

    public function dataSource(): BelongsTo
    {
        return $this->belongsTo(DataSource::class);
    }

    public function parent(): MorphTo
    {
        return $this->morphTo();
    }

    public function lastPointValue(): Builder | Model | null
    {
        if (PointValueType::NUMERIC()->equals($this->data_type)) {
            return NumericPointValue::query()
                ->where('data_point_id', $this->id)
                ->latest('timestamp')
                ->limit(1)
                ->first();
        }

        if (PointValueType::ALPHANUMERIC()->equals($this->data_type)) {
            return AlphanumericPointValue::query()
                ->where('data_point_id', $this->id)
                ->latest('timestamp')
                ->limit(1)
                ->first();
        }

        return BinaryPointValue::query()
            ->where('data_point_id', $this->id)
            ->latest('timestamp')
            ->limit(1)
            ->first();
    }

    /**
     * @throws UnknownProperties
     */
    public function toDTO(): DataPointDTO
    {
        return new DataPointDTO(
            id: $this->id,
            name: $this->name,
            enabled: $this->enabled,
            data_source_id: $this->data_source_id,
            data_type: $this->data_type,
            configuration: $this->configuration
        );
    }
}
