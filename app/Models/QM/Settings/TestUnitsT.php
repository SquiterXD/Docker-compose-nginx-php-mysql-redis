<?php

namespace App\Models\QM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;
use PDO;

class TestUnitsT extends Model
{
    use HasFactory;

    protected $table = 'PTQM_TEST_UNITS_T';
    public $primaryKey = 'test_unit_id';
    public $timestamps = false;

    protected $fillable = [ 'test_unit_id',
                            'qcunit_code',
                            'qcunit_desc',
                            'disable_flag',
                            'record_type',
                            'program_code',
                            'updated_at',
                            'updated_by_id',
                            'web_batch_no',
                            'interface_status',
                            'last_updated_by',
                            'last_update_date'];

    public function processTestUnit($param){

        // dd($param->web_batch_no);

        $db = DB::connection('oracle')->getPdo();
        $sql  = "
                    declare
                        v_status                varchar2(20);
                        v_err_msg               varchar2(2000);
                    begin
                        ptqm_main.process_test_unit(    p_web_batch_no => '{$param->web_batch_no}',
                                                        p_user_name => 'MERCURY',
                                                        p_status => :v_status,
                                                        p_err_msg => :v_err_msg);
                        dbms_output.put_line('Status : ' || v_status);
                        dbms_output.put_line('Error : ' || v_err_msg);
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
    
}

