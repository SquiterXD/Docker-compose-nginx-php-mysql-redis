<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldDffToInterfaceApHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('oracle_oaie')->table('ptw_interface_ap_headers', function (Blueprint $table) {
            $table->string('ATTRIBUTE_CATEGORY', 150)->nullable();
            $table->string('ATTRIBUTE1', 150)->nullable();
            $table->string('ATTRIBUTE2', 150)->nullable();
            $table->string('ATTRIBUTE3', 150)->nullable();
            $table->string('ATTRIBUTE4', 150)->nullable();
            $table->string('ATTRIBUTE5', 150)->nullable();
            $table->string('ATTRIBUTE6', 150)->nullable();
            $table->string('ATTRIBUTE7', 150)->nullable();
            $table->string('ATTRIBUTE8', 150)->nullable();
            $table->string('ATTRIBUTE9', 150)->nullable();
            $table->string('ATTRIBUTE10', 150)->nullable();
            $table->string('ATTRIBUTE11', 150)->nullable();
            $table->string('ATTRIBUTE12', 150)->nullable();
            $table->string('ATTRIBUTE13', 150)->nullable();
            $table->string('ATTRIBUTE14', 150)->nullable();
            $table->string('ATTRIBUTE15', 150)->nullable();

            $table->string('GLOBAL_ATTRIBUTE_CATEGORY', 150)->nullable();
            $table->string('GLOBAL_ATTRIBUTE1', 150)->nullable();
            $table->string('GLOBAL_ATTRIBUTE2', 150)->nullable();
            $table->string('GLOBAL_ATTRIBUTE3', 150)->nullable();
            $table->string('GLOBAL_ATTRIBUTE4', 150)->nullable();
            $table->string('GLOBAL_ATTRIBUTE5', 150)->nullable();
            $table->string('GLOBAL_ATTRIBUTE6', 150)->nullable();
            $table->string('GLOBAL_ATTRIBUTE7', 150)->nullable();
            $table->string('GLOBAL_ATTRIBUTE8', 150)->nullable();
            $table->string('GLOBAL_ATTRIBUTE9', 150)->nullable();
            $table->string('GLOBAL_ATTRIBUTE10', 150)->nullable();
            $table->string('GLOBAL_ATTRIBUTE11', 150)->nullable();
            $table->string('GLOBAL_ATTRIBUTE12', 150)->nullable();
            $table->string('GLOBAL_ATTRIBUTE13', 150)->nullable();
            $table->string('GLOBAL_ATTRIBUTE14', 150)->nullable();
            $table->string('GLOBAL_ATTRIBUTE15', 150)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('oracle_oaie')->table('ptw_interface_ap_headers', function (Blueprint $table) {
            $table->dropColumn('ATTRIBUTE_CATEGORY');
            $table->dropColumn('ATTRIBUTE1');
            $table->dropColumn('ATTRIBUTE2');
            $table->dropColumn('ATTRIBUTE3');
            $table->dropColumn('ATTRIBUTE4');
            $table->dropColumn('ATTRIBUTE5');
            $table->dropColumn('ATTRIBUTE6');
            $table->dropColumn('ATTRIBUTE7');
            $table->dropColumn('ATTRIBUTE8');
            $table->dropColumn('ATTRIBUTE9');
            $table->dropColumn('ATTRIBUTE10');
            $table->dropColumn('ATTRIBUTE11');
            $table->dropColumn('ATTRIBUTE12');
            $table->dropColumn('ATTRIBUTE13');
            $table->dropColumn('ATTRIBUTE14');
            $table->dropColumn('ATTRIBUTE15');

            $table->dropColumn('GLOBAL_ATTRIBUTE_CATEGORY');
            $table->dropColumn('GLOBAL_ATTRIBUTE1');
            $table->dropColumn('GLOBAL_ATTRIBUTE2');
            $table->dropColumn('GLOBAL_ATTRIBUTE3');
            $table->dropColumn('GLOBAL_ATTRIBUTE4');
            $table->dropColumn('GLOBAL_ATTRIBUTE5');
            $table->dropColumn('GLOBAL_ATTRIBUTE6');
            $table->dropColumn('GLOBAL_ATTRIBUTE7');
            $table->dropColumn('GLOBAL_ATTRIBUTE8');
            $table->dropColumn('GLOBAL_ATTRIBUTE9');
            $table->dropColumn('GLOBAL_ATTRIBUTE10');
            $table->dropColumn('GLOBAL_ATTRIBUTE11');
            $table->dropColumn('GLOBAL_ATTRIBUTE12');
            $table->dropColumn('GLOBAL_ATTRIBUTE13');
            $table->dropColumn('GLOBAL_ATTRIBUTE14');
            $table->dropColumn('GLOBAL_ATTRIBUTE15');
        });
    }
}
