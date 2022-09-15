<?php

declare(strict_types=1);

namespace Theozebua\LaravelViewMaker\Interfaces;

/**
 * @package   Theozebua\LaravelViewMaker
 * @version   1.0.0
 * @author    Theo Zebua
 * @license   https://opensource.org/licenses/MIT MIT License
 * @copyright 2022 Theo Zebua
 */
interface ViewMakeInterface
{
    /**
     * Create a view.
     * 
     * @return void
     */
    public function make(): void;

    /**
     * Create a view with blade component layout.
     * 
     * @param string $layout
     * @return void
     */
    public function makeWithLayout(string $layout): void;
}
