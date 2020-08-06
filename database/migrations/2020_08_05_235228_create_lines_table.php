<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lines', function (Blueprint $table) {
            $table->increments('id');
            $table->string('map_id');
            $table->string('layer_id');
            $table->string('color');
            $table->string('length');
            $table->string('pgIdx');
            $table->string('status');
            $table->string('type');
            $table->string('lat0');
            $table->string('lng0');
            $table->string('lat1');
            $table->string('lng1');
            $table->string('index');
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
        Schema::dropIfExists('lines');
    }
}
