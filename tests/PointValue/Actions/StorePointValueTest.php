<?php

namespace Taecontrol\Histodata\Tests\PointValue\Actions;

use Mockery\MockInterface;
use Taecontrol\Histodata\Database\Factories\AlphanumericPointValueFactory;
use Taecontrol\Histodata\Database\Factories\BinaryPointValueFactory;
use Taecontrol\Histodata\Database\Factories\NumericPointValueFactory;
use Taecontrol\Histodata\DataPoint\Models\DataPoint;
use Taecontrol\Histodata\PointValue\Actions\StoreAlphanumericPointValue;
use Taecontrol\Histodata\PointValue\Actions\StoreBinaryPointValue;
use Taecontrol\Histodata\PointValue\Actions\StoreNumericPointValue;
use Taecontrol\Histodata\PointValue\Actions\StorePointValue;
use Taecontrol\Histodata\PointValue\Enums\PointValueType;
use Taecontrol\Histodata\Tests\TestCase;

class StorePointValueTest extends TestCase
{
    private StorePointValue $action;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(StorePointValue::class);
    }

    /** @test */
    public function it_calls_store_numeric_point_value_action(): void
    {
        $this->mock(StoreNumericPointValue::class, function (MockInterface $mock) {
            $mock->shouldReceive('execute')->once();
        });

        $dataPoint = DataPoint::factory()->create([
            'data_type' => PointValueType::NUMERIC(),
        ]);

        $data = (new NumericPointValueFactory())->dto([
            'data_point_id' => $dataPoint->id,
        ])->toArray();

        $this->action->execute($data);
    }

    /** @test */
    public function it_calls_store_alphanumeric_point_value_action(): void
    {
        $this->mock(StoreAlphanumericPointValue::class, function (MockInterface $mock) {
            $mock->shouldReceive('execute')->once();
        });

        $dataPoint = DataPoint::factory()->create([
            'data_type' => PointValueType::ALPHANUMERIC(),
        ]);

        $data = (new AlphanumericPointValueFactory())->dto([
            'data_point_id' => $dataPoint->id,
        ])->toArray();

        $this->action->execute($data);
    }

    /** @test */
    public function it_calls_store_binary_point_value_action(): void
    {
        $this->mock(StoreBinaryPointValue::class, function (MockInterface $mock) {
            $mock->shouldReceive('execute')->once();
        });

        $dataPoint = DataPoint::factory()->create([
            'data_type' => PointValueType::BINARY(),
        ]);

        $data = (new BinaryPointValueFactory())->dto([
            'data_point_id' => $dataPoint->id,
        ])->toArray();

        $this->action->execute($data);
    }
}
