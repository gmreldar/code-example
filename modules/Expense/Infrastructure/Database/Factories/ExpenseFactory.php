<?php

namespace Modules\Expense\Infrastructure\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Expense\Domain\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     *
     * Возможно не нужно
     * Нужно доделать дто и реализовать сохранение в бд расхода и описать свагер
     *
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }
}
