<?php
namespace Hansoft\CloudSass\Commands;

use Hansoft\CloudSass\Handlers\HtaccessHandler;
use Illuminate\Console\Command;

class CloudSassPublicHtaccessCommand extends Command
{
    public $signature   = 'cloud-sass:public-htaccess {--force}';
    public $description = 'Generate public .htaccess file for CloudSass';
    public $hidden      = true;
    public $force       = false;

    public function handle(): int
    {
        if (config('cloud-sass.type') !== 'client') {
            $this->error('This command is only available for client type.');
            return self::FAILURE;
        }

        $handler = app(HtaccessHandler::class);
        return $handler->handle($this, HtaccessHandler::PUBLIC);
    }
}
