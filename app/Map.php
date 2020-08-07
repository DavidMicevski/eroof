<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    protected $fillable = ['userid', 'image', 'address', 'maptype', 'lat', 'lng', 'unit', 'distance', 'pixel'];
}
