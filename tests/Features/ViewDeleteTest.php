<?php

declare(strict_types=1);

namespace Theozebua\LaravelViewMaker\Tests\Features;

use Theozebua\LaravelViewMaker\Core\ViewDelete;
use Theozebua\LaravelViewMaker\Core\ViewMake;
use Theozebua\LaravelViewMaker\Exceptions\FileDoesNotExistsException;
use Theozebua\LaravelViewMaker\Tests\TestCase;

class ViewDeleteTest extends TestCase
{
    public function test_if_file_is_deleted_successfully(): void
    {
        $this->view(ViewMake::class, $this->fileName)->make();
        $this->view(ViewDelete::class, $this->fileName)->delete();

        $this->assertFileDoesNotExist($this->app->resourcePath($this->testPath));
    }

    public function test_if_file_does_not_exists(): void
    {
        $this->expectException(FileDoesNotExistsException::class);

        $this->view(ViewDelete::class, $this->fileName)->delete();
    }
}
