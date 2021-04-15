<?php


namespace Taecontrol\Histodata\DataSource\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Taecontrol\Histodata\DataSource\DataTransferObjects\DataSourceDTO;
use Taecontrol\Histodata\DataSource\Support\PollingDataSourceHandler;
use Taecontrol\Histodata\Facades\Histodata;

class PollData implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected DataSourceDTO $dataSourceDTO;
    protected PollingDataSourceHandler $dataSourceHandler;

    public function __construct(DataSourceDTO $dataSourceDTO)
    {
        $this->dataSourceDTO = $dataSourceDTO;
    }

    public function handle(): void
    {
        $modelType = $this->dataSourceDTO->configuration->model_type;

        if (Histodata::dataSourceTypesContain($modelType)) {
            $dataSourceHandlerClass = Histodata::getDataSourceHandlerClass($modelType);

            $this->dataSourceHandler = app($dataSourceHandlerClass);
            $this->dataSourceHandler->executePoll($this->dataSourceDTO);
        }
    }
}
