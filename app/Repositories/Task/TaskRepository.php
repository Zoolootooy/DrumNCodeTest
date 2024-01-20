<?php

namespace App\Repositories\Task;

use App\DTO\Task\TaskDTO;
use App\Models\Task;
use Illuminate\Support\Arr;

class TaskRepository implements TaskRepositoryInterface
{
    public function store(TaskDTO $taskDTO): Task
    {
        $task = new Task();
        $task->fill($taskDTO->toArray());
        $task->save();

        return $task;
    }

    public function update(TaskDTO $taskDTO, int $id): Task
    {
        $task = Task::findOrFail($id);
        $task->fill(Arr::whereNotNull($taskDTO->toArray()));
        $task->save();

        return $task;
    }

    public function destroy(int $id): Task
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return $task;
    }
}
