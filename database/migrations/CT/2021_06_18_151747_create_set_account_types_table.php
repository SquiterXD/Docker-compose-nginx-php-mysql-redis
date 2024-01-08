<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetAccountTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ct_set_account_types', function (Blueprint $table) {
            $table->bigIncrements('set_account_type_id');
            // $table->string('acc_code');
            $table->string('acc_code');
            // $table->foreign('acc_code')->references('flex_value')->on('ptgl_coa_v')->onDelete('cascade');
            $table->string('acc_category_name')->nullable();
            $table->string('is_transfer')->nullable()->default(0);
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
        Schema::dropIfExists('ct_set_account_types');
    }
}
