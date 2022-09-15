<?php

declare(strict_types=1);

namespace Theozebua\LaravelViewMaker\Commands;

use Illuminate\Console\Command;
use Theozebua\LaravelViewMaker\Core\ViewDelete;
use Theozebua\LaravelViewMaker\Exceptions\FileDoesNotExistsException;

/**
 * Command to delete a view.
 * 
 * @package   Theozebua\LaravelViewMaker
 * @version   1.0.0
 * @author    Theo Zebua
 * @license   https://opensource.org/licenses/MIT MIT License
 * @copyright 2022 Theo Zebua
 */
class ViewDeleteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'view:delete
                            {name} : The name of the view
                            {--f|force : Force delete (Skip the confirmation)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete an existing view';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $fileName = $this->argument(key: 'name');
        $force    = $this->option(key: 'force');

        $view = new ViewDelete(fileName: $fileName);

        try {
            if ($force) {
                $view->delete();
                $this->components->info('View deleted successfully');

                return;
            }

            $viewPath = $view->getFilePath();
            $confirm  = $this->components->confirm("Delete this view? ({$viewPath})");

            if ($confirm) {
                $view->delete();
                $this->components->info('View deleted successfully');
            }
        } catch (FileDoesNotExistsException $e) {
            $this->components->error($e->getMessage());
        }
    }
}
