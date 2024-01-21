<?php

namespace App\Enums;

enum TaskStatus: string
{
    case Todo = 'todo';
    case Done = 'done';

    public static function getRandomStatus()
    {
        $values = self::getValues();
        $randomIndex = array_rand($values);
        return $values[$randomIndex];
    }

    public static function getValues(): array
    {
        return [
            self::Todo,
            self::Done,
        ];
    }
}
