<?php

declare(strict_types=1);

namespace Modules\User\Domain\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Garage\Domain\Models\Garage;

/**
 * Принадлежит ли выбранное ТС пользователю
 */
class IsVehicleBelongsToUserRule implements Rule
{
    public function __construct(readonly public int $userId)
    {}

    public function passes($attribute, $value): bool
    {
        if (!$this->userId || !is_int($this->userId) || !$value) {
            return false;
        }
        $garage = Garage::whereVehicleId($value)->whereUserId($this->userId)->first();
        return !is_null($garage);
    }

    public function message(): string
    {
        return 'Выбранное ТС не пренадлежит пользователю';
    }
}
