<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePtomPaoTaxMtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaom')->create('ptom_pao_tax_mt', function (Blueprint $table) {

            $table->unsignedDecimal('pao_tax_mt_id', 20, 0)->autoIncrement();

            $table->integer('year');
            $table->integer('month_no');
            $table->string('file_name', 1000);
            $table->string('path_name', 1000);
            $table->datetime('action_date')->nullable();
            $table->string('action_flag', 20)->nullable();
            $table->unsignedDecimal('customer_id', 20, 0)->nullable();
            $table->string('customer_number', 100)->nullable();
            $table->unsignedDecimal('province_id', 20, 0)->nullable();
            $table->string('province_name', 100)->nullable();
            $table->unsignedDecimal('item_id', 20, 0)->nullable();
            $table->string('item_code', 100)->nullable();
            $table->unsignedDecimal('quantity_cg', 30, 0)->nullable();
            $table->decimal('pao_amount_by_pv', 30, 4)->nullable();
            $table->decimal('pao_amount', 30, 4)->nullable();
            $table->decimal('adjust_amount', 30, 4)->nullable();
            $table->decimal('dif_amount', 30, 4)->nullable();

            $table->string('program_code', 150);
            $table->unsignedDecimal('created_by', 20, 0);
            $table->datetime('creation_date')->default(DB::raw('SYSDATE')); // ORACLE
            $table->unsignedDecimal('last_updated_by', 20, 0);
            $table->datetime('last_update_date')->default(DB::raw('SYSDATE')); // ORACLE
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedDecimal('created_by_id', 20, 0)->nullable();
            $table->unsignedDecimal('updated_by_id', 20, 0)->nullable();
            $table->unsignedDecimal('deleted_by_id', 20, 0)->nullable();

            $table->string('ap_web_batch_no', 50)->nullable();
            $table->string('ap_interfaced_msg', 4000)->nullable();
            $table->string('ap_interface_status', 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle_oaom')->dropIfExists('ptom_pao_tax_mt');
    }
}
