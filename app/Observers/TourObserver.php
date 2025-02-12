<?php

namespace App\Observers;

use App\Models\Admins\Tour;
use App\Models\ChangeLog;


class TourObserver
{

    public function updating(Tour $tour)
    {
        ChangeLog::create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'model' => get_class($tour),
            'model_id' => $tour->id,
            'changes' => [
                'old' => $tour->getOriginal(),
                'new' => $tour->getDirty(),
            ],
        ]);
    }
    /**
     * Handle the Tour "created" event.
     */
    public function created(Tour $tour): void
    {
        ChangeLog::create([
            'user_id' => auth()->id(),
            'action' => 'create',
            'model' => get_class($tour),
            'model_id' => $tour->id,
            'changes' => null, // Không cần chi tiết cho hành động create
        ]);
    }

    /**
     * Handle the Tour "updated" event.
     */
    public function updated(Tour $tour): void
    {
        //
    }

    /**
     * Handle the Tour "deleted" event.
     */
    public function deleted(Tour $tour): void
    {
        ChangeLog::create([
            'user_id' => auth()->id(),
            'action' => 'delete',
            'model' => get_class($tour),
            'model_id' => $tour->id,
            'changes' => [
                'old' => $tour->getOriginal(),
                'new' => null,
            ],
        ]);
    }

    /**
     * Handle the Tour "restored" event.
     */
    public function restored(Tour $tour): void
    {
        //
    }

    /**
     * Handle the Tour "force deleted" event.
     */
    public function forceDeleted(Tour $tour): void
    {
        //
    }
}
