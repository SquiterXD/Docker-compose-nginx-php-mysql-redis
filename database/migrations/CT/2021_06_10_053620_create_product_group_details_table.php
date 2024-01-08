<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductGroupDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ct_product_group_details', function (Blueprint $table) {
            $table->bigIncrements('product_group_detail_id');
            $table->unsignedBigInteger('product_group_id');
            $table->foreign('product_group_id')->references('product_group_id')->on('ct_product_groups');
            $table->string('code');
            $table->string('name');
           
            $table->integer('last_updated_by')->nullable();
            $table->datetime('last_update_date')->default(DB::raw('SYSDATE'));
            $table->integer('created_by')->nullable();
            $table->datetime('creation_date')->default(DB::raw('SYSDATE'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ct_product_group_details');
    }
}
