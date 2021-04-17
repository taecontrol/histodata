<?php

namespace Taecontrol\Histodata\Tests\DataSource\Actions;

use Taecontrol\Histodata\DataSource\Actions\DeleteDataSource;
use Taecontrol\Histodata\DataSource\Models\DataSource;
use Taecontrol\Histodata\Tests\TestCase;

class DeleteDataSourceTest extends TestCase
{
    /** @test */
    public function it_deletes_data_source_from_db(): void
    {
        $dataSource = DataSource::factory()->create();

        (new DeleteDataSource())->execute($dataSource);

        $this->assertDeleted($dataSource);
    }
}
