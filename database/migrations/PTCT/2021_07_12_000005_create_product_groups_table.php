<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oact')->create('ptct_product_groups', function (Blueprint $table) {
            $table->bigIncrements('product_group_id');
            $table->unsignedBigInteger('cost_center_id');
            $table->string('code');
            $table->string('name');
            $table->string('unit_group_code')->nullable();
            $table->decimal('ratio', 10, 2)->nullable();
            $table->string('unit_cost_center_code')->nullable();
            $table->integer('width')->nullable();
            $table->integer('long')->nullable();
            $table->integer('around')->nullable();
            $table->decimal('area', 10, 2)->nullable();
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
        Schema::connection('oracle_oact')->dropIfExists('ptct_product_groups');
    }
}
