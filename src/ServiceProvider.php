<?php

declare(strict_types=1);

namespace Theozebua\LaravelViewMaker;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Theozebua\LaravelViewMaker\Commands\{ViewDeleteCommand, ViewMakeCommand};

/**
 * Package service provider.
 * 
 * @package   Theozebua\LaravelViewMaker
 * @version   1.0.0
 * @author    Theo Zebua
 * @license   https://opensource.org/licenses/MIT MIT License
 * @copyright 2022 Theo Zebua
 */
class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->commands(commands: [
            ViewMakeCommand::class,
            ViewDeleteCommand::class
        ]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // 
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [
            ViewMakeCommand::class,
            ViewDeleteCommand::class
        ];
    }
}
