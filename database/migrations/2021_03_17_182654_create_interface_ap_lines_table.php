<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterfaceApLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->create('ptw_interface_ap_lines', function (Blueprint $table) {
            $table->increments('interface_ap_line_id');

            // FROM WEB
            $table->integer('interface_ap_header_id');
            $table->integer('request_receipt_id')->nullable();
            $table->integer('request_receipt_line_id')->nullable();

            $table->string('receipt_number')->nullable();
            $table->datetime('receipt_date')->nullable();
            
            // INTERFACE TO ORACLE AP
            $table->string('org_id')->nullable();
            $table->string('line_group_number')->nullable();
            $table->string('line_number')->nullable();
            $table->string('description',2000)->nullable();
            $table->string('dist_acct_id')->nullable();
            $table->string('concatenated_segments')->nullable();
            $table->string('invoice_number')->nullable();
            $table->datetime('accounting_date')->nullable();
            $table->decimal('quantity_invoiced',30,8)->nullable();
            $table->decimal('unit_price',30,8)->nullable();
            $table->decimal('line_amt',30,8)->nullable();
            $table->string('inventory_item_id')->nullable();
            $table->string('unit_of_meas_lookup_code')->nullable();
            $table->decimal('wht_amt',30,8)->nullable();
            $table->string('pay_awt_group_id')->nullable();
            $table->decimal('tax_amt',30,8)->nullable();
            $table->string('tax_rate_code')->nullable();
            $table->string('tax_classification_code')->nullable();
            $table->string('tax_regime_code')->nullable();
            $table->string('tax')->nullable();
            $table->string('tax_status_code')->nullable();

            $table->string('establishment_id')->nullable();
            $table->string('establishment_name')->nullable();

            $table->string('actual_vendor_name')->nullable();
            $table->string('actual_vendor_tax_id')->nullable();
            $table->string('actual_vendor_branch_name')->nullable();

            // RESPONSE FROM INTERFACE
            $table->string('interface_status')->nullable();
            $table->string('interface_message',2000)->nullable();

            $table->integer('last_updated_by');
            $table->datetime('last_update_date')->default(DB::raw('SYSDATE')); // ORACLE
            $table->integer('created_by');
            $table->datetime('creation_date')->default(DB::raw('SYSDATE')); // ORACLE
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle_oaie')->dropIfExists('ptw_interface_ap_lines');
    }
}
