<?php

declare(strict_types=1);

namespace Modules\Vehicle\Tests\Feature\Application\Console\Commands;

use Illuminate\Foundation\Testing\Concerns\InteractsWithConsole;
use Modules\Vehicle\Api\VehicleImportServiceInterface;
use Tests\TestCase;

class VehicleImportConsoleTest extends TestCase
{
    use InteractsWithConsole;

    public function testVehicleImportCommand(): void
    {
        $filePath = base_path('dumps/pg/cars.json');

        // Убедимся, что сервис будет вызван при выполнении команды
        $this->partialMock(VehicleImportServiceInterface::class, function ($mock) use ($filePath) {
            $mock->shouldReceive('import')->once()->with($filePath);
        });

        // Вызовем консольную команду
        // Проверим, что команда была успешно выполнена (без ошибок)
        /*** @phpstan-ignore-next-line */
        $this->artisan('vehicles:import')->assertExitCode(0);
    }
}
