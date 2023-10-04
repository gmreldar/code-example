<?php

declare(strict_types=1);

namespace Modules\Expense\Infrastructure\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\Expense\Api\ExpenseCategoryRepositoryInterface;
use Modules\Expense\Domain\Models\ExpenseCategory;

class ExpenseCategoryRepository implements ExpenseCategoryRepositoryInterface
{
    /**
     * Найти все категории
     *
     * @return Collection
     */
    public function findAll(): Collection
    {
        return ExpenseCategory::get();
    }
}
