<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('training_id');
            $table->foreign('training_id', 'training_id_23032021')->references('id')->on('trainings')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_23032021')->references('id')->on('users')->onDelete('cascade');
            $table->enum('is_present',[0,1])->default(1);
            $table->timestamps();
        });
    }
}
