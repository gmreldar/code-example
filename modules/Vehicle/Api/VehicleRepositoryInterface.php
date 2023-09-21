<?php

declare(strict_types=1);

namespace Modules\Vehicle\Api;

use Exception;
use Illuminate\Database\Eloquent\Collection;

interface VehicleRepositoryInterface
{
    /**
     * Найти все ТС
     *
     * @return Collection
     */
    public function findAll(): Collection;

    /**
     * Очистить табилцу и импортировать заново
     *
     * @param array<int, mixed> $vehicles
     * @return void
     * @throws Exception
     */
    public function recreate(array $vehicles): void;
}
