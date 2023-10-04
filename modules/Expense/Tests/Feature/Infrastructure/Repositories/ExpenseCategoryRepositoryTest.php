<?php

declare(strict_types=1);

namespace Modules\Expense\Tests\Feature\Infrastructure\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\Expense\Api\ExpenseCategoryRepositoryInterface;
use Modules\Expense\Domain\Models\ExpenseCategory;
use Modules\Expense\Infrastructure\Repositories\ExpenseCategoryRepository;
use Tests\TestCase;

class ExpenseCategoryRepositoryTest extends TestCase
{
    public function testFindAllCategories(): void
    {
        /*** @var $repository ExpenseCategoryRepositoryInterface */
        $repository = app(ExpenseCategoryRepository::class);

        $result = $repository->findAll();
        $this->assertNotEmpty($result);
        $this->assertInstanceOf(Collection::class, $result);

        $firstCategory = $result->first();
        $this->assertInstanceOf(ExpenseCategory::class, $firstCategory);
        $this->assertEquals('Топливо', $firstCategory->name);
    }
}
