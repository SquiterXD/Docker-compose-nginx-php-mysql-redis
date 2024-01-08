<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountCodeLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oact')->create('ptct_account_code_ledgers', function (Blueprint $table) {
            $table->bigIncrements('ac_ledger_id');
            $table->string('account_seq');
            $table->string('remark_reason');
            $table->string('res1');
            $table->string('res2');
            $table->integer('last_updated_by')->nullable();
            $table->datetime('last_update_date')->default(DB::raw('SYSDATE'));
            $table->integer('created_by')->nullable();
            $table->datetime('creation_date')->default(DB::raw('SYSDATE'));
        });

        Schema::connection('oracle_oact')->create('ptct_ac_ledger_details', function (Blueprint $table) {
            $table->bigIncrements('ac_ledger_detail_id');
            $table->unsignedBigInteger('ac_ledger_id');
            $table->string('code_segment3');
            $table->string('code_segment4');
            $table->string('organization_code');
            $table->string('item_cat_code');
            $table->integer('product_group_id');
            $table->string('code_segment9');
            $table->string('code_segment10');
            $table->string('code_segment1');
            $table->string('code_segment2');
            $table->string('code_segment6');
            $table->string('code_segment7');
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
        Schema::connection('oracle_oact')->dropIfExists('ptct_account_code_ledgers');
        Schema::connection('oracle_oact')->dropIfExists('ptct_ac_ledger_details');
    }
}
