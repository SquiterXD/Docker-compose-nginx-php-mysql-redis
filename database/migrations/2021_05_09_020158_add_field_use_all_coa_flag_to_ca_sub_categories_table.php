<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldUseAllCoaFlagToCaSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->table('ptw_ca_sub_categories', function (Blueprint $table) {
            $table->string('use_all_coa_flag')->default('N');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle_oaie')->table('ptw_ca_sub_categories', function (Blueprint $table) {
            $table->dropColumn('use_all_coa_flag');
        });
    }
}
