<?php

namespace App\Console\Commands;

use Elasticsearch\Client;
use Illuminate\Console\Command;

class CreateESMappingScheme extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:add-scheme';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create mapping scheme for tasks.';

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
        if ($this->elasticsearch->indices()->exists(['index' => 'tasks'])) {
            $this->elasticsearch->indices()->delete(['index' => 'tasks']);
        }
        $this->output->write("Creating mapping structure\n");
        $this->elasticsearch->indices()->create([
            'index' => 'tasks',
            'body' => [
                'mappings' => [
                    'tasks' => [
                        'properties' => [
                            'completed_at' => [
                                'type' => 'date',
                                "format" => "yyyy-MM-dd HH:mm:ss"
                            ],
                        ]
                    ]
                ]
            ]
        ]);
    }
}
