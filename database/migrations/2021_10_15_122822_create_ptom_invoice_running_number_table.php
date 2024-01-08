<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePtomInvoiceRunningNumberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaom')->create('ptom_invoice_running_number', function (Blueprint $table) {
            $table->increments('invoice_running_number_id');

            $table->string('prefix'); 
            $table->bigInteger('current_number');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle_oaom')->dropIfExists('ptom_invoice_running_number');
    }
}
