<?php
namespace Hansoft\CloudSass\Handlers;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use InvalidArgumentException;

use function Illuminate\Filesystem\join_paths;

class HtaccessHandler
{
    const ROOT = 1;
    const PUBLIC = 2;

    protected $files;

    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    public function handle(Command $command, $type = HtaccessHandler::ROOT)
    {
        $path     = $this->getDestinationFilePath($type);
        $contents = $this->getStubContents($this->getStubPath($type));

        if ($this->files->exists($path)) {
            if ($command->option('force')) {
                $this->createFile($path, $contents);
            } else {
                $command->error('File already exists');
                $command->comment('Use --force option to overwrite the existing file');
                return $command::FAILURE;
            }
        } else {
            $this->createFile($path, $contents);
        }

        $command->info("File : {$path} created");

        return $command::SUCCESS;
    }

    protected function createFile($path, $contents)
    {
        $this->files->put($path, $contents);
    }

    public function getStubPath($type): string
    {
        if ($type === HtaccessHandler::ROOT) {
            return __DIR__ . '/../../stubs/htaccess.stub';
        }

        if ($type === HtaccessHandler::PUBLIC) {
            return __DIR__ . '/../../stubs/public-htaccess.stub';
        }

        throw new InvalidArgumentException('Invalid type provided');
    }

    public function getStubContents($stub): string
    {
        return file_get_contents($stub);
    }

    public function getDestinationFilePath($type): string
    {
        if ($type === HtaccessHandler::ROOT) {
            return base_path('.htaccess');
        }

        if ($type === HtaccessHandler::PUBLIC) {
            return public_path('.htaccess');
        }

        throw new InvalidArgumentException('Invalid type provided');
    }
}
