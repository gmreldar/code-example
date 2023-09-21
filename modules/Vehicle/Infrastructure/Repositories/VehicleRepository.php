<?php

declare(strict_types=1);

namespace Modules\Vehicle\Infrastructure\Repositories;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Vehicle\Api\VehicleRepositoryInterface;
use Modules\Vehicle\Domain\Models\Vehicle;

class VehicleRepository implements VehicleRepositoryInterface
{
    /**
     * Найти все ТС
     *
     * @return Collection
     */
    public function findAll(): Collection
    {
        $query = Vehicle::query();
        $query->orderBy('name');
        return $query->get();
    }

    /**
     * Очистить табилцу и импортировать заново
     *
     * @param array<int, mixed> $vehicles
     * @return void
     * @throws Exception
     */
    public function recreate(array $vehicles): void
    {
        DB::beginTransaction();
        try {
            Vehicle::truncate();

            /** @var array<string, mixed> $vehicle */
            foreach ($vehicles as $vehicle) {
                Vehicle::create($vehicle);
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
