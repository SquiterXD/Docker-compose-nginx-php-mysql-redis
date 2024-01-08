<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToPtirReportInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oair')->table('ptir_report_infos', function (Blueprint $table) {
            $table->string('view_or_table')->nullable();
            $table->string('field_value')->nullable();
            $table->string('field_description')->nullable();
            $table->string('group_by')->nullable();
            $table->string('order_by')->nullable();
            $table->string('default_value')->nullable();
            $table->string('display_value')->nullable();
            $table->string('date_type')->nullable();
            $table->string('report_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle_oair')->table('ptir_report_infos', function (Blueprint $table) {
            $table->dropColumn('view_or_table');
            $table->dropColumn('field_value');
            $table->dropColumn('field_description');
            $table->dropColumn('group_by');
            $table->dropColumn('order_by');
            $table->dropColumn('default_value');
            $table->dropColumn('display_value');
            $table->dropColumn('date_type');
            $table->dropColumn('report_type');
        });
    }
}
