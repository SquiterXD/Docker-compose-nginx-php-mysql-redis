<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeTypeInPtctStdRmCostLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'ptct_std_rm_cost_lines';

        $sql = "ALTER TABLE oact.{$tableName} MODIFY ingredients_qty NUMBER";
        DB::connection('oracle_oact')->statement($sql);
        $sql = "ALTER TABLE oact.{$tableName} MODIFY standard_cost_per_unit NUMBER";
        DB::connection('oracle_oact')->statement($sql);
        $sql = "ALTER TABLE oact.{$tableName} MODIFY total_raw_material_cost NUMBER";
        DB::connection('oracle_oact')->statement($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle_oact')->table('ptct_std_rm_cost_lines', function (Blueprint $table) {
            $table->decimal('ingredients_qty')->change();
            $table->decimal('standard_cost_per_unit')->change();
            $table->decimal('total_raw_material_cost')->change();
        });
    }
}
