<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterfaceEncumbrancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->create('ptw_interface_encumbrances', function (Blueprint $table) {
            $table->increments('interface_encumbrance_id');

            // FROM WEB
            $table->string('org_id')->nullable();
            $table->string('operating_unit')->nullable(); // 81
            $table->date('accounting_date');
            $table->string('currency_code', 150);
            $table->string('actual_flag', 1)->nullable();
            $table->string('user_je_category_name', 150)->nullable();
            $table->string('user_je_source_name', 150)->nullable();
            $table->string('batch_name', 150);
            $table->string('journal_name', 150)->nullable();
            $table->string('journal_description_head', 250)->nullable();
            $table->integer('je_line_num');
            $table->string('account_number', 250);
            $table->decimal('accounted_dr',30,8)->nullable();
            $table->decimal('accounted_cr',30,8)->nullable();
            $table->string('user_currency_conversion_type')->nullable();
            $table->decimal('currency_conversion_rate',30,8)->nullable();
            $table->date('currency_conversion_date')->nullable();
            $table->string('journal_description_line', 250);

            $table->string('batch_no', 100)->nullable();
            $table->integer('tran_id')->nullable();
            $table->string('interface_name')->default('PTWEB_UPLOAD_ENCUMBRANCE');

            $table->string('attribute1', 2000)->nullable();
            $table->string('attribute2', 2000)->nullable();
            $table->string('attribute3', 2000)->nullable();
            $table->string('attribute4', 2000)->nullable();
            $table->string('attribute5', 2000)->nullable();
            $table->string('attribute6', 2000)->nullable();
            $table->string('attribute7', 2000)->nullable();
            $table->string('attribute8', 2000)->nullable();
            $table->string('attribute9', 2000)->nullable();
            $table->string('attribute10', 2000)->nullable();

            $table->string('encumbrancable_type')->nullable();
            $table->integer('encumbrancable_id')->nullable();
            $table->string('encumbrance_type')->nullable();
            $table->string('interface_type')->nullable();

            $table->integer('created_by_id');
            $table->string('enc_tran_type', 30)->nullable();

            // RESPONSE FROM INTERFACE
            $table->string('interface_status')->nullable();
            $table->string('interface_message',2000)->nullable();

            $table->string('segment1')->nullable();
            $table->string('segment2')->nullable();
            $table->string('segment3')->nullable();
            $table->string('segment4')->nullable();
            $table->string('segment5')->nullable();
            $table->string('segment6')->nullable();
            $table->string('segment7')->nullable();
            $table->string('segment8')->nullable();
            $table->string('segment9')->nullable();
            $table->string('segment10')->nullable();
            $table->string('segment11')->nullable();
            $table->string('segment12')->nullable();

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
        Schema::connection('oracle_oaie')->dropIfExists('ptw_interface_encumbrances');
    }
}
