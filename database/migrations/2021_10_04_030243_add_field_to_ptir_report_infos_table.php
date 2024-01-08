<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToPtirReportInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oair')->table('ptir_report_infos', function (Blueprint $table) {
            $table->json("options")->nullable();
            $table->json("radio")->nullable();
            $table->json("check_box")->nullable();
            $table->json("buttons")->nullable();
            $table->string("function")->nullable();
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
            $table->dropColumn("options");
            $table->dropColumn("radio");
            $table->dropColumn("check_box");
            $table->dropColumn("buttons");
            $table->dropColumn("function");
        });
    }
}
