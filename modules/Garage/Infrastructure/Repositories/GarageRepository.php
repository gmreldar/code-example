<?php

declare(strict_types=1);

namespace Modules\Garage\Infrastructure\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\Garage\Api\GarageRepositoryInterface;
use Modules\Garage\Domain\Models\Garage;
use Modules\User\Domain\Models\User;

class GarageRepository implements GarageRepositoryInterface
{
    /**
     * Добавить автомобиль пользователя в гараж
     *
     * @param User $user
     * @param array<mixed> $userVehicle
     * @return Garage
     */
    public function create(User $user, array $userVehicle): Garage
    {
        return $user->garages()->create($userVehicle);
    }

    /**
     * Вернуть все автомобили пользователя
     *
     * @param int $userId
     * @return Collection
     */
    public function findAll(int $userId): Collection
    {
        return Garage::whereUserId($userId)->get();
    }
}
