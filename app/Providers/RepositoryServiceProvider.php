<?php

namespace App\Providers;

use App\Repositories\Posts\PostRepository;
use App\Repositories\Posts\PostRepositoryInterface;
use App\Repositories\Search\ElasticsearchRepository;
use App\Repositories\Search\SearchRepositoryInterface;
use App\Repositories\Task\TaskRepository;
use App\Repositories\Task\TaskRepositoryInterface;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(SearchRepositoryInterface::class, function () {
            return new ElasticsearchRepository(
                $this->app->make(Client::class)
            );
        });

        $this->bindSearchClient();

        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
    }

    private function bindSearchClient()
    {
        $this->app->bind(Client::class, function ($app) {
            return ClientBuilder::create()
                ->setHosts($app['config']->get('services.search.hosts'))
                ->build();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
