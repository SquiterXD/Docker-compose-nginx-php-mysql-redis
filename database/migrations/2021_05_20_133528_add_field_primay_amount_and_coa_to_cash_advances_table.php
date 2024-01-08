<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldPrimayAmountAndCoaToCashAdvancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->table('ptw_cash_advances', function (Blueprint $table) {
            $table->decimal('primary_amount',20,8)->nullable();
            $table->string('concatenated_segments')->nullable();
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
            $table->dropColumn('primary_amount');
            $table->dropColumn('concatenated_segments');
        });
    }
}
