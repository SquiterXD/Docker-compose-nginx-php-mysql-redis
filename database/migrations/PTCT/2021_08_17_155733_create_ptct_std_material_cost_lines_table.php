<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePtctStdMaterialCostLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = "ptct_std_material_cost_lines";

        Schema::connection('oracle_oact')->create($tableName, function (Blueprint $table) {
            $table->bigIncrements('std_mcl_id');
            $table->string('ITEM_NUMBER');
            $table->string('ITEM_LOT')->nullable();
            $table->string('ITEM_DESCRTIPTION', 240)->nullable();
            $table->decimal('UNIT_COST');
            $table->decimal('FREIGHT_COST')->nullable();
            $table->decimal('SUBTOTAL');
            $table->decimal('MATERIAL_PERCENT')->nullable();
            $table->decimal('DM_STD_UNITCOST');
            $table->date('DATE_FROM')->nullable();
            $table->date('DATE_TO')->nullable();
            $table->string('STATUS');
            $table->integer('CREATED_BY_ID')->nullable();
            $table->integer('UPDATED_BY_ID')->nullable();
            $table->integer('DELETED_BY_ID')->nullable();
            $table->integer('Inventory_item_id')->nullable();
            $table->integer('tran_id')->nullable();
            $table->integer('stg_no')->nullable();
            $table->string('record_status', 1)->nullable();
            $table->string('interface_msg', 4000)->nullable();
            $table->string('program_code', 30)->nullable(); 
            $table->string('error', 4000)->nullable();
            
            $table->string('attribute_category', 30)->nullable();
            $table->string('attribute1', 150)->nullable();
            $table->string('attribute2', 150)->nullable();
            $table->string('attribute3', 150)->nullable();
            $table->string('attribute4', 150)->nullable();
            $table->string('attribute5', 150)->nullable();
            $table->string('attribute6', 150)->nullable();
            $table->string('attribute7', 150)->nullable();
            $table->string('attribute8', 150)->nullable();
            $table->string('attribute9', 150)->nullable();
            $table->string('attribute10', 150)->nullable();
            $table->string('attribute11', 150)->nullable();
            $table->string('attribute12', 150)->nullable();
            $table->string('attribute13', 150)->nullable();
            $table->string('attribute14', 150)->nullable();
            $table->string('attribute15', 150)->nullable();
            // $table->string('program_code', 30)->nullable();
            $table->date('created_at')->default(DB::raw('SYSDATE'));
            $table->date('updated_at')->default(DB::raw('SYSDATE'));
            $table->date('deleted_at')->nullable();
            // $table->integer('created_by_id')->nullable();
            // $table->integer('updated_by_id')->nullable();
            // $table->integer('deleted_by_id')->nullable();
            $table->string('web_batch_no', 50)->nullable();
            $table->string('interface_status', 1)->nullable();
            $table->integer('created_by')->nullable();
            $table->date('creation_date')->default(DB::raw('SYSDATE'));
            $table->integer('last_updated_by')->nullable();
            $table->date('last_update_date')->default(DB::raw('SYSDATE'));
            // $table->integer('tran_id')->nullable();
            // $table->integer('stg_no')->nullable();
            $table->string('file_name', 255)->nullable();
            $table->string('interface_name', 255)->nullable();
            // $table->string('record_status', 1)->nullable(false);
            // $table->string('interface_msg', 4000)->nullable();
        });

        $sql = "ALTER TABLE oact.{$tableName} MODIFY unit_cost NUMBER";
        DB::connection('oracle_oact')->statement($sql);
        $sql = "ALTER TABLE oact.{$tableName} MODIFY freight_cost NUMBER";
        DB::connection('oracle_oact')->statement($sql);
        $sql = "ALTER TABLE oact.{$tableName} MODIFY subtotal NUMBER";
        DB::connection('oracle_oact')->statement($sql);
        $sql = "ALTER TABLE oact.{$tableName} MODIFY material_percent NUMBER";
        DB::connection('oracle_oact')->statement($sql);
        $sql = "ALTER TABLE oact.{$tableName} MODIFY dm_std_unitcost NUMBER";
        DB::connection('oracle_oact')->statement($sql);
        $sql = "ALTER TABLE oact.{$tableName} MODIFY inventory_item_id NUMBER";
        DB::connection('oracle_oact')->statement($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle_oact')->dropIfExists('ptct_std_material_cost_lines');
    }
}
