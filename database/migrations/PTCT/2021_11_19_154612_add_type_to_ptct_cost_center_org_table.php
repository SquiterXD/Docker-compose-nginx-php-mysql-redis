<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToPtctCostCenterOrgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = "ptct_cost_center_org";
        Schema::connection('oracle_oact')->table($tableName, function (Blueprint $table) {
            $table->string('type')->default('INV_ORG')->after('org_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle_oact')->table('ptct_cost_center_org', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
