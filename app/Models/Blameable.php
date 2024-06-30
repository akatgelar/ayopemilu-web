<?php

namespace App\Models;

use App\Observers\BlameableObserver;

trait Blameable
{
    public static function bootBlameable()
    {
        static::observe(BlameableObserver::class);
    }
}
