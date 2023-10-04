<?php

declare(strict_types=1);

namespace Modules\Expense\Application\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Modules\Expense\Api\ExpenseCategoryRepositoryInterface;
use Modules\Expense\Application\Http\Resources\ExpenseCategoryResource;

class ExpenseCategoryController extends Controller
{
    public function __construct(private readonly ExpenseCategoryRepositoryInterface $expenseCategoryRepository)
    {}

    /**
     * Получить все категории
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return ExpenseCategoryResource::collection($this->expenseCategoryRepository->findAll());
    }
}
