<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePtirReportInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oair')->create('ptir_report_infos', function (Blueprint $table) {
            $table->increments('report_info_id');
            // $table->string('org_id');
            $table->integer('seq');
            $table->string('program_code');
            $table->string('attribute_name');
            $table->text('purpose')->nullable();
            $table->string('form_type'); // text,select,date,check
            $table->string('form_value')->nullable();
            $table->boolean('required');
            $table->boolean('active')->default(true);
            $table->string('is_primary_info')->nullable(); // [ Y | N ]

            $table->integer('last_updated_by');
            $table->datetime('last_update_date')->default(DB::raw('SYSDATE')); // ORACLE
            $table->integer('created_by');
            $table->datetime('creation_date')->default(DB::raw('SYSDATE')); // ORACLE
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle_oair')->dropIfExists('ptir_report_infos');
    }
}
