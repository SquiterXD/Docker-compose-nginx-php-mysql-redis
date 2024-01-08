<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToCtProductGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ct_product_groups', function (Blueprint $table) {
            $table->string('unit_group_code')->after('NAME')->nullable();
            $table->decimal('ratio', 10, 2)->after('NAME')->nullable();
            $table->string('unit_cost_center_code')->after('NAME')->nullable();
            $table->integer('width')->after('NAME')->nullable();
            $table->integer('long')->after('NAME')->nullable();
            $table->integer('around')->after('NAME')->nullable();
            $table->decimal('area', 10, 2)->after('NAME')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ct_product_groups', function (Blueprint $table) {
            $table->dropColumn('unit_group_code');
            $table->dropColumn('ratio');
            $table->dropColumn('unit_cost_center_code');
            $table->dropColumn('width');
            $table->dropColumn('long');
            $table->dropColumn('around');
            $table->dropColumn('area');
        });
    }
}
