<?php
namespace Taecontrol\Histodata\DataPoint\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Taecontrol\Histodata\DataPoint\Casters\DataPointModelConfigurationCaster;
use Taecontrol\Histodata\Support\Traits\UsesUuid;

class DataPoint extends Model
{
    use HasFactory;
    use UsesUuid;

    protected $guarded = [];

    protected $casts = [
        'configuration' => DataPointModelConfigurationCaster::class,
    ];
}
