<?php

namespace App\Http\Resources\Task;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class TaskWithChildrenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = [
            'id' => $this->id,
            'status' => $this->status,
            'priority' => $this->priority,
            'title' => $this->title,
            'description' => Str::of($this->description)->limit(250),
            'author' => $this->author->only(['id','name','email']),
            'parentId' => $this->parent_id,

            'createdAt' => $this->created_at,
            'createdAtFormatted' => $this->createdFull,
            'updatedAt' => $this->updated_at,
            'updatedAtFormatted' => $this->updatedFull,

            'completedAt' => $this->completed_at,
            'completedAtFormatted' => $this->getFullFromTimestamp($this->completed_at),

            'allChildrenCount' => $this->allChildren->count() ?? 0,
        ];

        $response['allChildren'] = TaskWithChildrenResource::collection($this->whenLoaded('allChildren'));

        return $response;
    }
}
