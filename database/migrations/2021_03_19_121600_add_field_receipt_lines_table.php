<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldReceiptLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->table('ptw_receipt_lines', function (Blueprint $table) {
            $table->boolean('wht_flag')->default(false);
            $table->string('wht_cert')->nullable();
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
            $table->dropColumn('wht_flag');
            $table->dropColumn('wht_cert');
        });
    }
}
