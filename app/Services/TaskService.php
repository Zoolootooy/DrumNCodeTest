<?php

namespace App\Services;

use App\DTO\Task\SearchTaskDTO;
use App\DTO\Task\TaskDTO;
use App\Http\Responses\ApiErrorResponse;
use App\Models\Task;
use App\Repositories\Search\ElasticsearchRepository;
use App\Repositories\Search\SearchRepositoryInterface;
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

    public function getFiltered(SearchTaskDTO $searchTaskDTO, SearchRepositoryInterface $searchRepository)
    {
        $tasks = $searchRepository->searchTasks($searchTaskDTO);

        return $tasks;
    }

    public function getById(int $id)
    {
        try {
            $task = $this->repository->getById($id);
        } catch(\Exception $e) {
            Log::error($e);
            return new ApiErrorResponse('Can\'t find this task', 404);
        }

        return $task;
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
