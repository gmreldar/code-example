<?php

declare(strict_types=1);

namespace Modules\User\Api;

use Illuminate\Database\Eloquent\Collection;
use Modules\User\Domain\Models\User;
use Modules\User\Domain\Models\UserVehicle;

interface UserVehicleRepositoryInterface
{
    /**
     * Добавить автомобиль пользователя
     *
     * @param User $user
     * @param array<mixed> $userVehicle
     * @return UserVehicle
     */
    public function create(User $user, array $userVehicle): UserVehicle;

    /**
     * Вернуть все автомобили пользователя
     *
     * @param int $userId
     * @return Collection
     */
    public function findAll(int $userId): Collection;
}
