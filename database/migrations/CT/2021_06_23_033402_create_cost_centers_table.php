<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostCentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ct_cost_centers', function (Blueprint $table) {
            $table->bigIncrements('cost_center_id');
            $table->string('code');
            $table->string('name');
            $table->unsignedBigInteger('cost_center_category_id');
            $table->foreign('cost_center_category_id')->references('cost_center_category_id')->on('ct_cost_center_categories')->onDelete('cascade');
            $table->decimal('qty', 8, 2)->default(1);
            $table->string('unit_id')->default(1);
            $table->boolean('is_active');
            $table->string('fiscal_year')->nullable();

            $table->integer('last_updated_by')->nullable();
            $table->datetime('last_update_date')->default(DB::raw('SYSDATE'));
            $table->integer('created_by')->nullable();
            $table->datetime('creation_date')->default(DB::raw('SYSDATE'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ct_cost_centers');
    }
}
