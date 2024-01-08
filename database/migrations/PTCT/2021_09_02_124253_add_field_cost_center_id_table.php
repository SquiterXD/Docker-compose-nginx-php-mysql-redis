<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldCostCenterIdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = "ptct_std_material_cost_headers";

        Schema::connection('oracle_oact')->table($tableName, function (Blueprint $table) {
            $table->unsignedBigInteger('cost_center_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle_oact')->table('ptct_std_material_cost_headers', function (Blueprint $table) {
            $table->dropColumn('cost_center_id');
        });
    }
}
