<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterfaceApHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->create('ptw_interface_ap_headers', function (Blueprint $table) {
            $table->increments('interface_ap_header_id');

            // FROM WEB
            $table->string('request_type'); // REIMBURSEMENT, CASH-ADVANCE, CLEARING
            $table->integer('request_id'); 

            // INTERFACE TO ORACLE AP
            $table->string('org_id')->nullable();
            $table->string('description',2000)->nullable();
            $table->datetime('due_date')->nullable();
            $table->datetime('invoice_date')->nullable();
            $table->datetime('gl_date')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('apply_invoice_number')->nullable();
            $table->string('vendor_id')->nullable();
            $table->string('vendor_site_id')->nullable();
            $table->string('currency')->nullable();
            $table->string('invoice_type')->nullable();
            $table->string('payment_method_code')->nullable();
            $table->string('term_id')->nullable();
            $table->decimal('invoice_amount',30,8)->nullable();
            $table->string('accts_pay_code_combination_id')->nullable();

            $table->string('tax_flag')->nullable(); // [ Y | N ]
            $table->string('doc_flag')->nullable(); // [ Y | N ]

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
        Schema::connection('oracle_oaie')->dropIfExists('ptw_interface_ap_headers');
    }
}
