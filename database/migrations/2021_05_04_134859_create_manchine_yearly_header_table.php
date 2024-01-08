<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManchineYearlyHeaderTable extends Migration
{
    public function up()
    {
        Schema::connection('oracle_oapp')->create('ptpp_machine_yearly_headers', function (Blueprint $table) {
            $table->increments('res_plan_h_id');
            $table->integer('budget_year'); //พศ
            $table->integer('period_year'); //คศ
            $table->string('period_name');
            $table->integer('period_num');
            $table->integer('efficiency_machine')->nullable();
            $table->integer('efficiency_product');
            $table->string('product_type');
            $table->string('product_type_name');
            $table->string('step_num');
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
            $table->string('note_description', 250)->nullable();
        });
    }

    public function down()
    {
        Schema::connection('oracle_oapp')->dropIfExists('ptpp_machine_yearly_headers');
    }
}
