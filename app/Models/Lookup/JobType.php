<?php

namespace App\Models\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PDO;
use DB;

class JobType extends Model
{
    use HasFactory;

    protected $table  = 'ptpm_job_type';

    protected $primaryKey = 'lookup_code';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['lookup_code', 'meaning', 'description', 'tag', 'start_date_active', 'end_date_active', 'enabled_flag'];

    public function interfaceData($request)
    {

        $enabledFlag = $request->ENABLED_FLAG ? 'Y' : 'N';
        $db = \DB::reconnect('oracle')->getPdo();
        $sql =  "DECLARE 
                    v_debug         NUMBER :=0;
                    
                    v_return_status     varchar2(1) := NULL;
                    v_message           varchar2(1000) := NULL;
                    
                    BEGIN
                    dbms_output.put_line('------  S T A R T ------');
                    PTFND_LOOKUPVAL_PKG.AUTO_UPLOAD( P_INTERFACE_NAME      =>  'WEB_CREATE_LOOKUP'
                                                    , P_DATA_TYPE          =>  'ADD'
                                                    , P_LOOKUP_TYPE        =>  'PTPM_JOB_TYPE'
                                                    , P_LOOKUP_VALUE       =>  '".$request->LOOKUP_CODE."'
                                                    , P_MEANING            =>  '".$request->MEANING."'
                                                    , P_DESCRIPTION        =>  '".$request->DESCRIPTION."'
                                                    , P_TAG                =>  '".$request->TAG."'
                                                    , P_ENABLED_FLAG       =>  '".$enabledFlag."'
                                                    , P_START_DATE         =>  '".$request->from_date."'
                                                    , P_END_DATE           =>  '".$request->to_date."'
                                                    , P_RETURN_STATUS      =>  :v_return_status 
                                                    , P_MESSAGE            =>  :v_message 
                                                );
                    END;
                ";
        
        $sql = preg_replace("/[\r\n]*/","",$sql);
        \Log::info($sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':v_return_status', $result['v_return_status'], PDO::PARAM_STR, 4000);
        $stmt->bindParam(':v_message', $result['v_message'], PDO::PARAM_STR, 4000);
        $stmt->execute();
        \Log::info($result);

        return $result;
    }
}
