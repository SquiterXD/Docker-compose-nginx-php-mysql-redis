<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->create('ptw_receipt_lines', function (Blueprint $table) {
            $table->increments('receipt_line_id');

            $table->integer('receipt_id');
            $table->integer('category_id');
            $table->integer('sub_category_id');
            
            $table->string('branch_code');
            $table->string('department_code');
            // $table->string('description')->nullable(); // 
            $table->integer('policy_id')->nullable(); // ALLOW NULL FOR CASE NOT USE POLICY
            $table->integer('rate_id')->nullable(); // ALLOW NULL FOR CASE NOT USE POLICY
            $table->integer('quantity');
            $table->integer('second_quantity');
            $table->integer('transaction_quantity'); 
            // ====== MILEAGE =======
            $table->integer('mileage_unit_id')->nullable();
            $table->decimal('mileage_distance',30,8)->nullable();
            $table->decimal('mileage_start',30,8)->nullable();
            $table->decimal('mileage_end',30,8)->nullable();
            // =================================
            // ========= TAX & AMOUNT ==========
            // =================================
            // $table->string('currency_id'); // GET FROM RECEIPT HEADER INSTEAD
            $table->string('wht_id')->nullable();
            $table->decimal('wht_amount',30,8)->nullable();
            $table->decimal('primary_wht_amount',30,8)->nullable();
            $table->string('vat_id')->nullable();
            $table->decimal('vat_amount',30,8)->nullable();
            $table->decimal('primary_vat_amount',30,8)->nullable();

            $table->decimal('amount',30,8);
            $table->decimal('amount_inc_vat',30,8); 
            $table->decimal('total_amount',30,8);
            $table->decimal('total_amount_inc_vat',30,8); 
            // PRIMARY => CAL WITH EXCHANGE RATE (FROM RECEIPT HEADER) TO BASE CURRENCY (USE FOR VALIDATE TOTAL)
            $table->decimal('primary_amount',30,8);
            $table->decimal('primary_amount_inc_vat',30,8); 
            $table->decimal('total_primary_amount',30,8);
            $table->decimal('total_primary_amount_inc_vat',30,8); 
            // =================================
            $table->string('concatenated_segments')->nullable();
            $table->string('code_combination_id')->nullable();
            
            $table->softDeletes();
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
        Schema::connection('oracle_oaie')->dropIfExists('ptw_receipt_lines');
    }
}
