<?php

namespace Database\Factories;

use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $task = [
            'status' => TaskStatus::getRandomStatus(),
            'priority' => rand(1, 5),
            'title' => fake()->text(250),
            'description' => fake()->text(500),
            'author_id' => User::query()->inRandomOrder()->first()->id,
            'parent_id' => rand(0, 1) ? Task::where('status', 'todo')->inRandomOrder()->first()->id : null,
        ];

        if ($task['status'] === TaskStatus::Done) {
            $task['completed_at'] = Carbon::now()->toDateTimeString();
        }
        return $task;
    }
}
