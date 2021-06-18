<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManageSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manage_sliders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('film_id')->nullbale();
            $table->string('image')->nullable();
            $table->text('content')->nullbale();
            $table->string('title')->nullable();
            $table->integer('tag');
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
        Schema::dropIfExists('manage_sliders');
    }
}
