<?php

namespace App\Traits;

use Carbon\Carbon;

trait TimestampTrait
{
    public function getCreatedDateAttribute()
    {
        return !empty($this->created_at)
            ? Carbon::parse($this->created_at)->format(config('timeFormats.date'))
            : null;
    }

    public function getCreatedTimeAttribute()
    {
        return !empty($this->created_at)
            ? Carbon::parse($this->created_at)->format(config('timeFormats.time'))
            : null;
    }

    public function getCreatedFullAttribute()
    {
        return !empty($this->created_at)
            ? Carbon::parse($this->created_at)->format(config('timeFormats.date') . ' ' . config('timeFormats.time'))
            : null;
    }

    public function getDeletedDateAttribute()
    {
        return !empty($this->deleted_at)
            ? Carbon::parse($this->deleted_at)->format(config('timeFormats.date'))
            : null;
    }

    public function getDeletedTimeAttribute()
    {
        return !empty($this->deleted_at)
            ? Carbon::parse($this->deleted_at)->format(config('timeFormats.time'))
            : null;
    }

    public function getDeletedFullAttribute()
    {
        return !empty($this->deleted_at)
            ? Carbon::parse($this->deleted_at)->format(config('timeFormats.date') . ' ' . config('timeFormats.time'))
            : null;
    }

    public function getUpdatedDateAttribute()
    {
        return !empty($this->updated_at)
            ? Carbon::parse($this->updated_at)->format(config('timeFormats.date'))
            : null;
    }

    public function getUpdatedTimeAttribute()
    {
        return !empty($this->updated_at)
            ? Carbon::parse($this->updated_at)->format(config('timeFormats.time'))
            : null;
    }

    public function getUpdatedFullAttribute()
    {
        return !empty($this->updated_at)
            ? Carbon::parse($this->updated_at)->format(config('timeFormats.date') . ' ' . config('timeFormats.time'))
            : null;
    }

    public function getDiffForHumansAttribute()
    {
        return !empty($this->updated_at)
            ? Carbon::parse($this->updated_at)->diffForHumans()
            : null;
    }

    public function getDiffInDaysAttribute()
    {
        return !empty($this->updated_at)
            ? Carbon::parse($this->updated_at)->diffInDays()
            : null;
    }
}