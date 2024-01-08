<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePtctSetAccountDept extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::connection('oracle_oact')->create('ptct_set_account_dept', function (Blueprint $table) {
            $table->bigIncrements('set_account_dept_id');
            $table->string('acc_code')->comment('FK, รหัสบัญขี (ptct_set_account_types.acc_code)');
            $table->string('depte_code')->comment('FK, รหัสหน่วยงาน (ptgl_coa_dept_code_v.department_code)');
            $table->string('acc_group')->nullable()->comment('FK, รหัสประเภทบัญชี (PTCT_CC_GROUP_V)');
            $table->boolean('is_active')->nullable()->default(0);
            $table->integer('last_updated_by')->nullable();
            $table->datetime('last_update_date')->default(DB::raw('SYSDATE'));
            $table->integer('created_by')->nullable();
            $table->datetime('creation_date')->default(DB::raw('SYSDATE'));

            $table->unique(['acc_code', 'depte_code']);
        });

        $sql = "create synonym apps.ptct_set_account_dept for oact.ptct_set_account_dept";
        DB::connection('oracle')->statement($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle_oact')->dropIfExists('ptct_set_account_dept');

        $sql = "DROP SYNONYM apps.ptct_set_account_dept";
        DB::connection('oracle')->statement($sql);
    }
}
