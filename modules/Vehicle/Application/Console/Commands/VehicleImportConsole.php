<?php

declare(strict_types=1);

namespace Modules\Vehicle\Application\Console\Commands;

use Illuminate\Console\Command;
use Modules\Vehicle\Infrastructure\Services\VehicleImportService;

class VehicleImportConsole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vehicles:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Импорт базы транспортных средств';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $path = base_path('dumps/pg/cars.json');
        resolve(VehicleImportService::class)->import($path);
    }
}
