<?php

declare(strict_types=1);

namespace Theozebua\LaravelViewMaker\Core;

use Theozebua\LaravelViewMaker\Interfaces\ViewMakeInterface;

/**
 * @package   Theozebua\LaravelViewMaker
 * @version   1.0.0
 * @author    Theo Zebua
 * @license   https://opensource.org/licenses/MIT MIT License
 * @copyright 2022 Theo Zebua
 */
class ViewMake extends View implements ViewMakeInterface
{
    /**
     * Create a new ViewMake instance with property promotion.
     * 
     * @param string $fileName
     * @param string $withLayout
     * @param bool $force
     * @return void
     */
    public function __construct(
        private string $fileName,
        private bool $force = false
    ) {
        parent::__construct(force: $force);
    }

    /**
     * Create a view.
     * 
     * @return void
     */
    public function make(): void
    {
        $this->process(stub: parent::VIEW_PLAIN, placeholder: '{{ quotes }}', replace: $this->getRandomQuote());
    }

    /**
     * Create a view with blade component layout.
     * 
     * @param string $layout
     * @return void
     */
    public function makeWithLayout(string $layout): void
    {
        $this->process(stub: parent::VIEW_WITH_LAYOUT, placeholder: ['{{ layout }}', '{{ quotes }}'], replace: [$this->replaceSlash($layout), $this->getRandomQuote()]);
    }

    /**
     * Process the view creation.
     * 
     * @param int $stub
     * @param array|string $placeholder
     * @param array|string $replace
     * @return void
     */
    private function process(int $stub, array|string $placeholder, array|string $replace): void
    {
        $path      = $this->replaceDot(fileName: $this->fileName);
        $path      = $this->separate(fileName: $path);
        $directory = $this->combine(path: $this->removeLastElement(path: $path));
        $fileName  = $this->getFileName(path: $path);

        $this->makeViewDirectory(directory: $directory, permissions: 0777);
        $this->makeView(fileName: $fileName, directory: $directory, stub: $stub);

        $fileContent = $this->getStubContents(stub: $stub);
        $fileContent = $this->replacePlaceholder(fileContent: $fileContent, placeholder: $placeholder, replace: $replace);

        $this->writeContents(path: $directory . $fileName, contents: $fileContent);
    }

    /**
     * Replace placeholder with actual value.
     * 
     * @param string $fileContent
     * @param array|string $placeholder
     * @param array|string $replace
     * @return string
     */
    private function replacePlaceholder(string $fileContent, array|string $placeholder, array|string $replace): string
    {
        return str_replace(search: $placeholder, replace: $replace, subject: $fileContent);
    }
}
