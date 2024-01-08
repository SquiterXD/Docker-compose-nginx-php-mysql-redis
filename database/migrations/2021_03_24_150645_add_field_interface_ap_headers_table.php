<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldInterfaceApHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->table('ptw_interface_ap_headers', function (Blueprint $table) {
            $table->string('invoice_batch')->nullable();
            $table->string('document_category')->nullable();
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
            $table->dropColumn('invoice_batch');
            $table->dropColumn('document_category');
        });
    }
}
