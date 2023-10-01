<?php

declare(strict_types=1);

namespace Modules\User\Infrastructure\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\User\Api\UserVehicleRepositoryInterface;
use Modules\User\Domain\Models\User;
use Modules\User\Domain\Models\UserVehicle;

class UserVehicleRepository implements UserVehicleRepositoryInterface
{
    /**
     * Добавить автомобиль пользователя
     *
     * @param User $user
     * @param array<mixed> $userVehicle
     * @return UserVehicle
     */
    public function create(User $user, array $userVehicle): UserVehicle
    {
        return $user->vehicles()->create($userVehicle);
    }

    /**
     * Вернуть все автомобили пользователя
     *
     * @param int $userId
     * @return Collection
     */
    public function findAll(int $userId): Collection
    {
        return UserVehicle::whereUserId($userId)->get();
    }
}
