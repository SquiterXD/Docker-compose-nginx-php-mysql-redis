<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeTypeInPtctStdRmCostHeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = 'ptct_std_rm_cost_heads';

        $sql = "ALTER TABLE oact.{$tableName} MODIFY total_rw_cost_per_baht NUMBER";
        DB::connection('oracle_oact')->statement($sql);
        $sql = "ALTER TABLE oact.{$tableName} MODIFY total_cost_per_unit NUMBER";
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
            $table->decimal('total_rm_cost_per_baht')->change();
            $table->decimal('total_cost_per_unit')->change();
        });
    }
}
