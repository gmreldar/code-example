<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->comment('ИД пользователя')->constrained();
            $table->foreignId('user_vehicle_id')->comment('ИД транспортного средства пользователя')->constrained();
            $table->foreignId('expense_category_id')->comment('ИД категории траты')->constrained();
            $table->text('description')->comment('Описание')->nullable();
            $table->float('amount')->comment('Сумма расхода');
            $table->unsignedInteger('millage')->comment('Пробег');
            $table->dateTime('scheduled_maintenance_at')->comment('Дата запланированного ТО')->nullable();
            $table->dateTime('completed_maintenance_at')->comment('Дата пройденного ТО')->nullable();
            $table->tinyInteger('maintenance_status')->comment('Статус технического обслуживания')->nullable();
            $table->unsignedInteger('maintenance_reminder_mileage')->comment('Пробег для напоминания о техническом обслуживании')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
