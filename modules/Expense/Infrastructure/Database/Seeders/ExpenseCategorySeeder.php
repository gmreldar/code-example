<?php

declare(strict_types=1);

namespace Modules\Expense\Infrastructure\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Expense\Domain\Models\ExpenseCategory;

class ExpenseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultData = $this->getDefaultData();
        foreach ($defaultData as $expenseCategoryName) {
            ExpenseCategory::create([
                'name' => $expenseCategoryName
            ]);
        }
    }

    /**
     * @return string[]
     */
    private function getDefaultData(): array
    {
        return [
            'Топливо',
            'Мойка',
            'Парковка',
            'Штрафы',
            'Платежи за Автокредит',
            'Обслуживание и Ремонт',
            'Платные дороги',
            'Страхование',
            'Налоги',
            'Технологии и Сервисы / Подписки',
            'Зарядка',
            'Прочее',
        ];
    }
}
