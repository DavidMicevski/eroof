<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Polygon extends Model
{
    protected $fillable = ['map_id', 'layer_id', 'edindex', 'fillColor', 'pgIdx', 'pitch', 'labelMarkers', 'latlngs'];
}
