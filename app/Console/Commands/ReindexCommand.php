<?php

namespace App\Console\Commands;

use App\Models\Task;
use Elasticsearch\Client;
use Illuminate\Console\Command;

class ReindexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:reindex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexes all tasks to Elasticsearch';

    private Client $elasticsearch;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Client $elasticsearch)
    {
        parent::__construct();
        $this->elasticsearch = $elasticsearch;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Indexing all tasks. This might take a while...');
        foreach (Task::cursor() as $task)
        {
            $this->elasticsearch->index([
                'index' => $task->getSearchIndex(),
                'type' => $task->getSearchType(),
                'id' => $task->getKey(),
                'body' => $task->toSearchArray(),
            ]);
            $this->output->write('.');
        }
        $this->info("\nDone!");
    }
}
