<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    protected $fillable = ['map_id', 'layer_id', 'color', 'length', 'pgIdx', 'status', 'type', 'lat0', 'lng0', 'lat1', 'lng1', 'index'];
}
