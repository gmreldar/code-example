<?php

declare(strict_types=1);

namespace Modules\Expense\Application\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Expense\Domain\Models\ExpenseCategory;

/**
 * @property ExpenseCategory $resource
 */
class ExpenseCategoryResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name
        ];
    }
}
