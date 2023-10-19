<?php

declare(strict_types=1);

namespace Modules\Garage\Api;

use Illuminate\Database\Eloquent\Collection;
use Modules\Garage\Domain\Models\Garage;
use Modules\User\Domain\Models\User;

interface GarageRepositoryInterface
{
    /**
     * Добавить автомобиль пользователя
     *
     * @param User $user
     * @param array<mixed> $userVehicle
     * @return Garage
     */
    public function create(User $user, array $userVehicle): Garage;

    /**
     * Вернуть все автомобили пользователя
     *
     * @param int $userId
     * @return Collection
     */
    public function findAll(int $userId): Collection;
}
