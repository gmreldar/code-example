<?php

declare(strict_types=1);

namespace Modules\Expense\Api;

use Illuminate\Database\Eloquent\Collection;

interface ExpenseCategoryRepositoryInterface
{
    /**
     * Найти все категории
     *
     * @return Collection
     */
    public function findAll(): Collection;
}
