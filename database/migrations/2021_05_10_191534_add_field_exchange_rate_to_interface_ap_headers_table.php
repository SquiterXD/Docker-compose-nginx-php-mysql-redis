<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldExchangeRateToInterfaceApHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->table('ptw_interface_ap_headers', function (Blueprint $table) {
            $table->string('exchange_rate')->nullable();
            $table->date('rate_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle_oaie')->table('ptw_interface_ap_headers', function (Blueprint $table) {
            $table->dropColumn('exchange_rate');
            $table->dropColumn('rate_date');
        });
    }
}
