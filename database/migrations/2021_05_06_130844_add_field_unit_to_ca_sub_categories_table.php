<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldUnitToCaSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->table('ptw_ca_sub_categories', function (Blueprint $table) {
            $table->boolean('use_second_unit')->default(false);
            $table->string('unit')->nullable();
            $table->string('second_unit')->nullable();
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
            $table->dropColumn('use_second_unit');
            $table->dropColumn('unit');
            $table->dropColumn('second_unit');
        });
    }
}
