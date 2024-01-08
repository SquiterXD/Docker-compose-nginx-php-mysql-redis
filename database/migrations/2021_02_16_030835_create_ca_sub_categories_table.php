<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->create('ptw_ca_sub_categories', function (Blueprint $table) {
            $table->increments('ca_sub_category_id');

            // $table->string('org_id');
            $table->integer('ca_category_id');
            $table->string('name');
            $table->string('description',2000);
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->string('account_code')->nullable();
            $table->string('sub_account_code')->nullable();
            $table->string('branch_code')->nullable();
            $table->string('department_code')->nullable();
            $table->string('vat_id')->nullable();
            $table->boolean('required_attachment')->default(false);
            $table->boolean('check_ca_min');
            $table->decimal('ca_min_amount',20,8)->nullable();
            $table->boolean('check_ca_max');
            $table->decimal('ca_max_amount',20,8)->nullable();
            $table->boolean('active')->default(true);

            $table->integer('last_updated_by');
            $table->datetime('last_update_date')->default(DB::raw('SYSDATE')); // ORACLE
            $table->integer('created_by');
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
        Schema::connection('oracle_oaie')->dropIfExists('ptw_ca_sub_categories');
    }
}
