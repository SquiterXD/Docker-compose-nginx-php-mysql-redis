<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;

class CreateCostCenterOrgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oact')->create('ptct_cost_center_org', function (Blueprint $table) {
            $table->bigIncrements('cost_center_org_id');
            $table->unsignedBigInteger('cost_center_id');
            $table->foreign('cost_center_id')->references('cost_center_id')->on('ptct_cost_centers')->onDelete('cascade');
            $table->string('org_code');
            $table->string('description', 4000);

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
        Schema::connection('oracle_oact')->dropIfExists('ptct_cost_center_org');
    }
}
