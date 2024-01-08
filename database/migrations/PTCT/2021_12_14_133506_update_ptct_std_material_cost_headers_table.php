<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePtctStdMaterialCostHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oact')->table('ptct_std_material_cost_headers', function (Blueprint $table) {
            $table->renameColumn('std_mch_id', 'std_head_id');
            $table->renameColumn('ef_year', 'period_year');
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
            $table->renameColumn('std_head_id', 'std_mch_id');
            $table->renameColumn('period_year', 'ef_year');
        });
    }
}
