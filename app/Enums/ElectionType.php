<?php

namespace App\Enums;

enum ElectionType: string
{
    case Dsg = 'dsg';
    case Cdsg = 'cdsg';

    public static function values(): array
    {
        return array_map(fn ($value) => $value->value, self::cases());
    }

    public function label(): string
    {
        return match ($this) {
            self::Dsg => 'DSG',
            self::Cdsg => 'CDSG',
        };
    }
}
