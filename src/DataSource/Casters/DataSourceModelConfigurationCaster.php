<?php


namespace Taecontrol\Histodata\DataSource\Casters;


use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Taecontrol\Histodata\DataSource\Enums\DataSourceModelType;

class DataSourceModelConfigurationCaster implements CastsAttributes
{

    public function get($model, string $key, $value, array $attributes)
    {
        $valueCollection = collect(json_decode($value));
        $valueCollection['model_type'] = DataSourceModelType::make($valueCollection['model_type']);

        return $valueCollection->toArray();
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return json_encode($value);
    }
}