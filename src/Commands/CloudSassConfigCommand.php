<?php
namespace Hansoft\CloudSass\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class CloudSassConfigCommand extends Command
{
    public $signature   = 'cloud-sass:config {--client} {--admin} {--force}';
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
        $this->info('Configuring CloudSass Package..');

        if ($this->option('client') && $this->option('admin')) {
            $this->error('You cannot use --client and --admin at the same time.');
            return self::FAILURE;
        }

        if ($this->fileSystem->exists($this->sourceFilePath) && !$this->option('force')) {
            $this->error('Config file already exists. Use --force to overwrite.');
            return self::FAILURE;
        }

        if ($this->option('client')) {
            $this->info('Configuring CloudSass Client Package..');
            $this->fileSystem->put($this->sourceFilePath, $this->getSourceFile());
        } elseif ($this->option('admin')) {
            $this->info('Configuring CloudSass Admin Package..');
            $this->fileSystem->put($this->sourceFilePath, $this->getSourceFile());
        } else {
            $this->error('You must specify either --client or --admin.');
            return self::FAILURE;
        }

        return self::FAILURE;
    }

    public function getSourceFilePath()
    {
        return base_path('config' . DIRECTORY_SEPARATOR . 'config-sass.php');
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
            'TYPE' => $this->option('client') ? 'client' : 'admin',
        ];
    }

    public function getStubPath()
    {
        return __DIR__ . '/../../stubs/config.stub';
    }
}
