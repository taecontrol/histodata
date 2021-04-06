<?php
namespace Taecontrol\Histodata\DataSource\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Taecontrol\Histodata\Support\Traits\UsesUuid;

class DataSource extends Model
{
    use HasFactory, UsesUuid;
}