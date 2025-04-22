<?php
namespace Hansoft\CloudSass\Commands;

use Hansoft\CloudSass\Handlers\HtaccessHandler;
use Illuminate\Console\Command;

class CloudSassHtaccessCommand extends Command
{
    public $signature   = 'cloud-sass:htaccess {--force}';
    public $description = 'Generate .htaccess file for CloudSass';
    public $hidden      = true;
    public $force       = false;

    public function handle(): int
    {
        $handler = app(HtaccessHandler::class);
        return $handler->handle($this);
    }
}
