<?php

namespace App\DTO\Task;

use App\Enums\TaskStatus;

class TaskDTO
{
    public TaskStatus|null $status;
    public int|null $priority;
    public string|null $title;
    public string|null $description;
    public int|null $parentId;

    /**
     * @param TaskStatus $status
     * @param int $priority
     * @param string $title
     * @param string $description
     * @param int $parentId
     */
    public function __construct(TaskStatus|null $status, int|null $priority, string|null $title, string|null $description, int|null $parentId)
    {
        $this->status = $status;
        $this->priority = $priority;
        $this->title = $title;
        $this->description = $description;
        $this->parentId = $parentId;
    }

    /**
     * Return array with fields like in DB
     * @return array
     */
    public function toArray(): array
    {
        return [
            'status' => $this->status,
            'priority' => $this->priority,
            'title' => $this->title,
            'description' => $this->description,
            'parent_id' => $this->parentId,
        ];
    }
}
