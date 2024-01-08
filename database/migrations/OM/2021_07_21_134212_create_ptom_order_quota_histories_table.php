<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePtomOrderQuotaHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaom')->create('ptom_order_quota_histories', function (Blueprint $table) {
            $table->increments('order_quota_history_id');
            $table->integer('ORDER_HEADer_id', 10);
            $table->string('quota_group_code', 20);
            $table->integer('received_quota', 10);
            $table->integer('spending_quota', 10);
            $table->integer('remaining_quota', 10);
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
            $table->string('program_code', 150);
            $table->integer('created_by', 10)->nullable();
            $table->date('creation_date');
            $table->integer('last_updated_by', 10)->nullable();
            $table->date('last_update_date');
            $table->date('created_at')->nullable();
            $table->date('updated_at')->nullable();
            $table->date('deleted_at')->nullable();
            $table->integer('created_by_id', 10)->nullable();
            $table->integer('updated_by_id', 10)->nullable();
            $table->integer('deleted_by_id', 10)->nullable();
            $table->string('web_batch_no', 50)->nullable();
            $table->string('interfaced_msg', 4000)->nullable();
            $table->string('interface_status', 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle_oaom')->dropIfExists('ptom_order_quota_histories');
    }
}
