<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCtCostCenterProductionProcessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ct_cc_production_processes', function (Blueprint $table) {
            $table->bigIncrements('cc_production_process_id');
            $table->unsignedBigInteger('cost_center_id');
            $table->foreign('cost_center_id')->references('cost_center_id')->on('ct_cost_centers')->onDelete('cascade');
            $table->string('production_process_code')->nullable();
            $table->string('production_process_name')->nullable();
            $table->decimal('percen_of_wage', 5, 2)->default(0);
            $table->decimal('percen_of_cp_vc', 5, 2)->default(0);
            $table->decimal('percen_of_cp_fe', 5, 2)->default(0);
            $table->integer('last_updated_by')->nullable();
            $table->datetime('last_update_date')->default(DB::raw('SYSDATE'));
            $table->integer('created_by')->nullable();
            $table->datetime('creation_date')->default(DB::raw('SYSDATE'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ct_cost_center_production_processes');
    }
}
