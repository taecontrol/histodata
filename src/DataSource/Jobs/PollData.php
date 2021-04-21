<?php


namespace Taecontrol\Histodata\DataSource\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Taecontrol\Histodata\DataSource\Models\DataSource;
use Taecontrol\Histodata\DataSource\Support\PollingDataSourceHandler;
use Taecontrol\Histodata\Facades\Histodata;

class PollData implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public DataSource $dataSource;
    protected PollingDataSourceHandler $dataSourceHandler;

    public function __construct(DataSource $dataSource)
    {
        $this->dataSource = $dataSource;
    }

    /**
     * @throws UnknownProperties
     */
    public function handle(): void
    {
        Cache::put(
            "{$this->dataSource->id}_next_poll_at",
            now()->addSeconds($this->dataSource->updatePeriodInSeconds)
        );
        $modelType = $this->dataSource->toDTO()->configuration->model_type;

        if (Histodata::dataSourceTypesContain($modelType)) {
            $dataSourceHandlerClass = Histodata::getDataSourceHandlerClass($modelType);

            $this->dataSourceHandler = app($dataSourceHandlerClass);
            $this->dataSourceHandler->executePoll($this->dataSource);
            Cache::put("{$this->dataSource->id}_last_poll_at", now());
        }
    }
}
