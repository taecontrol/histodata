<?php

namespace Taecontrol\Histodata\Tests\Commands;

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
}
