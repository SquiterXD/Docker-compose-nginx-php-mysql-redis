<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldReasonAndGlDateToReimbursementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->table('ptw_reimbursements', function (Blueprint $table) {
            $table->string('reason')->nullable();
            $table->date('gl_date')->nullable();
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
            $table->dropColumn('reason');
            $table->dropColumn('gl_date');
        });
    }
}
