<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldFundsToReceiptLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->table('ptw_receipt_lines', function (Blueprint $table) {
            $table->decimal('budget_amount',30,8)->nullable();
            $table->decimal('encumbrance_amount',30,8)->nullable();
            $table->decimal('actual_amount',30,8)->nullable();
            $table->decimal('fund_available',30,8)->nullable();
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
            $table->dropColumn('budget_amount');
            $table->dropColumn('encumbrance_amount');
            $table->dropColumn('actual_amount');
            $table->dropColumn('fund_available');
        });
    }
}
