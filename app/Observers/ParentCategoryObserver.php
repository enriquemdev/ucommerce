<?php

namespace App\Observers;

use App\Models\ParentCategory;

class ParentCategoryObserver
{
    /**
     * Handle the ParentCategory "created" event.
     */

    public function creating(ParentCategory $parentCategory): void
    {
        $parentCategory->user()->associate(auth()->user());
    }

    public function created(ParentCategory $parentCategory): void
    {
        //
    }

    /**
     * Handle the ParentCategory "updated" event.
     */
    public function updated(ParentCategory $parentCategory): void
    {
        //
    }

    /**
     * Handle the ParentCategory "deleted" event.
     */
    public function deleted(ParentCategory $parentCategory): void
    {
        //
    }

    /**
     * Handle the ParentCategory "restored" event.
     */
    public function restored(ParentCategory $parentCategory): void
    {
        //
    }

    /**
     * Handle the ParentCategory "force deleted" event.
     */
    public function forceDeleted(ParentCategory $parentCategory): void
    {
        //
    }
}
