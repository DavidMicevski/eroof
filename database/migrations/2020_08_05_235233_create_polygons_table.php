<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePolygonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polygons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('map_id');
            $table->string('layer_id');
            $table->string('edindex');
            $table->string('fillColor');
            $table->string('pgIdx');
            $table->string('pitch');
            $table->string('labelMarkers');
            $table->string('latlngs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('polygons');
    }
}
