<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldUsesToSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->table('ptw_sub_categories', function (Blueprint $table) {
            $table->boolean('use_in_reim')->default(false);
            $table->boolean('use_in_ca')->default(false);
            $table->boolean('use_all_segments')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle_oaie')->table('ptw_sub_categories', function (Blueprint $table) {
            $table->dropColumn('use_in_reim');
            $table->dropColumn('use_in_ca');
            $table->dropColumn('use_all_segments');
        });
    }
}
