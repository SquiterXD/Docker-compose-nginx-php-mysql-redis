<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePtpmRawMaterialRrN extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oapm')->create('ptpm_raw_mtl_rr_n', function (Blueprint $table) {
            $table->increments('ptpm_raw_mtl_id');
            $table->string('machine_set',20);
            $table->string('item_no',50);
            $table->integer('item_cat_code');
            $table->integer('remaining_amount')->nullable();
            $table->string('uom',50)->nullable();
            $table->string('record_type', 30);
            $table->integer('organization_id');
            $table->integer('flag')->default(0);
            $table->string('organization_code', 100);

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
        Schema::dropIfExists('ptpm_raw_mtl_rr_n');
    }
}
