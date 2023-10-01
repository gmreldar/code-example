<?php

declare(strict_types=1);

namespace Modules\Vehicle\Tests\Feature\Infrastructure\Enums;

use Modules\Vehicle\Infrastructure\Enums\FuelType;
use Tests\TestCase;

class FuelTypeTest extends TestCase
{
    public function testGetLabel(): void
    {
        $this->assertEquals('АИ-80', FuelType::AI_80->getLabel());
        $this->assertEquals('АИ-92', FuelType::AI_92->getLabel());
        $this->assertEquals('АИ-95', FuelType::AI_95->getLabel());
        $this->assertEquals('АИ-95+', FuelType::AI_95_PLUS->getLabel());
        $this->assertEquals('АИ-98', FuelType::AI_98->getLabel());
        $this->assertEquals('АИ-100', FuelType::AI_100->getLabel());
        $this->assertEquals('Дизель', FuelType::DIESEL->getLabel());
        $this->assertEquals('Дизель+', FuelType::DIESEL_PLUS->getLabel());
        $this->assertEquals('Газ', FuelType::GAS->getLabel());
        $this->assertEquals('Электричество', FuelType::ELECTRICITY->getLabel());
    }

    public function testToArray(): void
    {
        $expectedArray = [
            FuelType::AI_80->value => 'АИ-80',
            FuelType::AI_92->value => 'АИ-92',
            FuelType::AI_95->value => 'АИ-95',
            FuelType::AI_95_PLUS->value => 'АИ-95+',
            FuelType::AI_98->value => 'АИ-98',
            FuelType::AI_100->value => 'АИ-100',
            FuelType::DIESEL->value => 'Дизель',
            FuelType::DIESEL_PLUS->value => 'Дизель+',
            FuelType::GAS->value => 'Газ',
            FuelType::ELECTRICITY->value => 'Электричество',
        ];

        $this->assertEquals($expectedArray, FuelType::toArray());
    }
}
