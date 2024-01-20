<?php

namespace App\Http\Requests\Task;

use App\Enums\TaskStatus;
use App\Http\Requests\ApiRequest;
use App\Models\Task;
use Illuminate\Support\Facades\Gate;

class UpdateRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $task = Task::find($this->task);
        if (!$task) $this->authError = 'You can not update non-existing task.';
        $can = Gate::inspect('update', [$task, $this->status]);
        if (!is_null($can->message())) $this->authError = $can->message();
        return $can->allowed();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['in:'.TaskStatus::Done->value],
            'priority' => ['integer', 'min:1', 'max:5'],
            'title' => ['string', 'max:255'],
            'description' => ['nullable', 'string', 'max:65535'],
            'parentId' => ['nullable', 'exists:tasks,id', "not_in:$this->task"],
        ];
    }

    public function messages(): array
    {
        return [
            'status.in' => 'You can update task status only to Done.',
            'parentId.not_in' => 'Field parentId can not be like this task id.',
            'parentId.exists' => 'Task with id like parentId field does not exists.',
        ];
    }
}
