<?php

namespace App\Repositories\Search;

use App\DTO\Task\SearchTaskDTO;
use App\Models\Task;
use Elasticsearch\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ElasticsearchRepository implements SearchRepositoryInterface
{
    /** @var Client */
    private Client $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    public function search(string $query = ''): Collection
    {
        $items = $this->searchOnElasticsearch($query);

        return $this->buildCollection($items);
    }

    public function searchTasks(SearchTaskDTO $searchTaskDTO): Collection
    {
        $items = $this->searchTaskOnElasticsearch($searchTaskDTO->getFields());

        return $this->buildCollection($items, $searchTaskDTO->getFields()->sort);
    }

    private function searchOnElasticsearch(string $query = ''): array
    {
        $model = new Task;

        $items = $this->elasticsearch->search([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'body' => [
                'query' => [
                    'multi_match' => [
                        'fields' => ['title^3', 'description'],
                        'query' => $query,
                    ],
                ],
            ],
        ]);

        return $items;
    }

    private function searchTaskOnElasticsearch(object $searchTaskFields): array
    {
        $model = new Task;

        $searchParams = [
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'body' => [
                'size' => 10000,
                'query' => [
                    'bool' => [
                        'filter' => [
                            [
                                'term' => [
                                    'author_id' => Auth::id(),
                                ]
                            ]
                        ]
                    ],
                ],
            ],
        ];
        if ($searchTaskFields->query) {
            $searchParams['body']['query']['bool']['must'][] = [
                'multi_match' => [
                    'fields' => ['title^3', 'description'],
                    'query' => $searchTaskFields->query,
                ]
            ];
        }
        if ($searchTaskFields->status) {
            $searchParams['body']['query']['bool']['filter'][] = [
                'term' => [
                    'status' => $searchTaskFields->status,
                ]
            ];
        }
        if ($searchTaskFields->priority) {
            $searchParams['body']['query']['bool']['filter'][] = [
                'term' => [
                    'priority' => $searchTaskFields->priority,
                ]
            ];
        }
        $items = $this->elasticsearch->search($searchParams);

        return $items;
    }

    private function buildCollection(array $items, object $sort): Collection
    {
        $ids = Arr::pluck($items['hits']['hits'], '_id');

        return Task::when((array)($sort), function ($q) use ($sort) {
            foreach ($sort as $sortField => $sortOrder) {
                $q->orderBy($sortField, $sortOrder);
            }
        })
            ->findMany($ids);
    }
}
