<?php

declare(strict_types=1);

namespace Modules\Garage\Domain\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Переденное значение текущего пробега больше чем начальный пробег
 */
class IsCurrentMileageMoreThenInitialRule implements Rule
{
    public function __construct(readonly public int $initialMileage)
    {}

    public function passes($attribute, $value): bool
    {
        return $this->initialMileage <= $value;
    }

    public function message(): string
    {
        return 'Текущий пробег должен быть больше начального';
    }
}
