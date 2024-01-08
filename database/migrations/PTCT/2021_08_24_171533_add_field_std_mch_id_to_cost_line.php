<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldStdMchIdToCostLine extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = "ptct_std_material_cost_lines";

        Schema::connection('oracle_oact')->table($tableName, function (Blueprint $table) {
            $table->unsignedBigInteger('std_mch_id')->after('std_mcl_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle_oact')->table('ptct_std_material_cost_lines', function (Blueprint $table) {
            $table->dropColumn('std_mch_id');
        });
    }
}
