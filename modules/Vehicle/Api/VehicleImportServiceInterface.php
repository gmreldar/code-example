<?php

declare(strict_types=1);

namespace Modules\Vehicle\Api;

interface VehicleImportServiceInterface
{
    /**
     * Импорт транспортных средств из json файла
     *
     * @param string $filePath
     * @return void
     */
    public function import(string $filePath): void;
}
