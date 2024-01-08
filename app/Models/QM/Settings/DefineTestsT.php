<?php

namespace App\Models\QM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;
use PDO;

class DefineTestsT extends Model
{
    use HasFactory;

    protected $table = 'ptqm_define_tests_t';
    public $primaryKey = 'define_test_id';
    public $timestamps = false;

    public function defineTests($param){

        $db = DB::connection('oracle')->getPdo();
        $sql  = "
                    declare
                        v_status        varchar2(200);
                        v_err_msg       varchar2(2000);
                    begin
                        ptqm_main.process_test( p_program_code  => '{$param->program_code}',
                                                p_web_batch_no  => '{$param->web_batch_no}',
                                                p_user_name     => 'MERCURY',                         
                                                p_status        => :v_status,
                                                p_err_msg       => :v_err_msg);
                    end;
                ";
        \Log::info($sql);
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':v_status', $result['status'], PDO::PARAM_STR, 20);
        $stmt->bindParam(':v_err_msg', $result['message'], PDO::PARAM_STR, 2000);
        $stmt->execute();

        \Log::info('status', $result);

        return $result;
    }

    public function createTestCode($param){
        $db = DB::connection('oracle')->getPdo();
        $sql  = "
                    declare
                        test_code varchar2(100);
                    begin
                        :test_code := ptqm_main.gen_test_code(      p_program_code  => '{$param}',
                                                                    p_module        => 'QM',
                                                                    p_subject       => 'TEST CODE'        );
                    end;
                ";
        \Log::info($sql);
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam('test_code', $result['test_code'], PDO::PARAM_STR, 20);
        $stmt->execute();

        \Log::info('status', $result);

        return $result;
    }
}
