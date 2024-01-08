<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashAdvancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->create('ptw_cash_advances', function (Blueprint $table) {
            $table->increments('cash_advance_id');

            $table->string('org_id');
            $table->string('document_no');
            $table->string('clearing_document_no');
            $table->integer('user_id');
            $table->datetime('need_by_date');
            $table->integer('ca_category_id');
            $table->integer('ca_sub_category_id');
            $table->datetime('due_date')->nullable();
            $table->datetime('paid_date')->nullable();
            $table->decimal('amount',20,8);
            $table->string('currency_id');
            $table->string('purpose',2000)->nullable();
            $table->string('status');
            $table->integer('next_approver_id')->nullable();
            $table->integer('finance_approver_id')->nullable();
            $table->integer('next_clearing_approver_id')->nullable();
            $table->integer('clearing_finance_approver_id')->nullable();
            $table->boolean('over_budget')->nullable();
            $table->boolean('exceed_policy')->nullable();
            $table->boolean('manual_payment')->nullable();
            $table->string('payment_method_id')->nullable();

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
        Schema::connection('oracle_oaie')->dropIfExists('ptw_cash_advances');
    }
}
