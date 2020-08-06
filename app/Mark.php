<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    protected $fillable = ['map_id', 'layer_id', 'status', 'text', 'lat', 'lng', 'index'];
}
