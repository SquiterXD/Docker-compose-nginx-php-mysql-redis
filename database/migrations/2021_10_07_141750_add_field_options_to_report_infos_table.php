<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldOptionsToReportInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oair')->table('ptir_report_infos', function (Blueprint $table) {
            $table->string("attribute_1")->nullable();
            $table->string("attribute_2")->nullable();
            $table->string("attribute_3")->nullable();
            $table->string("attribute_4")->nullable();
            $table->string("attribute_5")->nullable();
            $table->string("attribute_6")->nullable();
            $table->string("attribute_7")->nullable();
            $table->string("attribute_8")->nullable();
            $table->string("attribute_9")->nullable();
            $table->json("option_1")->nullable();
            $table->json("option_2")->nullable();
            $table->json("option_3")->nullable();
            $table->json("option_4")->nullable();
            $table->json("option_5")->nullable();
            $table->json("option_6")->nullable();
            $table->json("option_7")->nullable();
            $table->json("option_8")->nullable();
            $table->json("option_9")->nullable();
            $table->boolean("function_flag")->nullable()->default(false);
            $table->boolean("button_flag")->nullable()->default(false);
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
            $table->dropColumn("attribute_1");
            $table->dropColumn("attribute_2");
            $table->dropColumn("attribute_3");
            $table->dropColumn("attribute_4");
            $table->dropColumn("attribute_5");
            $table->dropColumn("attribute_6");
            $table->dropColumn("attribute_7");
            $table->dropColumn("attribute_8");
            $table->dropColumn("attribute_9");
            $table->dropColumn("option_1");
            $table->dropColumn("option_2");
            $table->dropColumn("option_3");
            $table->dropColumn("option_4");
            $table->dropColumn("option_5");
            $table->dropColumn("option_6");
            $table->dropColumn("option_7");
            $table->dropColumn("option_8");
            $table->dropColumn("option_9");
            $table->dropColumn("function_flag");
            $table->dropColumn("button_flag");
        });
    }
}
