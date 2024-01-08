<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldDffDistributionToReceiptLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->table('ptw_receipt_lines', function (Blueprint $table) {
            $table->string('distribution_type')->nullable();

            $table->date('distribution_wht_date')->nullable();
            $table->string('distribution_cert_number')->nullable();
            $table->string('distribution_income_type')->nullable();
            $table->string('distribution_income_name')->nullable();

            $table->string('distribution_import_type')->nullable();
            $table->string('distribution_po_number')->nullable();
            $table->string('distribution_ref_number')->nullable();
            $table->string('distribution_expense_type')->nullable();
            $table->string('distribution_shipment')->nullable();

            $table->string('distribution_receipt_number')->nullable();
            $table->date('distribution_receipt_date')->nullable();
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
            $table->dropColumn('distribution_type');

            $table->dropColumn('distribution_wht_date');
            $table->dropColumn('distribution_cert_number');
            $table->dropColumn('distribution_income_type');
            $table->dropColumn('distribution_income_name');

            $table->dropColumn('distribution_import_type');
            $table->dropColumn('distribution_po_number');
            $table->dropColumn('distribution_ref_number');
            $table->dropColumn('distribution_expense_type');
            $table->dropColumn('distribution_shipment');

            $table->dropColumn('distribution_receipt_number');
            $table->dropColumn('distribution_receipt_date');
        });
    }
}
