<?php

namespace Taecontrol\Histodata\Tests\DataSource\Jobs;

use Illuminate\Support\Facades\Cache;
use Mockery\MockInterface;
use Taecontrol\Histodata\DataSource\Jobs\PollData;
use Taecontrol\Histodata\DataSource\Models\DataSource;
use Taecontrol\Histodata\Tests\TestCase;
use Taecontrol\Histodata\VirtualDataSource\VirtualDataSourceHandler;

class PollDataTest extends TestCase
{
    /** @test */
    public function it_does_a_poll_for_a_given_data_source(): void
    {
        $this->mock(VirtualDataSourceHandler::class, function (MockInterface $mock) {
            $mock->shouldReceive('executePoll')->once();
        });

        $dataSource = DataSource::factory()->create();

        PollData::dispatch($dataSource);

        $this->assertTrue(Cache::get("{$dataSource->id}_next_poll_at")->gt(now()));
        $this->assertTrue((bool)Cache::get("{$dataSource->id}_last_poll_at"));
    }
}
