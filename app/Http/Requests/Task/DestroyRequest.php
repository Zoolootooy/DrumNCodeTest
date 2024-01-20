<?php

namespace App\Http\Requests\Task;

use App\Http\Requests\ApiRequest;
use App\Models\Task;
use Illuminate\Support\Facades\Gate;

class DestroyRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $task = Task::find($this->task);
        if (!$task) $this->authError = 'You can not delete non-existing task.';
        $can = Gate::inspect('delete', [$task, $this->status]);
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
            //
        ];
    }
}
