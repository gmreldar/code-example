<?php

declare(strict_types=1);

namespace Modules\Vehicle\Infrastructure\Services;

use Exception;
use Modules\Vehicle\Api\VehicleImportServiceInterface;
use Modules\Vehicle\Api\VehicleRepositoryInterface;
use Modules\Vehicle\Infrastructure\Converters\VehicleJsonDataConverter;

/**
 * Сервис для импорта транспортных средств
 */
class VehicleImportService implements VehicleImportServiceInterface
{
    public function __construct(
        private readonly VehicleJsonDataConverter $vehicleJsonDataConverter,
        private readonly VehicleRepositoryInterface $vehicleRepository
    ) {
    }

    /**
     * Импорт транспортных средств из json файла
     *
     * @param string $filePath
     * @return void
     */
    public function import(string $filePath): void
    {
        try {
            $vehicleCollection = $this->vehicleJsonDataConverter->convert($filePath);
            $this->vehicleRepository->recreate($vehicleCollection);
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }
}
