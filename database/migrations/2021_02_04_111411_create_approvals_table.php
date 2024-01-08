<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->create('ptw_approvals', function (Blueprint $table) {
            $table->increments('approval_id');
            // approver user_id
            $table->integer('user_id');
            // REIMBURSEMENT, CASH-ADVANCE, CLEARING
            $table->string('process_type'); 
            // APPROVER or FINANCE
            $table->string('approver_type'); 
            // Level of Hierarchy for approver_type = 'APPROVER'
            $table->string('hierarchy_level')->nullable(); 
            // reimId or cashAdvanceId
            $table->integer('approvalable_id'); 
            // App\Reimbursement or App\CashAdvance
            $table->string('approvalable_type'); 

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
        Schema::connection('oracle_oaie')->dropIfExists('ptw_approvals');
    }
}
