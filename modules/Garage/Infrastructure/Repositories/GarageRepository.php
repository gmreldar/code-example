<?php

declare(strict_types=1);

namespace Modules\Garage\Infrastructure\Repositories;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
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

    /**
     * Обновить автомобиль пользователя
     *
     * @param array $userVehicle
     * @return void
     * @throws Exception
     */
    public function update(array $userVehicle): void
    {
        DB::beginTransaction();
        try {
            /** @var Garage $garage */
            $garage = Garage::find($userVehicle['id']);
            if ($userVehicle['is_default'] === true && $garage->is_default === false) {
                Garage::whereUserId($garage->user_id)->where('id', '!=', $garage->id)->update([
                    'is_default' => false,
                ]);
            }
            $garage->update($userVehicle);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * Удалить авто из гаража
     *
     * @param int $id
     * @return void
     * @throws Exception
     */
    public function delete(int $id): void
    {
        DB::beginTransaction();
        try {
            /** @var Garage $garage */
            $garage = Garage::find($id);
            if ($garage->is_default === true) {
                Garage::whereUserId($garage->user_id)->where('id', '!=', $garage->id)->update([
                    'is_default' => false,
                ]);
            }
            $garage->delete();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
