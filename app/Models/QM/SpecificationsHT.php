<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecificationsHT extends Model
{
    use HasFactory;
    protected $table  = 'PTQM_SPECIFICATIONS_H_T';
    protected $primaryKey = 'qm_spec_id';


    public function lines()
    {
        return $this->hasMany(SpecificationsLT::class, 'qm_spec_id');
    }


    public function interface($header, $profile)
    {
        $db = \DB::connection('oracle')->getPdo();
        $sql  = "
            declare
                v_status        varchar2(200);
                v_err_msg       varchar2(2000);
            begin
                ptqm_main.process_specification(p_program_code => '{$profile->program_code}',
                                    p_web_batch_no => '{$header->web_batch_no}',
                                    p_user_name => '{$profile->fnd_user_name}',
                                    p_status => :v_status,
                                    p_err_msg => :v_err_msg);
            end;
        ";
        \Log::info($sql);
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':v_err_msg', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        \Log::info('status', $result);
        return $result;
    }
}
