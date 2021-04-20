<?php
namespace Taecontrol\Histodata\DataPoint\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Taecontrol\Histodata\DataPoint\DataTransferObjects\DataPointDTO;
use Taecontrol\Histodata\PointValue\Enums\PointValueType;
use Taecontrol\Histodata\Support\Traits\UsesUuid;

class DataPoint extends Model
{
    use HasFactory;
    use UsesUuid;
    use QueryCacheable;

    protected static bool $flushCacheOnUpdate = true;

    protected $guarded = [];

    protected $casts = [
        'data_type' => PointValueType::class,
        'configuration' => 'array',
    ];

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
