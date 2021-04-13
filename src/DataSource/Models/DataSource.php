<?php
namespace Taecontrol\Histodata\DataSource\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Taecontrol\Histodata\DataSource\DataTransferObjects\DataSourceDTO;
use Taecontrol\Histodata\Support\Traits\UsesUuid;

class DataSource extends Model
{
    use HasFactory;
    use UsesUuid;

    protected $guarded = [];

    protected $casts = [
        'configuration' => 'array'
    ];

    /**
     * @throws UnknownProperties
     */
    public function toDTO(): DataSourceDTO
    {
        return new DataSourceDTO(
            id: $this->id,
            name: $this->name,
            configuration: $this->configuration
        );
    }
}
