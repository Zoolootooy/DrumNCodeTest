<?php

namespace App\DTO\Task;

use App\Enums\TaskStatus;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\Cast\Object_;

class SearchTaskDTO
{
    public TaskStatus|null $status;
    public int|null $priority;
    public string|null $query;
    public object|null $sort;

    public function __construct(TaskStatus|null $status, int|null $priority, string|null $query, array|null $sort)
    {
        $this->status = $status;
        $this->priority = $priority;
        $this->query = $query;
        $this->sort = $sort ? (object)$sort : null;
    }

    public function getFields(): object
    {
        $sort = [];

        if ($this->sort) {
            foreach ($this->sort as $field => $value) {
                $sort[Str::snake($field)] = $value;
            }
        }

        return (object)[
            'status' => $this->status,
            'priority' => $this->priority,
            'query' => $this->query,
            'sort' => (object)$sort
        ];
    }
}
