<?php

namespace Taecontrol\Histodata\Commands;

use Illuminate\Console\Command;
use Taecontrol\Histodata\DataSource\Jobs\PollData;
use Taecontrol\Histodata\DataSource\Models\DataSource;

class PollDataCommand extends Command
{
    public $signature = 'histodata:poll
                        {dataSource : The Id of the data source}';

    public $description = 'Poll data source data';

    public function handle(): void
    {
        $dataSourceId = $this->argument('dataSource');

        $dataSourceDTO = DataSource::query()
            ->findOrFail($dataSourceId)
            ->toDTO();

        PollData::dispatch($dataSourceDTO);
    }
}
