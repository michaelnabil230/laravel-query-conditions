<?php

namespace MichaelNabil230\LaravelConditionQuery\Commands;

use Illuminate\Console\Command;

class LaravelConditionQueryCommand extends Command
{
    public $signature = 'laravel-condition-query';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
