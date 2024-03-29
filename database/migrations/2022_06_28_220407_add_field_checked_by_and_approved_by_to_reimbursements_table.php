<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldCheckedByAndApprovedByToReimbursementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->table('ptw_reimbursements', function (Blueprint $table) {
            $table->string('checked_by')->nullable();
            $table->string('approved_by')->nullable();
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
            $table->dropColumn('checked_by');
            $table->dropColumn('approved_by');
        });
    }
}
