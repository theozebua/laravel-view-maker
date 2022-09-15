<?php

declare(strict_types=1);

namespace Theozebua\LaravelViewMaker\Tests;

use Illuminate\Filesystem\Filesystem;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Theozebua\LaravelViewMaker\Core\ViewDelete;
use Theozebua\LaravelViewMaker\Core\ViewMake;
use Theozebua\LaravelViewMaker\ServiceProvider;

class TestCase extends OrchestraTestCase
{
    protected string $fileName = 'user.index';
    protected string $testPath = 'views/user/index.blade.php';

    public function setUp(): void
    {
        parent::setUp();
        // additional setup
    }

    protected function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        // perform environment setup
    }

    protected function tearDown(): void
    {
        $fileSystem = new Filesystem();

        if ($fileSystem->exists($this->app->resourcePath($this->testPath))) {
            $this->view(ViewDelete::class, $this->fileName)->delete();
            $fileSystem->deleteDirectory($this->app->resourcePath('views/user'));
        }
    }

    protected function view(string $class, string $fileName, bool $force = false): ViewMake|ViewDelete
    {
        if ($class === ViewMake::class) {
            return new ViewMake(fileName: $fileName, force: $force);
        }

        if ($class === ViewDelete::class) {
            return new ViewDelete(fileName: $fileName);
        }
    }
}
