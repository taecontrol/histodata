<?php

namespace Taecontrol\Histodata\Commands;

use Carbon\CarbonInterval;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
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

        $dataSourceDTO = $dataSource->toDTO();

        PollData::dispatch($dataSourceDTO);
    }

    /**
     * @throws UnknownProperties
     */
    protected function pollDataSourcesData(DataSource $dataSource): void
    {
        if ($lastPoll = Cache::get("{$dataSource->id}_last_poll_at")) {
            $secondsSinceLastPoll = CarbonInterval::make($lastPoll->diff(now()))->totalSeconds;

            if ($secondsSinceLastPoll >= $this->getDataSourceUpdatePeriodInSeconds($dataSource)) {
                PollData::dispatch($dataSource->toDTO());
            }
        } else {
            PollData::dispatch($dataSource->toDTO());
        }
    }

    protected function getDataSourceUpdatePeriodInSeconds(DataSource $dataSource): float
    {
        return CarbonInterval::fromString(
            "{$dataSource->configuration['update_period']} {$dataSource->configuration['update_period_type']}"
        )->totalSeconds;
    }
}
