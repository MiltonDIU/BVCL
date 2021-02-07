<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessBusinessCategoryPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('business_business_category', function (Blueprint $table) {
            $table->unsignedBigInteger('business_id');
            $table->foreign('business_id', 'business_id_fk_3120518')->references('id')->on('businesses')->onDelete('cascade');
            $table->unsignedBigInteger('business_category_id');
            $table->foreign('business_category_id', 'business_category_id_fk_3120518')->references('id')->on('business_categories')->onDelete('cascade');
        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_business_category_pivot');
    }
}
