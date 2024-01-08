<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePtctSetAccountTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oact')->create('ptct_set_account_types', function (Blueprint $table) {
            $table->bigIncrements('set_account_type_id');
            $table->string('acc_code')->unique('acc_code')->comment('รหัสบัญขี (ptgl_coa_sub_account_v.main_account||sub_account ACC_CODE)');
            $table->string('acc_group')->nullable()->comment('FK, รหัสประเภท (PTCT_CC_GROUP_V)');
            $table->string('is_transfer')->default(0)->comment('บัญชีรับโอน');
            $table->integer('last_updated_by')->nullable();
            $table->datetime('last_update_date')->default(DB::raw('SYSDATE'));
            $table->integer('created_by')->nullable();
            $table->datetime('creation_date')->default(DB::raw('SYSDATE'));
        });

        $sql = "create synonym apps.ptct_set_account_types for oact.ptct_set_account_types";
        DB::connection('oracle')->statement($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle_oact')->dropIfExists('ptct_set_account_types');

        $sql = "DROP SYNONYM apps.ptct_set_account_types";
        DB::connection('oracle')->statement($sql);
    }
}
