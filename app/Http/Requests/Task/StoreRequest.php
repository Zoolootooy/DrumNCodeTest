<?php

namespace App\Http\Requests\Task;

use App\Enums\TaskStatus;
use App\Http\Requests\ApiRequest;
use Illuminate\Validation\Rules\Enum;

class StoreRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => [new Enum(TaskStatus::class)],
            'priority' => ['integer', 'min:1', 'max:5'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['string', 'max:65535'],
            'parentId' => ['exists:tasks,id'],
        ];
    }
}
