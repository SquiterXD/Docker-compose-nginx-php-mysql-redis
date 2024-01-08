<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->table('ptw_approvals', function (Blueprint $table) {
            $table->string('hierarchy_name')->nullable();
            $table->string('hierarchy_position_name')->nullable();
            $table->boolean('last_approval')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle_oaie')->table('ptw_approvals', function (Blueprint $table) {
            $table->dropColumn('hierarchy_name');
            $table->dropColumn('hierarchy_position_name');
            $table->dropColumn('last_approval');
        });
    }
}
