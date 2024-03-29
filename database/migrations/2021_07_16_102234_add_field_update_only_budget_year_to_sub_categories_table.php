<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldUpdateOnlyBudgetYearToSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->table('ptw_sub_categories', function (Blueprint $table) {
            $table->boolean('update_only_budget_year')->default(false);
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
            $table->dropColumn('update_only_budget_year');
        });
    }
}
