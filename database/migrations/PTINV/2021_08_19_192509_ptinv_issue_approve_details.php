<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PtinvIssueApproveDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oainv')->create('ptinv_issue_approve_details', function (Blueprint $table) {
            $table->increments('issue_approve_id');
            $table->integer('issue_detail_id');
            $table->integer('inventory_item_id');
            $table->string('locator');
            $table->string('lot_number');
            $table->decimal('quantity', 14, 2);
            $table->string('attribute_category', 30)->nullable();
            $table->string('attribute1', 150)->nullable();
            $table->string('attribute2', 150)->nullable();
            $table->string('attribute3', 150)->nullable();
            $table->string('attribute4', 150)->nullable();
            $table->string('attribute5', 150)->nullable();
            $table->string('attribute6', 150)->nullable();
            $table->string('attribute7', 150)->nullable();
            $table->string('attribute8', 150)->nullable();
            $table->string('attribute9', 150)->nullable();
            $table->string('attribute10', 150)->nullable();
            $table->string('attribute11', 150)->nullable();
            $table->string('attribute12', 150)->nullable();
            $table->string('attribute13', 150)->nullable();
            $table->string('attribute14', 150)->nullable();
            $table->string('attribute15', 150)->nullable();
            $table->string('program_code', 30)->nullable();
            $table->date('created_at')->default(DB::raw('SYSDATE'));
            $table->date('updated_at')->default(DB::raw('SYSDATE'));
            $table->date('deleted_at')->nullable();
            $table->integer('created_by_id')->nullable();
            $table->integer('updated_by_id')->nullable();
            $table->integer('deleted_by_id')->nullable();
            $table->string('web_batch_no', 50)->nullable();
            $table->string('interface_status', 1)->nullable();
            $table->integer('created_by')->nullable();
            $table->date('creation_date')->default(DB::raw('SYSDATE'));
            $table->integer('last_updated_by')->nullable();
            $table->date('last_update_date')->default(DB::raw('SYSDATE'));
            $table->integer('tran_id')->nullable();
            $table->integer('stg_no')->nullable();
            $table->string('file_name', 255)->nullable();
            $table->string('interface_name', 255)->nullable();
            $table->string('record_status', 1)->nullable(false);
            $table->string('interface_msg', 4000)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle_oainv')->dropIfExists('ptinv_issue_approve_details');
    }
}
