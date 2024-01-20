<?php

namespace App\Models;

use App\Enums\TaskStatus;
use App\Traits\Searchable;
use App\Traits\TimestampTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory, Searchable, TimestampTrait;

    protected $fillable = [
        'status',
        'priority',
        'title',
        'description',
        'parent_id',
        'author_id',
        'completed_at',
    ];

    protected $casts = [
        'status' => TaskStatus::class,
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Task::class, 'parent_id');
    }

    public function allChildren(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->with('allChildren');
    }
}
