<?php

declare(strict_types=1);

namespace Theozebua\LaravelViewMaker\Commands;

use Illuminate\Console\Command;
use Theozebua\LaravelViewMaker\Core\ViewMake;
use Theozebua\LaravelViewMaker\Exceptions\FileAlreadyExistsException;

/**
 * Command to create a view.
 * 
 * @package   Theozebua\LaravelViewMaker
 * @version   1.0.0
 * @author    Theo Zebua
 * @license   https://opensource.org/licenses/MIT MIT License
 * @copyright 2022 Theo Zebua
 */
class ViewMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'view:make
                            {name : The name of the view}
                            {--l|layout= : The name of the layout}
                            {--f|force : Force the view creation even when the file is already exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new view';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $fileName   = $this->argument(key: 'name');
        $layout     = $this->option(key: 'layout');
        $force      = $this->option(key: 'force');

        $view = new ViewMake(fileName: $fileName, force: $force);

        try {
            if (!$layout) {
                $view->make();
            } else {
                $view->makeWithLayout(layout: $layout);
            }

            $this->components->info(string: 'View created successfully.');
        } catch (FileAlreadyExistsException $e) {
            $this->components->error(string: $e->getMessage());
        }
    }
}
