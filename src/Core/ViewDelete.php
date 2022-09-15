<?php

declare(strict_types=1);

namespace Theozebua\LaravelViewMaker\Core;

use Theozebua\LaravelViewMaker\Exceptions\FileDoesNotExistsException;
use Theozebua\LaravelViewMaker\Interfaces\ViewDeleteInterface;

/**
 * @package   Theozebua\LaravelViewMaker
 * @version   1.0.0
 * @author    Theo Zebua
 * @license   https://opensource.org/licenses/MIT MIT License
 * @copyright 2022 Theo Zebua
 */
class ViewDelete extends View implements ViewDeleteInterface
{
    /**
     * Create a new ViewDelete instance with property promotion.
     */
    public function __construct(private string $fileName)
    {
        parent::__construct();
    }

    /**
     * Delete a view.
     * 
     * @return void
     */
    public function delete(): void
    {
        [$directory, $fileName] = $this->get();

        $this->deleteView(fileName: $fileName, directory: $directory);
    }

    /**
     * Get file path to delete.
     * 
     * @return string
     * 
     * @throws \Theozebua\LaravelViewMaker\Exceptions\FileDoesNotExistsException
     */
    public function getFilePath(): string
    {
        [$directory, $fileName] = $this->get();

        if (!$this->checkIfExists($directory . $fileName)) {
            throw new FileDoesNotExistsException(message: "File {$fileName} does not exists in {$this->getViewPath()}{$directory}");
        }

        return $this->getViewPath() . $directory . $fileName;
    }

    /**
     * Get directory and file name.
     * 
     * @return array
     */
    private function get(): array
    {
        $path      = $this->replaceDot(fileName: $this->fileName);
        $path      = $this->separate(fileName: $path);
        $directory = $this->combine(path: $this->removeLastElement(path: $path));
        $fileName  = $this->getFileName(path: $path);

        return [$directory, $fileName];
    }
}
