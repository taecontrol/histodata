<?php

namespace Taecontrol\Histodata\Tests\Commands;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Queue;
use Taecontrol\Histodata\DataSource\Jobs\PollData;
use Taecontrol\Histodata\DataSource\Models\DataSource;
use Taecontrol\Histodata\Tests\TestCase;

class PollDataCommandTest extends TestCase
{
    /** @test */
    public function it_can_poll_data_from_given_data_source_id(): void
    {
        Queue::fake();

        $dataSource = DataSource::factory()->create();

        $this->artisan("histodata:poll {$dataSource->id}");

        Queue::assertPushed(function (PollData $job) use ($dataSource) {
            return $job->dataSourceDTO->id === $dataSource->id;
        });
    }

    /** @test */
    public function it_polls_data_sources_data(): void
    {
        Queue::fake();

        $oneMinDataSources = DataSource::factory()->count(2)->create([
            'configuration' => [
                'model_type' => 'VIRTUAL',
                'update_period' => 1,
                'update_period_type' => 'MINUTES',
            ],
        ]);

        $oneSecDataSource = DataSource::factory()->create();

        $oneMinDataSources->each(
            fn (DataSource $dataSource) => Cache::put("{$dataSource->id}_last_poll_at", now()->subMinutes(2))
        );

        Cache::put("{$oneSecDataSource->id}_last_poll_at", now());

        $this->artisan('histodata:poll');

        Queue::assertPushed(PollData::class, 2);
    }

    /** @test */
    public function it_polls_polling_data_sources_for_the_first_time_data(): void
    {
        Queue::fake();

        DataSource::factory()->count(2)->create([
            'configuration' => [
                'model_type' => 'VIRTUAL',
                'update_period' => 1,
                'update_period_type' => 'MINUTES'
            ]
        ]);

        $this->artisan('histodata:poll');

        Queue::assertPushed(PollData::class, 2);
    }

    /** @test */
    public function it_polls_only_enabled_data_sources(): void
    {
        Queue::fake();

        $config = [
            'model_type' => 'VIRTUAL',
            'update_period' => 1,
            'update_period_type' => 'MINUTES'
        ];

        DataSource::factory()->count(2)->create([
            'configuration' => $config
        ]);

        DataSource::factory()->count(2)->create([
            'enabled' => false,
            'configuration' => $config
        ]);

        $this->artisan('histodata:poll');

        Queue::assertPushed(PollData::class, 2);
    }

    /** @test */
    public function it_polls_only_polling_data_sources_data(): void
    {
        Queue::fake();

        $config = [
            'model_type' => 'VIRTUAL',
            'update_period' => 1,
            'update_period_type' => 'MINUTES'
        ];

        $pollingDataSources = DataSource::factory()->count(2)->create([
            'configuration' => $config
        ]);

        DataSource::factory()->count(2)->create([
            'polling' => false,
            'configuration' => $config
        ]);

        $pollingDataSources->each(
            fn(DataSource $dataSource) => Cache::put("{$dataSource->id}_last_poll_at", now()->subMinutes(2))
        );

        $this->artisan('histodata:poll');

        Queue::assertPushed(PollData::class, 2);
    }
}
