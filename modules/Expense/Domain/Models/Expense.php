<?php

declare(strict_types=1);

namespace Modules\Expense\Domain\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Modules\Expense\Infrastructure\Enums\MaintenanceStatusEnum;
use Modules\User\Domain\Models\User;
use Modules\User\Domain\Models\UserVehicle;

/**
 * Modules\Expense\Domain\Models\Expense
 *
 * @property int $id
 * @property int $user_id ИД пользователя
 * @property int $user_vehicle_id ИД транспортного средства пользователя
 * @property int $expense_category_id ИД категории траты
 * @property string|null $description Описание
 * @property float $amount Сумма расхода
 * @property int $millage Пробег
 * @property string|null $scheduled_maintenance_at Дата запланированного ТО
 * @property string|null $completed_maintenance_at Дата пройденного ТО
 * @property int|null $maintenance_status Статус технического обслуживания
 * @property int|null $maintenance_reminder_mileage Пробег для напоминания о техническом обслуживании
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Expense newModelQuery()
 * @method static Builder|Expense newQuery()
 * @method static Builder|Expense query()
 * @method static Builder|Expense whereAmount($value)
 * @method static Builder|Expense whereCompletedMaintenanceAt($value)
 * @method static Builder|Expense whereCreatedAt($value)
 * @method static Builder|Expense whereDescription($value)
 * @method static Builder|Expense whereExpenseCategoryId($value)
 * @method static Builder|Expense whereId($value)
 * @method static Builder|Expense whereMaintenanceReminderMileage($value)
 * @method static Builder|Expense whereMaintenanceStatus($value)
 * @method static Builder|Expense whereMillage($value)
 * @method static Builder|Expense whereScheduledMaintenanceAt($value)
 * @method static Builder|Expense whereUpdatedAt($value)
 * @method static Builder|Expense whereUserId($value)
 * @method static Builder|Expense whereUserVehicleId($value)
 * @property-read \Modules\Expense\Domain\Models\ExpenseCategory|null $expenseCategory
 * @property-read User|null $user
 * @mixin \Eloquent
 */
class Expense extends Model
{
    use HasFactory;

    protected $casts = [
        'scheduled_maintenance_at' => 'datetime',
        'completed_maintenance_at' => 'datetime',
        'maintenance_status' => MaintenanceStatusEnum::class
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function userVehicle(): BelongsTo
    {
        return $this->belongsTo(UserVehicle::class);
    }

    /**
     * @return BelongsTo
     */
    public function expenseCategory(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class);
    }
}
