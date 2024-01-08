<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_toat')->create('ptw_roles', function (Blueprint $table) {
            $table->increments('role_id');
            $table->string('module_name');
            $table->string('name')->unique();
            $table->text('description')->nullable();


            $table->integer('created_by_id');
            $table->integer('updated_by_id');
            $table->integer('deleted_by_id')->nullable();
            $table->datetime('created_at')->default(DB::raw('SYSDATE'));
            $table->datetime('updated_at')->default(DB::raw('SYSDATE'));
            $table->datetime('deleted_at')->nullable();


            $table->integer('last_updated_by')->nullable();
            $table->datetime('last_update_date')->default(DB::raw('SYSDATE'));
            $table->integer('created_by')->nullable();
            $table->datetime('creation_date')->default(DB::raw('SYSDATE'));
        });

        Schema::connection('oracle_toat')->create('ptw_role_permission', function (Blueprint $table) {;
            $table->integer('role_id')->unsigned();
            // $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

            $table->integer('permission_id')->unsigned();
            // $table->foreign('permission_id')->references('id')->on('roles')->onDelete('cascade');

            $table->primary(['role_id', 'permission_id']);

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
        Schema::connection('oracle_toat')->dropIfExists('ptw_roles');
        Schema::connection('oracle_toat')->dropIfExists('ptw_role_permission');
    }
}
