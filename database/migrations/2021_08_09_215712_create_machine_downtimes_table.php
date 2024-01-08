<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachineDowntimesTable extends Migration
{
    public function __construct() {
        $this->tableName = 'ptpp_machine_downtimes';
    }

    public function up()
    {
        Schema::connection('oracle_oapp')->create($this->tableName, function (Blueprint $table) {
            $table->increments('downtime_id');
            $table->integer('res_plan_h_id');
            $table->integer('line_no');
            $table->integer('biweekly_id')->nullable();
            $table->integer('budget_year');
            $table->string('product_type');
            $table->string('machine_group');
            $table->string('machine_name');
            $table->string('machine_description');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('program_code');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by_id');
            $table->integer('updated_by_id')->nullable();
            $table->integer('deleted_by_id')->nullable();
            $table->integer('created_by');
            $table->date('creation_date');
            $table->date('last_update_date')->nullable();
            $table->integer('last_updated_by')->nullable();
            $table->integer('last_update_login')->nullable();
        });
        $sql = "create synonym apps.{$this->tableName} for oapp.{$this->tableName}";
        DB::connection('oracle')->statement($sql);
    }

    public function down()
    {
        Schema::connection('oracle_oapp')->dropIfExists($this->tableName);
        $sql = "DROP SYNONYM apps.{$this->tableName}";
        DB::connection('oracle')->statement($sql);
    }
}
