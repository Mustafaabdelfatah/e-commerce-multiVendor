<?php

namespace App\Observers;

use App\Models\MainCategory;

class MainCategoryObserver
{
     
    public function created(MainCategory $mainCategory)
    {
        
    }

     
    public function updated(MainCategory $mainCategory)
    {
        $mainCategory->vendors()->update(['active' => $mainCategory->active]);
    }

     
    public function deleted(MainCategory $mainCategory)
    {
        //
    }

     
    public function restored(MainCategory $mainCategory)
    {
        //
    }

    
    public function forceDeleted(MainCategory $mainCategory)
    {
        
    }
}
