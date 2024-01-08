<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldDatesAndReasonToCashAdvancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->table('ptw_cash_advances', function (Blueprint $table) {
            $table->string('reason')->nullable();
            $table->date('request_date')->nullable();
            $table->date('gl_date')->nullable();
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
            $table->dropColumn('reason');
            $table->dropColumn('request_date');
            $table->dropColumn('gl_date');
        });
    }
}
