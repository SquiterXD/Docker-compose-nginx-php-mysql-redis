<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePtpmOnhandLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oapm')->create('ptpm_onhand_log', function (Blueprint $table) {
            $table->increments('onhand_id');
            $table->string('inventory_item_id', 50);
            $table->string('lot_number', 50);
            $table->string('item_type', 50);
            $table->string('report_num', 50);
            $table->float('require_qty',15,2);

            $table->integer('last_updated_by_id');
            $table->integer('last_updated_by');
            $table->datetime('last_update_date')->default(DB::raw('SYSDATE')); // ORACLE
            $table->integer('created_by');
            $table->integer('created_by_id');
            $table->datetime('creation_date')->default(DB::raw('SYSDATE')); // ORACLE
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle_oapm')->dropIfExists('ptpm_onhand_log');
    }
}
