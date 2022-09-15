<?php

declare(strict_types=1);

namespace Theozebua\LaravelViewMaker\Tests\Features;

use Theozebua\LaravelViewMaker\Core\ViewMake;
use Theozebua\LaravelViewMaker\Exceptions\FileAlreadyExistsException;
use Theozebua\LaravelViewMaker\Tests\TestCase;

class ViewMakeTest extends TestCase
{
    public function test_if_view_is_created_successfully(): void
    {
        $this->view(ViewMake::class, $this->fileName)->make();

        $this->assertFileExists($this->app->resourcePath($this->testPath));
    }

    public function test_if_view_is_forced_created_successfully(): void
    {
        $this->view(ViewMake::class, $this->fileName, true)->make();

        $this->assertFileExists($this->app->resourcePath($this->testPath));
    }

    public function test_if_file_is_already_exists(): void
    {
        $this->view(ViewMake::class, $this->fileName)->make();

        $this->expectException(FileAlreadyExistsException::class);

        $this->view(ViewMake::class, $this->fileName)->make();
    }
}
