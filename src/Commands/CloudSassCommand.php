<?php

namespace Hansoft\CloudSass\Commands;

use Illuminate\Console\Command;

class CloudSassCommand extends Command
{
    public $signature = 'cloud-sass';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
