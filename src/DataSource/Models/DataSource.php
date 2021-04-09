<?php
namespace Taecontrol\Histodata\DataSource\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Taecontrol\Histodata\DataSource\Casters\DataSourceModelConfigurationCaster;
use Taecontrol\Histodata\Support\Traits\UsesUuid;

class DataSource extends Model
{
    use HasFactory;
    use UsesUuid;

    protected $guarded = [];

    protected $casts = [
        'configuration' => DataSourceModelConfigurationCaster::class,
    ];
}
