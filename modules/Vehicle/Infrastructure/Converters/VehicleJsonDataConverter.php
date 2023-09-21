<?php

declare(strict_types=1);

namespace Modules\Vehicle\Infrastructure\Converters;

use Illuminate\Support\Facades\File;

/**
 * Класс конвертирует импортируемые ТС из json в массив
 */
class VehicleJsonDataConverter
{
    /**
     * @param string $filePath
     * @return array<int, mixed>
     */
    public function convert(string $filePath): array
    {
        return (array)json_decode(File::get($filePath), true);
    }
}
