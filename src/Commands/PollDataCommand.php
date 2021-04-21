<?php

namespace Taecontrol\Histodata\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Taecontrol\Histodata\DataSource\Jobs\PollData;
use Taecontrol\Histodata\DataSource\Models\DataSource;

class PollDataCommand extends Command
{
    public $signature = 'histodata:poll
                        {dataSource? : The Id of the data source}';

    public $description = 'Poll data source data';

    public function handle(): void
    {
        if ($dataSourceId = $this->argument('dataSource')) {
            $this->pollDataSourceData($dataSourceId);
        } else {
            $dataSources = DataSource::query()
                ->where('polling', true)
                ->where('enabled', true)
                ->get();

            $dataSources->each(function (DataSource $dataSource) {
                $this->pollDataSourcesData($dataSource);
            });
        }
    }

    protected function pollDataSourceData(string $dataSourceId): void
    {
        $dataSource = DataSource::query()
            ->findOrFail($dataSourceId);

        PollData::dispatch($dataSource);
    }

    protected function pollDataSourcesData(DataSource $dataSource): void
    {
        if ($nextPoll = Cache::get("{$dataSource->id}_next_poll_at")) {
            if (now()->gte($nextPoll)) {
                PollData::dispatch($dataSource);
            }
        } else {
            PollData::dispatch($dataSource);
        }
    }
}
