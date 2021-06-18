<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('films', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('othername')->nullable();
            $table->integer('director_id')->nullable();
            $table->integer('year');
            $table->string('type');
            $table->date('release_date')->nullable();
            $table->integer('country_id');
            $table->string('image');
            $table->integer('complete');
            $table->integer('user_id');
            $table->integer('status');
            $table->integer('total_episodes');
            $table->bigInteger('views')->default(0);
            $table->float('rating')->default(0);
            $table->text('description')->nullable();
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
        Schema::dropIfExists('films');
    }
}
