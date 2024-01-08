<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePtpmItemCatImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oapm')->create('ptpm_item_cat_images', function (Blueprint $table) {
            $table->increments('ptpm_item_cat_images_id');
            $table->integer('organization_id');
            $table->string('organization_code', 100);
            $table->integer('item_cat_code');
            $table->string('item_cat_path', 255);

            $table->integer('last_updated_by_id');
            $table->integer('last_updated_by');
            $table->datetime('last_update_date')->default(DB::raw('SYSDATE')); // ORACLE
            $table->integer('created_by');
            $table->integer('created_by_id');
            $table->datetime('creation_date')->default(DB::raw('SYSDATE')); // ORACLE
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ptpm_item_cat_images');
    }
}
