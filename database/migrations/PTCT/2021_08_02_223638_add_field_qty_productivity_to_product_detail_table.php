<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldQtyProductivityToProductDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oact')->table('ptct_product_group_details', function (Blueprint $table) {
            $table->integer('qty_productivity')->after('name')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle_oact')->table('ptct_product_group_details', function (Blueprint $table) {
            $table->dropColumn('qty_productivity');
        });
    }
}
