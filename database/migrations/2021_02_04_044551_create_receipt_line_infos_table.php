<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptLineInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->create('ptw_receipt_line_infos', function (Blueprint $table) {
            $table->increments('receipt_line_info_id');

            $table->integer('receipt_id');
            $table->integer('receipt_line_id');
            $table->integer('sub_category_id');
            $table->integer('sub_category_info_id');
            $table->string('description',2000)->nullable();

            $table->softDeletes();
            $table->integer('last_updated_by');
            $table->datetime('last_update_date')->default(DB::raw('SYSDATE')); // ORACLE
            $table->integer('created_by');
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
        Schema::connection('oracle_oaie')->dropIfExists('ptw_receipt_line_infos');
    }
}
