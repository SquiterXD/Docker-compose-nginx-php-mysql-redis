<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ct_agencies', function (Blueprint $table) {
            $table->bigIncrements('agency_id');
            $table->string('flex_value_set_id');
            $table->string('agency_code');
            // $table->foreign('agency_code')->references('org_id')->on('ptgl_accounts_info')->onDelete('cascade');
            $table->string('agency_category_name')->nullable();
            $table->boolean('is_active')->nullable()->default(0);
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
        Schema::dropIfExists('ct_agencies');
    }
}
