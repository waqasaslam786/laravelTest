<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

    public function workshops()
    {
        return $this->hasMany(Workshop::class, 'event_id');
    }
}