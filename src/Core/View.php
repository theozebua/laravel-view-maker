<?php

declare(strict_types=1);

namespace Theozebua\LaravelViewMaker\Core;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Inspiring;
use Theozebua\LaravelViewMaker\Exceptions\{FileAlreadyExistsException, FileDoesNotExistsException};

/**
 * Base class for laravel view maker package.
 * 
 * @package   Theozebua\LaravelViewMaker
 * @version   1.0.0
 * @author    Theo Zebua
 * @license   https://opensource.org/licenses/MIT MIT License
 * @copyright 2022 Theo Zebua
 */
abstract class View
{
    /**
     * Laravel file system class.
     * 
     * @var \Illuminate\Filesystem\Filesystem $fileSystem
     */
    private Filesystem $fileSystem;

    /**
     * Stub path.
     * 
     * @var string $stubPath
     */
    private string $stubPath;

    /**
     * View path.
     * 
     * @var string $viewPath
     */
    private string $viewPath;

    /**
     * File extension.
     * 
     * @var string $extension
     */
    private string $extension;

    /**
     * Inspiring quote.
     * 
     * @var string $quote
     */
    private string $quote;

    /**
     * View plain stub.
     * 
     * @var int
     */
    protected const VIEW_PLAIN = 1;

    /**
     * View with layout stub.
     * 
     * @var int
     */
    protected const VIEW_WITH_LAYOUT = 2;

    /**
     * View constructor with property promotion.
     * 
     * @param bool $force
     * @return void
     */
    public function __construct(private bool $force = false)
    {
        $this->fileSystem = new Filesystem();
        $this->quote      = (new Inspiring())->quotes()->random();
        $this->stubPath   = __DIR__ . '/../stubs/';
        $this->viewPath   = app()->resourcePath('views') . '/';
        $this->extension  = '.blade.php';
    }

    /**
     * Create a view.
     * 
     * @param string $fileName
     * @param string $directory
     * @param int $stub
     * @return bool
     * 
     * @throws \Theozebua\LaravelViewMaker\Exceptions\FileAlreadyExistsException
     */
    protected function makeView(string $fileName, string $directory, int $stub): bool
    {
        if ($this->checkIfExists(path: $directory . $fileName) && !$this->force) {
            throw new FileAlreadyExistsException(message: "File {$fileName} is already exists in {$this->viewPath}{$directory}{$fileName}");
        }

        if ($this->checkIfExists(path: $directory . $fileName) && $this->force) {
            return $this->fileSystem->copy(path: $this->getStub(stub: $stub), target: $this->viewPath . $directory . $fileName);
        }

        return $this->fileSystem->copy(path: $this->getStub(stub: $stub), target: $this->viewPath . $directory . $fileName);
    }

    /**
     * Delete a view.
     * 
     * @param string $fileName
     * @param string $directory
     * @return bool
     * 
     * @throws \Theozebua\LaravelViewMaker\Exceptions\FileDoesNotExistsException
     */
    protected function deleteView(string $fileName, string $directory): bool
    {
        if (!$this->checkIfExists(path: $directory . $fileName)) {
            throw new FileDoesNotExistsException(message: "File {$fileName} does not exists in {$this->viewPath}/{$directory}");
        }

        return $this->fileSystem->delete(paths: $this->viewPath . $directory . $fileName);
    }

    /**
     * Create a directory.
     * 
     * @param string $directory
     * @param int $permissions
     * @return bool
     */
    protected function makeViewDirectory(string $directory, int $permissions): bool
    {
        return $this->fileSystem->makeDirectory(path: $this->viewPath . $directory, mode: $permissions, recursive: true, force: true);
    }

    /**
     * Write the contents of a file.
     * 
     * @param string $path
     * @param string $contents
     * @return int|false
     */
    protected function writeContents(string $path, string $contents): int|false
    {
        return $this->fileSystem->put(path: $this->viewPath . $path, contents: $contents);
    }

    /**
     * Get the file name from the given path.
     * 
     * @param array $path
     * @return string
     */
    protected function getFileName(array $path): string
    {
        return end($path) . $this->extension;
    }

    /**
     * Get random quote.
     * 
     * @return string
     */
    protected function getRandomQuote(): string
    {
        return $this->quote;
    }

    /**
     * Get stub file.
     * 
     * @param int $stub
     * @return string
     */
    protected function getStub(int $stub): string
    {
        if ($stub === self::VIEW_WITH_LAYOUT) {
            return $this->stubPath . 'view-with-layout.stub';
        }

        if ($stub === self::VIEW_PLAIN) {
            return $this->stubPath . 'view-plain.stub';
        }

        return $this->stubPath . 'view-plain.stub';
    }

    /**
     * Get the contents from a stub file.
     * 
     * @return string
     */
    protected function getStubContents(int $stub): string
    {
        return $this->fileSystem->get($this->getStub(stub: $stub));
    }

    /**
     * Get the view path.
     * 
     * @return string
     */
    protected function getViewPath(): string
    {
        return $this->viewPath;
    }

    /**
     * Determine if a file or directory exists.
     * 
     * @param string $path
     * @return bool
     */
    protected function checkIfExists(string $path): bool
    {
        if (!$this->fileSystem->exists(path: $this->viewPath . $path)) {
            return false;
        }

        return true;
    }

    /**
     * Combine the given array.
     * 
     * @param array $path
     * @return string
     */
    protected function combine(array $path): string
    {
        return implode('/', $path) . '/';
    }

    /**
     * Remove the last element from the given array.
     * 
     * @param array $fileName
     * @return array
     */
    protected function removeLastElement(array $path): array
    {
        array_pop($path);

        return $path;
    }

    /**
     * Replace dot with slash from the given string.
     * 
     * @param string $fileName
     * @return string
     */
    protected function replaceDot(string $fileName): string
    {
        return str_replace('.', '/', $fileName);
    }

    /**
     * Replace slash with dot from the given string.
     * 
     * @param string $fileName
     * @return string
     */
    protected function replaceSlash(string $fileName): string
    {
        return str_replace('/', '.', $fileName);
    }

    /**
     * Separate the given string.
     * 
     * @param string $fileName
     * @return array
     */
    protected function separate(string $fileName): array
    {
        return explode('/', $fileName);
    }
}
