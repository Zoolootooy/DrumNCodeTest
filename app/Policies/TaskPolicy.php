<?php

namespace App\Policies;

use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): Response
    {
        if ($user->id !== $task->author_id) {
            return Response::deny('You do not own this task');
        }

        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task, $status): Response
    {
        if ($user->id !== $task->author_id) {
            return Response::deny('You do not own this task');
        }
        if ($task->status === TaskStatus::Done) {
            return Response::deny('You can not update task with status Done');
        }
        if ($status === TaskStatus::Done->value) {
            $task->loadCount(['allChildren' => function ($q) {
                $q->where('status', TaskStatus::Todo->value);
            }]);

            if ($task->all_children_count > 0) {
                return Response::deny("This task has $task->all_children_count non-closed subtasks");
            }
        }

        return Response::allow();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): Response
    {
        if ($user->id !== $task->author_id) {
            return Response::deny('You do not own this task');
        }
        if ($task->status === TaskStatus::Done) {
            return Response::deny('You can not delete task with status Done');
        }

        return Response::allow();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Task $task): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        //
    }
}
