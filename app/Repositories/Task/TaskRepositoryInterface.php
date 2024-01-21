<?php

namespace App\Repositories\Task;

use App\DTO\Task\TaskDTO;
use App\Models\Task;

interface TaskRepositoryInterface
{
    public function getById(int $id): Task;
    public function store(TaskDTO $taskDTO): Task;
    public function update(TaskDTO $taskDTO, int $id): Task;
    public function destroy(int $id): Task;
}
