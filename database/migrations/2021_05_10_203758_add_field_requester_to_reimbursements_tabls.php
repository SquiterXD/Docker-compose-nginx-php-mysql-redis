<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldRequesterToReimbursementsTabls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->table('ptw_reimbursements', function (Blueprint $table) {
            $table->string('requester_id')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_no')->nullable();
            $table->string('position_name')->nullable();
            $table->string('account_name')->nullable();
            $table->string('department_code')->nullable();
            $table->string('employee_id')->nullable();
            $table->string('pay_to_emp')->nullable();
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
            $table->dropColumn('requester_id');
            $table->dropColumn('bank_name');
            $table->dropColumn('account_no');
            $table->dropColumn('position_name');
            $table->dropColumn('account_name');
            $table->dropColumn('department_code');
            $table->dropColumn('employee_id');
            $table->dropColumn('pay_to_emp');
        });
    }
}
