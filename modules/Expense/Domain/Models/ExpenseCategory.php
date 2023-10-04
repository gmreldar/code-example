<?php

declare(strict_types=1);

namespace Modules\Expense\Domain\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Modules\Expense\Domain\Models\ExpenseCategory
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|ExpenseCategory newModelQuery()
 * @method static Builder|ExpenseCategory newQuery()
 * @method static Builder|ExpenseCategory query()
 * @method static Builder|ExpenseCategory whereCreatedAt($value)
 * @method static Builder|ExpenseCategory whereId($value)
 * @method static Builder|ExpenseCategory whereName($value)
 * @method static Builder|ExpenseCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ExpenseCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
    ];
}
