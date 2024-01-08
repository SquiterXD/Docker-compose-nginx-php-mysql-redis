<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->create('ptw_receipts', function (Blueprint $table) {
            $table->increments('receipt_id');

            $table->integer('receiptable_id');
            $table->string('receiptable_type');

            $table->string('receipt_number')->nullable();
            $table->datetime('receipt_date')->nullable();
            $table->string('location_id');
            $table->string('vendor_id')->nullable();
            $table->string('vendor_name')->nullable();
            $table->string('vendor_tax_id')->nullable();
            $table->string('vendor_branch_name')->nullable();
            $table->string('establishment_id')->nullable();
            $table->string('establishment_name')->nullable();
            $table->string('currency_id');
            $table->decimal('exchange_rate',20,8)->nullable();
            $table->string('jusification',2000)->nullable();
            $table->string('job')->nullable();
            $table->string('project')->nullable();
            $table->string('recharge')->nullable();
            $table->string('status')->nullable(); // may be use

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
        Schema::connection('oracle_oaie')->dropIfExists('ptw_receipts');
    }
}
