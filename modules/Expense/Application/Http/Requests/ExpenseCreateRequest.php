<?php

declare(strict_types=1);

namespace Modules\Expense\Application\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $user_id - ИД пользователя
 * @property int $user_vehicle_id - ИД транспортного средства пользователя
 * @property int $expense_category_id - ИД категории траты
 * @property int|null $description - Описание
 * @property float $amount - Сумма расхода
 * @property int $millage - Пробег
 * @property Carbon|null $scheduled_maintenance_at - Дата запланированного ТО
 * @property Carbon|null $completed_maintenance_at - Дата пройденного ТО
 * @property int|null $maintenance_status - Статус технического обслуживания
 * @property int|null $maintenance_reminder_mileage - Пробег для напоминания о техническом обслуживании
 */
class ExpenseCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string[]>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'user_vehicle_id' => ['required', 'integer', 'exists:user_vehicles,id'],
//            'user_vehicle_id' => ['required', 'integer', 'exists:user_vehicles,id', new IsVehicleBelongsToUserRule((int)$this->user_id)],
            'expense_category_id' => ['required', 'integer', 'exists:expense_categories,id'],
            'description' => ['nullable', 'string'],
            'amount' => ['required', 'numeric', 'min:1'],
            'millage' => ['required', 'integer', 'min:1'],
            'scheduled_maintenance_at' => ['nullable', 'date'],
            'completed_maintenance_at' => ['nullable', 'date'],
            'maintenance_status' => ['nullable', 'integer'],
            'maintenance_reminder_mileage' => ['nullable', 'integer'],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'Пользователя обязателен для заполнения.',
            'user_id.integer' => 'ИД пользователя должен быть целым числом.',
            'user_id.exists' => 'Выбранный пользователь не существует или не активен.',

            'user_vehicle_id.required' => 'Транспортного средства пользователя обязателен для заполнения.',
            'user_vehicle_id.integer' => 'ИД транспортного средства пользователя должен быть целым числом.',
            'user_vehicle_id.exists' => 'Выбранное транспортное средство пользователя не существует или не принадлежит данному пользователю.',

            'expense_category_id.required' => 'Категория траты обязателена для заполнения.',
            'expense_category_id.integer' => 'ИД категории траты должен быть целым числом.',
            'expense_category_id.exists' => 'Выбранная категория траты не существует.',

            'amount.required' => 'Сумма расхода обязательна для заполнения.',
            'amount.numeric' => 'Сумма расхода должна быть числом.',
            'amount.min' => 'Сумма расхода должна быть положительным числом.',

            'millage.required' => 'Пробег обязателен для заполнения.',
            'millage.integer' => 'Пробег должен быть целым числом.',
            'millage.min' => 'Пробег должен быть пложительным числом.',

            'scheduled_maintenance_at.date' => 'Дата запланированного ТО должна быть корректной датой.',

            'completed_maintenance_at.date' => 'Дата пройденного ТО должна быть корректной датой.',

            'maintenance_status.integer' => 'Статус технического обслуживания должен быть целым числом.',

            'maintenance_reminder_mileage.integer' => 'Пробег для напоминания о техническом обслуживании должен быть целым числом.',
        ];
    }

    public function toDto()
    {

    }
}
