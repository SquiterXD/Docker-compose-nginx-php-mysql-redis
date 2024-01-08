<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->create('ptw_user_accounts', function (Blueprint $table) {
            $table->increments('user_account_id');

            $table->integer('user_id')->nullable();
            $table->string('code');
            $table->string('employee_number');
            $table->string('employee_name');
            $table->string('bank_code');
            $table->string('bank_name');
            $table->string('branch_number')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('account_name');
            $table->string('account_number');
            $table->string('bank_account');
            $table->boolean('default_flag')->default(false);
            $table->string('account_type')->default('MANUAL');
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
        Schema::connection('oracle_oaie')->dropIfExists('ptw_user_accounts');
    }
}
