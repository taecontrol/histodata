<?php

namespace Taecontrol\Histodata\Commands;

use Illuminate\Console\Command;

class HistodataCommand extends Command
{
    public $signature = 'histodata';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
