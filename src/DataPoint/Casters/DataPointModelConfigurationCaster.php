<?php


namespace Taecontrol\Histodata\DataPoint\Casters;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Taecontrol\Histodata\DataPoint\Enums\DataPointModelType;

class DataPointModelConfigurationCaster implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        $valueCollection = collect(json_decode($value));
        $valueCollection['model_type'] = DataPointModelType::make($valueCollection['model_type']);

        return $valueCollection->toArray();
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return json_encode($value);
    }
}
