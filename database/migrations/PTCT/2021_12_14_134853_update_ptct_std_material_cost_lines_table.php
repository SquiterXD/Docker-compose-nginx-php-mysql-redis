<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePtctStdMaterialCostLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oact')->table('ptct_std_material_cost_lines', function (Blueprint $table) {
            $table->renameColumn('std_mch_id', 'std_head_id');
            $table->renameColumn('std_mcl_id', 'std_line_id');
            $table->renameColumn('item_lot', 'lot_number');
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
            $table->renameColumn('std_head_id', 'std_mch_id');
            $table->renameColumn('std_line_id', 'std_mcl_id');
            $table->renameColumn('lot_number', 'item_lot');
        });
    }
}
