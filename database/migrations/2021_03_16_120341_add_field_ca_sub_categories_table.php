<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldCaSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->table('ptw_ca_sub_categories', function (Blueprint $table) {
            $table->string('company_code')->nullable();
            $table->string('evm_code')->nullable();
            $table->string('cost_center_code')->nullable();
            $table->string('budget_year_code')->nullable();
            $table->string('budget_type_code')->nullable();
            $table->string('budget_detail_code')->nullable();
            $table->string('budget_reason_code')->nullable();
            $table->string('reserve1_code')->nullable();
            $table->string('reserve2_code')->nullable();
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
            $table->dropColumn('company_code');
            $table->dropColumn('evm_code');
            $table->dropColumn('cost_center_code');
            $table->dropColumn('budget_year_code');
            $table->dropColumn('budget_type_code');
            $table->dropColumn('budget_detail_code');
            $table->dropColumn('budget_reason_code');
            $table->dropColumn('reserve1_code');
            $table->dropColumn('reserve2_code');
        });
    }
}
