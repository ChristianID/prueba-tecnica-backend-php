<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{

    use SoftDeletes;

    protected $guarded = ['id'];

    /**
     * Schedules relationship
     */
    public function schedules()
    {
        return $this->belongsToMany('App\Models\Schedule', 'movies_schedules');
    }

}
