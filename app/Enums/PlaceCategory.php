<?php

namespace App\Enums;

enum PlaceCategory: string
{
    case Instagramable = 'instagramable';
    case Kuliner = 'kuliner';
    case Sejarah = 'sejarah';
    case Outdoor = 'outdoor';
    case Belanja = 'belanja';

    public function label(): string
    {
        return match ($this) {
            self::Instagramable => 'Instagramable',
            self::Kuliner => 'Kuliner',
            self::Sejarah => 'Sejarah',
            self::Outdoor => 'Outdoor',
            self::Belanja => 'Belanja',
        };
    }
}
