<?php

namespace App\Http\Requests\Task;

use App\Enums\TaskStatus;
use App\Http\Requests\ApiRequest;
use Illuminate\Validation\Rule;

class IndexRequest extends ApiRequest
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
            'status' => [Rule::enum(TaskStatus::class)],
            'priority' => ['integer', 'min:1', 'max:5'],
            'query' => ['string', 'max:255'],
            'sort.createdAt' => ['in:asc,desc'],
            'sort.completedAt' => ['in:asc,desc'],
            'sort.priority' => ['in:asc,desc'],
        ];
    }
}
