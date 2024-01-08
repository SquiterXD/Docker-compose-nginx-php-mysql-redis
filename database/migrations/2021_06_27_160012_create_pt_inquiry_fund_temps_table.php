<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePtInquiryFundTempsTable extends Migration
{
    protected $tableName;
    public function __construct() {
        $this->tableName = 'pt_inquiry_fund_temps';
    }
    public function up()
    {
        Schema::connection('oracle_toat')->create($this->tableName, function (Blueprint $table) {
            $table->increments('trans_id');
            $table->integer('code_combination_id');
            $table->string('concatenated_segments', 500);
            $table->string('description_segments', 4000);
            $table->double('budget_amount', 20, 2);
            $table->double('encumbrance_amount', 20, 2);
            $table->double('actual_amount', 20, 2);
            $table->double('funds_available_amount', 20, 2);
            $table->double('req_encumbrance_amount', 20, 2);
            $table->double('po_encumbrance_amount', 20, 2);
            $table->double('other_encumbrance_amount', 20, 2);
            $table->string('segment1');
            $table->string('segment2');
            $table->string('segment3');
            $table->string('segment4');
            $table->string('segment5');
            $table->string('segment6');
            $table->string('segment7');
            $table->string('segment8');
            $table->string('segment9');
            $table->string('segment10');
            $table->string('segment11');
            $table->string('segment12');
            $table->string('SUMMARY_FLAG')->nullable();
            // $table->timestamps();
            $table->integer('created_by_id');
            $table->integer('updated_by_id')->nullable();
            $table->integer('created_by');
            $table->date('creation_date');
            $table->date('last_update_date')->nullable();
            $table->integer('last_updated_by')->nullable();
            $table->integer('last_update_login')->nullable();
        });
        $sql = "create synonym apps.{$this->tableName} for toat.{$this->tableName}";
        DB::connection('oracle')->statement($sql);
    }

    public function down()
    {
        Schema::connection('oracle_toat')->dropIfExists($this->tableName);
        $sql = "DROP SYNONYM apps.{$this->tableName}";
        DB::connection('oracle')->statement($sql);
    }
}
