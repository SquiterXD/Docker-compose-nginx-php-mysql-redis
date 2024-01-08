<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldBudgetStatusAndBudgetStatusMsgToReceiptLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->table('ptw_receipt_lines', function (Blueprint $table) {
            $table->string('budget_status')->nullable();
            $table->string('budget_status_msg')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle_oaie')->table('ptw_receipt_lines', function (Blueprint $table) {
            $table->dropColumn('budget_status');
            $table->dropColumn('budget_status_msg');
        });
    }
}
