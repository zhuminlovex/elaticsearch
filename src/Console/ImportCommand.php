<?php

namespace Haode\Elaticsearch\Console;

use Haode\Elaticsearch\Elaticsearch;
use Illuminate\Console\Command;
use Illuminate\Contracts\Events\Dispatcher;

class ImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elaticsearch:import
            {model : Class name of model to bulk import}
            {--c|chunk= : The number of records to import at a time (Defaults to configuration value: `scout.chunk.searchable`)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import the given model into the search index';

    /**
     * Execute the console command.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function handle(Dispatcher $events)
    {
        $class = $this->argument('model');

        $model = new $class;

        $elatic = new Elaticsearch();

        $model->chunk(2, function ($lists) use ($elatic, $class){
            foreach ($lists as $list){
                $elatic->upserts($list);
            }
        });

        $this->info("导入成功");
    }

}
