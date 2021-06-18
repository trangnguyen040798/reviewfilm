<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_videos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('column_name');
            $table->string('column_value');
            $table->integer('film_id');
            $table->integer('episode');
            $table->integer('position')->nullable();
            $table->string('capacity')->nullable();
            $table->string('duration')->nullable();
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
        Schema::dropIfExists('info_videos');
    }
}
