<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManchineYearlyLinesTable extends Migration
{
    public function up()
    {
        Schema::connection('oracle_oapp')->create('ptpp_machine_yearly_lines', function (Blueprint $table) {
            $table->increments('res_plan_l_id');
            $table->integer('res_plan_h_id');
            $table->integer('working_hour');
            $table->string('machine_name');
            $table->string('machine_eam_status')->nullable();
            $table->integer('machine_eamperformance');
            $table->integer('efficiency_machine_per_min');
            $table->integer('machine_speed');
            $table->float('efficiency_product_per_min', 8, 4);
            $table->float('efficiency_product_full', 8, 4);
            $table->date('res_plan_date'); //วดป
            $table->string('res_plan_date_display')->nullable();
            $table->string('holiday_flag')->nullable();
            $table->string('eam_dt_flag')->nullable();
            $table->string('eam_pm_flag')->nullable();
            $table->float('eam_dt_eff_product', 8, 4)->nullable();
            $table->float('eam_pm_efy_product', 8, 4)->nullable();
            $table->float('eam_pm_eff_product', 8, 4)->nullable();
            $table->string('program_code');
            $table->timestamps();
            $table->date('deleted_at')->nullable();
            $table->integer('created_by_id');
            $table->integer('updated_by_id')->nullable();
            $table->integer('deleted_by_id')->nullable();
            $table->integer('created_by');
            $table->date('creation_date');
            $table->date('last_update_date')->nullable();
            $table->integer('last_updated_by')->nullable();
            $table->integer('last_update_login')->nullable();
        });
    }

    public function down()
    {
        Schema::connection('oracle_oapp')->dropIfExists('ptpp_machine_yearly_lines');
    }
}
