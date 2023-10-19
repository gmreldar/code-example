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
        Schema::dropIfExists('user_vehicles');

        Schema::create('garages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->comment('ИД Пользователя')->constrained();
            $table->foreignId('vehicle_id')->comment('ИД Транспортного средства')->constrained();
            $table->string('model_id')->comment('ИД Модели транспотного средства');
            $table->boolean('is_default')->comment('Выбрано транспортное средство по умолчанию')->default(false);
            $table->unsignedSmallInteger('manufacture_year')->comment('Год производства');
            $table->unsignedInteger('initial_mileage')->comment('Пробег на момент добавления траспортного средства в гараж');
            $table->unsignedInteger('current_mileage')->comment('Текущий пробег на сегодняшний день');
            $table->unsignedSmallInteger('power')->comment('Мощность');
            $table->timestamp('purchase_date')->comment('Дата покупки');
            $table->unsignedSmallInteger('fuel_type')->comment('Тип топлива');
            $table->string('vin')->comment('ВИН Транспортного средства')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('garages');
    }
};
