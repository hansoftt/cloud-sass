<?php
namespace Hansoft\CloudSass\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class CloudSassConfigCommand extends Command
{
    public $signature   = 'cloud-sass:config {--force}';
    public $description = 'Configure CloudSass Package';
    public $hidden      = true;
    public $force       = false;
    private $fileSystem;
    private $sourceFilePath;

    public function __construct(FileSystem $fileSystem)
    {
        parent::__construct();
        $this->fileSystem = $fileSystem;
        $this->sourceFilePath = $this->getSourceFilePath();
    }

    public function handle(): int
    {
        if ($this->fileSystem->exists($this->sourceFilePath) && !$this->option('force')) {
            $this->error('Config file already exists. Use --force to overwrite.');
            return self::FAILURE;
        }

        $this->info('Configuring CloudSass Package..');
        $this->fileSystem->put($this->sourceFilePath, $this->getSourceFile());
        $this->info('Configured CloudSass Package.');
        return self::SUCCESS;
    }

    public function getSourceFilePath()
    {
        return base_path('config' . DIRECTORY_SEPARATOR . 'cloud-sass.php');
    }

    public function getSourceFile()
    {
        return $this->getStubContents($this->getStubPath(), $this->getStubVariables());
    }

    public function getStubContents($stub, $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('$' . $search, $replace, $contents);
        }

        return $contents;

    }

    public function getStubVariables()
    {
        return [
            'TYPE' => 'admin',
        ];
    }

    public function getStubPath()
    {
        return __DIR__ . '/../../stubs/config.stub';
    }
}
