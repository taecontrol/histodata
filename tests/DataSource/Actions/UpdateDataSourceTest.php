<?php

namespace Taecontrol\Histodata\Tests\DataSource\Actions;

use Taecontrol\Histodata\DataSource\Actions\UpdateDataSource;
use Taecontrol\Histodata\DataSource\Models\DataSource;
use Taecontrol\Histodata\Tests\TestCase;

class UpdateDataSourceTest extends TestCase
{
    /** @test */
    public function it_updates_given_data_source_in_the_db(): void
    {
        $dataSource = DataSource::factory()->create();

        $newDataSourceDTO = (new UpdateDataSource())->execute($dataSource, [
            'name' => 'New name'
        ]);

        $this->assertEquals('New name', $newDataSourceDTO->name);
    }
}
