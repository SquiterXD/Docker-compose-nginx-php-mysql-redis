<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToCashAdvancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->table('ptw_cash_advances', function (Blueprint $table) {
            $table->string('tel')->nullable();
            $table->string('vendor_bank_name')->nullable();
            $table->string('vendor_bank_account_no')->nullable();
            $table->integer('hierarchy_name_id')->nullable();
            $table->integer('hierarchy_name_position_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle_oaie')->table('ptw_cash_advances', function (Blueprint $table) {
            $table->dropColumn('tel');
            $table->dropColumn('vendor_bank_name');
            $table->dropColumn('vendor_bank_account_no');
            $table->dropColumn('hierarchy_setup_id');
            $table->dropColumn('hierarchy_name_position_id');
        });
    }
}
