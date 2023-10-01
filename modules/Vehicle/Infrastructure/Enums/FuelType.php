<?php

declare(strict_types=1);

namespace Modules\Vehicle\Infrastructure\Enums;

enum FuelType: int
{
    case AI_80 = 1;
    case AI_92 = 2;
    case AI_95 = 3;
    case AI_95_PLUS = 4;
    case AI_98 = 5;
    case AI_100 = 6;
    case DIESEL = 7;
    case DIESEL_PLUS = 8;
    case GAS = 9;
    case ELECTRICITY = 10;

    public function getLabel(): string
    {
        return match ($this) {
            self::AI_80 => 'АИ-80',
            self::AI_92 => 'АИ-92',
            self::AI_95 => 'АИ-95',
            self::AI_95_PLUS => 'АИ-95+',
            self::AI_98 => 'АИ-98',
            self::AI_100 => 'АИ-100',
            self::DIESEL => 'Дизель',
            self::DIESEL_PLUS => 'Дизель+',
            self::GAS => 'Газ',
            self::ELECTRICITY => 'Электричество',
        };
    }

    /**
     * @return string[]
     */
    public static function toArray(): array
    {
        return [
            self::AI_80->value => 'АИ-80',
            self::AI_92->value => 'АИ-92',
            self::AI_95->value => 'АИ-95',
            self::AI_95_PLUS->value => 'АИ-95+',
            self::AI_98->value => 'АИ-98',
            self::AI_100->value => 'АИ-100',
            self::DIESEL->value => 'Дизель',
            self::DIESEL_PLUS->value => 'Дизель+',
            self::GAS->value => 'Газ',
            self::ELECTRICITY->value => 'Электричество',
        ];
    }
}
