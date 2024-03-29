<?php

namespace App\Http\Controllers;

use App\DTO\Task\SearchTaskDTO;
use App\DTO\Task\TaskDTO;
use App\Enums\TaskStatus;
use App\Http\Requests\Task\DestroyRequest;
use App\Http\Requests\Task\IndexRequest;
use App\Http\Requests\Task\ShowRequest;
use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Task\UpdateRequest;
use App\Http\Resources\Task\TaskResource;
use App\Http\Resources\Task\TaskWithChildrenResource;
use App\Http\Responses\ApiErrorResponse;
use App\Repositories\Search\SearchRepositoryInterface;
use App\Services\TaskService;

class TaskController extends Controller
{

    protected TaskService $service;

    /**
     * @param TaskService $service
     */
    public function __construct(TaskService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request, SearchRepositoryInterface $searchRepository)
    {
        $searchTaskDTO = new SearchTaskDTO(
            status: $request->input('status') ? TaskStatus::from($request->input('status')) : null,
            priority:$request->input('priority'),
            query:$request->input('query'),
            sort:$request->input('sort'),
        );
        $tasks = $this->service->getFiltered($searchTaskDTO, $searchRepository);

        return TaskResource::collection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): TaskResource|ApiErrorResponse
    {
        $taskDTO = new TaskDTO(
            status:TaskStatus::from($request->input('status')),
            priority:$request->input('priority'),
            title:$request->input('title'),
            description:$request->input('description', null),
            parentId:$request->input('parentId', null),
        );
        $task = $this->service->store($taskDTO);

        return new TaskResource($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(ShowRequest $request, string $id)
    {
        $task = $this->service->getById($id);

        return new TaskWithChildrenResource($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $taskDTO = new TaskDTO(
            status: $request->input('status') ? TaskStatus::from($request->input('status')) : null,
            priority:$request->input('priority'),
            title:$request->input('title'),
            description:$request->input('description'),
            parentId:$request->input('parentId'),
        );

        $task = $this->service->update($taskDTO, $id);

        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyRequest $request, string $id)
    {
        $task = $this->service->destroy($id);

        return new TaskResource($task);
    }
}
