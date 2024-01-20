<?php

namespace App\Repositories\Search;

use Illuminate\Support\Collection;

interface SearchRepositoryInterface
{
    public function search(string $query = ''): Collection;
}
