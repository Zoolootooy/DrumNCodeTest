<?php

namespace App\Services;

use App\DTO\Task\TaskDTO;
use App\Http\Responses\ApiErrorResponse;
use App\Models\Task;
use App\Repositories\Task\TaskRepositoryInterface;
use Illuminate\Support\Facades\Log;

class TaskService
{
    protected TaskRepositoryInterface $repository;

    /**
     * @param TaskRepositoryInterface $repository
     */
    public function __construct(TaskRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function store(TaskDTO $taskDTO): Task|ApiErrorResponse
    {
        try {
            $task = $this->repository->store($taskDTO);
        } catch(\Exception $e) {
            Log::error($e);
            return new ApiErrorResponse('Can\'t store this task', 404);
        }

        return $task;
    }

    public function update(TaskDTO $taskDTO, int $id): Task|ApiErrorResponse
    {
        try {
            $task = $this->repository->update($taskDTO, $id);
        } catch(\Exception $e) {
            Log::error($e);
            return new ApiErrorResponse('Can\'t update this task', 404);
        }

        return $task;
    }

    public function destroy(int $id): Task|ApiErrorResponse
    {
        try {
            $task = $this->repository->destroy($id);
        } catch(\Exception $e) {
            Log::error($e);
            return new ApiErrorResponse('Can\'t delete this task', 404);
        }

        return $task;
    }
}
