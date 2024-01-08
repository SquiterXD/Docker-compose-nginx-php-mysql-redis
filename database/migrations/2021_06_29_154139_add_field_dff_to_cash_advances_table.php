<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldDffToCashAdvancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->table('ptw_cash_advances', function (Blueprint $table) {
            $table->string('dff_type', 150)->nullable();
            $table->string('dff_pay_for', 150)->nullable();
            $table->string('dff_group_tax_code', 150)->nullable();
            $table->string('clearing_dff_type', 150)->nullable();
            $table->string('clearing_dff_pay_for', 150)->nullable();
            $table->string('clearing_dff_group_tax_code', 150)->nullable();
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
            $table->dropColumn('dff_type');
            $table->dropColumn('dff_pay_for');
            $table->dropColumn('dff_group_tax_code');
            $table->dropColumn('clearing_dff_type');
            $table->dropColumn('clearing_dff_pay_for');
            $table->dropColumn('clearing_dff_group_tax_code');
        });
    }
}
