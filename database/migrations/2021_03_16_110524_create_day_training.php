<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDayTraining extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('day_training', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('training_id');
            $table->foreign('training_id', 'training_id_fk_3447420')->references('id')->on('trainings')->onDelete('cascade');
            $table->unsignedBigInteger('day_id');
            $table->foreign('day_id', 'day_id_fk_3447415')->references('id')->on('days')->onDelete('cascade');
            $table->string('begin_time');
            $table->string('close_time');
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
        Schema::dropIfExists('day_training');
    }
}
