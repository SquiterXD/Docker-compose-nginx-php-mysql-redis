<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oact')->create('ptct_accounts', function (Blueprint $table) {
            $table->bigIncrements('account_id');
            $table->string('seq');
            $table->string('name');
            $table->integer('last_updated_by')->nullable();
            $table->datetime('last_update_date')->default(DB::raw('SYSDATE'));
            $table->integer('created_by')->nullable();
            $table->datetime('creation_date')->default(DB::raw('SYSDATE'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle_oact')->dropIfExists('ptct_accounts');
    }
}
