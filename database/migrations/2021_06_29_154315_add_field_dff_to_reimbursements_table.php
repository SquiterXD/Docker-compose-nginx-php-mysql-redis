<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldDffToReimbursementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->table('ptw_reimbursements', function (Blueprint $table) {
            $table->string('dff_type', 150)->nullable();
            $table->string('dff_pay_for', 150)->nullable();
            $table->string('dff_group_tax_code', 150)->nullable();
            $table->string('dff_tax_invoice_number', 150)->nullable();
            $table->date('dff_tax_invoice_date')->nullable();
            $table->string('dff_po_ref_number', 150)->nullable();
            $table->string('dff_paid_number', 150)->nullable();
            $table->string('dff_address', 150)->nullable();
            $table->string('dff_branch_number', 150)->nullable();
            $table->string('dff_tax_id', 150)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle_oaie')->table('ptw_reimbursements', function (Blueprint $table) {
            $table->dropColumn('dff_type');
            $table->dropColumn('dff_pay_for');
            $table->dropColumn('dff_group_tax_code');
            $table->dropColumn('dff_tax_invoice_number');
            $table->dropColumn('dff_tax_invoice_date');
            $table->dropColumn('dff_po_ref_number');
            $table->dropColumn('dff_paid_number');
            $table->dropColumn('dff_address');
            $table->dropColumn('dff_branch_number');
            $table->dropColumn('dff_tax_id');
        });
    }
}
