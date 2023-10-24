<?php

declare(strict_types=1);

namespace Modules\Garage\Domain\Observers;


use Modules\Garage\Domain\Models\Garage;

class GarageObserver
{
    /**
     * Handle the @see GarageGarage "created" event.
     */
    public function created(Garage $garage): void
    {
        //
    }

    /**
     * Handle the @see GarageGarage "updated" event.
     */
    public function updated(Garage $garage): void
    {
        //
    }

    /**
     * Handle the @see GarageGarage "updating" event.
     */
    public function updating(Garage $garage): void
    {
    }

    /**
     * Handle the @see GarageGarage "deleted" event.
     */
    public function deleted(Garage $garage): void
    {
        //
    }

    /**
     * Handle the @see GarageGarage "restored" event.
     */
    public function restored(Garage $garage): void
    {
        //
    }

    /**
     * Handle the @see GarageGarage "force deleted" event.
     */
    public function forceDeleted(Garage $garage): void
    {
        //
    }
}
