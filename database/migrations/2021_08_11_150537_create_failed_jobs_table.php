<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFailedJobsTable extends Migration
{
    public function __construct() {
        $this->tableName = 'ptw_failed_jobs';
    }

    public function up()
    {
        Schema::connection('oracle_toat')->create($this->tableName, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
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
