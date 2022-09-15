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
interface ViewDeleteInterface
{
    /**
     * Delete a view.
     * 
     * @return void
     */
    public function delete(): void;
}
