<?php

namespace App\Repositories\Search;

use App\DTO\Task\SearchTaskDTO;
use Illuminate\Support\Collection;

interface SearchRepositoryInterface
{
    public function searchTasks(SearchTaskDTO $searchTaskDTO): Collection;
}
