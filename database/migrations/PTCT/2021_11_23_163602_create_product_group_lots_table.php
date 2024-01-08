<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductGroupLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oact')->create('ptct_product_group_lots', function (Blueprint $table) {
            $table->bigIncrements('product_group_lot_id');
            $table->unsignedBigInteger('product_group_id');
            $table->foreign('product_group_id')->references('product_group_id')->on('ptct_product_groups');
            $table->string('lot');
           
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
        Schema::connection('oracle_oact')->dropIfExists('ptct_product_group_lots');
    }
}