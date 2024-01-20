<?php

namespace App\Observers;

use App\Enums\TaskStatus;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "creating" event.
     */
    public function creating(Task $task): void
    {
        $task->author_id = Auth::id();
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        //
    }


    /**
     * Handle the Task "updating" event.
     */
    public function updating(Task $task): void
    {
        if ($task->status === TaskStatus::Done) {
            $task->completed_at = Carbon::now()->toDateTimeString();
        }
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "restored" event.
     */
    public function restored(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     */
    public function forceDeleted(Task $task): void
    {
        //
    }
}
