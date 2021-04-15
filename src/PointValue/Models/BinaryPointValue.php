<?php

namespace Taecontrol\Histodata\PointValue\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Taecontrol\Histodata\Timescale\Models\TimescaleModel;

class BinaryPointValue extends TimescaleModel
{
    use HasFactory;

    protected $guarded = [];
}
