<?php

namespace App\Models\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialRequestStatus extends Model
{
    use HasFactory;

    protected $table  = 'ptpm_request_transfer_status';

    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['lookup_code', 'meaning', 'description', 'tag', 'start_date_active', 'end_date_active', 'enabled_flag'];

    // protected $headerColumns = [
    //     'lookup_code'        =>  'LOOKUP_CODE',
    //     'meaning'            =>  'MEANING',
    //     'description'        =>  'DESCRIPTION',
    //     'tag'                =>  'TAG',
    //     'start_date_active'  =>  'START_DATE_ACTIVE',
    //     'end_date_active'    =>  'END_DATE_ACTIVE',
    //     'enabled_flag'       =>  'ENABLED_FLAG',
    // ];
    





    // public function getTest($value)
    // {
    //     dd($this->attributes);
    //     $check = $this->attributes['lookup_code'] == strtolower($value);

    //     dd($this->attributes['lookup_code'], strtolower($value));
    //     if ($check) {
    //         dd($this->attributes['lookup_code']);
    //     } else {
    //         dd('2');
    //     }
        
    //     return ;
    // }

    public function interfaceData($request)
    {

        $enabledFlag = $request->ENABLED_FLAG ? 'Y' : 'N';
        $startDate   = $request->from_date ? date('dd/mm/yyyy', strtotime($request->from_date)) : null;
        $endDate     = $request->to_date ? date('dd/mm/yyyy', strtotime($request->to_date)) : null;

        $db = \DB::reconnect('oracle')->getPdo();
        $sql =  "DECLARE 
                    v_debug         NUMBER :=0;
                    
                    v_return_status     varchar2(1) := NULL;
                    v_message           varchar2(1000) := NULL;
                    
                    BEGIN
                    dbms_output.put_line('------  S T A R T ------');
                    PTFND_LOOKUPVAL_PKG.AUTO_UPLOAD( P_INTERFACE_NAME      =>  'WEB_CREATE_LOOKUP'
                                                    , P_DATA_TYPE          =>  'ADD'
                                                    , P_LOOKUP_TYPE        =>  'PTPM_REQUEST_TRANSFER_STATUS'
                                                    , P_LOOKUP_VALUE       =>  '".$request->LOOKUP_CODE."'
                                                    , P_MEANING            =>  '".$request->MEANING."'
                                                    , P_DESCRIPTION        =>  '".$request->DESCRIPTION."'
                                                    , P_TAG                =>  '".$request->TAG."'
                                                    , P_ENABLED_FLAG       =>  '".$enabledFlag."'
                                                    , P_START_DATE         =>  '".$startDate."'
                                                    , P_END_DATE           =>  '".$endDate."'
                                                    , P_RETURN_STATUS      =>  :v_return_status 
                                                    , P_MESSAGE            =>  :v_message 
                                                );
                    END;
                ";
        
        $sql = preg_replace("/[\r\n]*/","",$sql);
        \Log::info($sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':v_return_status', $result['v_return_status'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':v_message', $result['v_message'], \PDO::PARAM_STR, 4000);
        $stmt->execute();
        \Log::info($result);

        return $result;
    }

    public function interfaceDataNew($request, $type)
    {
        $enabledFlag = $request->ENABLED_FLAG ? 'Y' : 'N';

        $db = \DB::reconnect('oracle')->getPdo();
        $sql =  "DECLARE 
                    v_debug         NUMBER :=0;
                    
                    v_lookup_rec        PTFND_LOOKUPVAL_PKG.LOOKUP_REC;
                    BEGIN
                    dbms_output.put_line('------  S T A R T ------');
                    
                        v_lookup_rec  := NULL;
                        v_lookup_rec.INTERFACE_NAME        := 'WEB_CREATE_LOOKUP';
                        v_lookup_rec.DATA_TYPE             := 'ADD'; 
                        v_lookup_rec.LOOKUP_TYPE           := '".$type."';  
                        v_lookup_rec.LOOKUP_CODE           := '".$request->LOOKUP_CODE."';  
                        v_lookup_rec.MEANING               := '".$request->MEANING."'; 
                        v_lookup_rec.DESCRIPTION           := '".$request->DESCRIPTION."'; 
                        v_lookup_rec.ENABLED_FLAG          := '".$enabledFlag."'; 
                        v_lookup_rec.START_DATE_ACTIVE     := '".$request->from_date."';       
                        v_lookup_rec.END_DATE_ACTIVE       := '".$request->to_date."'; 
                        v_lookup_rec.ATTRIBUTE1            := NULL; 
                        v_lookup_rec.ATTRIBUTE2            := NULL;                   
                    
                        v_lookup_rec.RETURN_STATUS        := NULL; 
                        v_lookup_rec.RETURN_MESSAGE       := NULL;              
                    
                        PTFND_LOOKUPVAL_PKG.QUICK_UPLOAD( P_DATA_DATA       => :v_lookup_rec);

                        EXCEPTION WHEN OTHERS THEN
                            dbms_output.put_line('***Error-'||sqlerrm);
                    END;
                ";

        // $sql = preg_replace("/[\r\n]*/","",$sql);
        \Log::info($sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':v_lookup_rec', $result['STATUS'], \PDO::PARAM_STR, 4000);
        // $stmt->bindParam('v_lookup_rec.RETURN_MESSAGE', $result['v_lookup_rec.RETURN_MESSAGE'], \PDO::PARAM_STR, 4000);
        $stmt->execute();
        \Log::info($result);

        // return $result;
        
    }

    public function insertData($request, $type)
    {
        $enabledFlag = $request->ENABLED_FLAG ? 'Y' : 'N';

        $db     =   \DB::connection('oracle')->getPdo();
        $sql    =   "
                        DECLARE
                            v_debug         NUMBER :=0;
                            v_status                varchar2(20);
                            v_lookup_rec        PTFND_LOOKUPVAL_PKG.LOOKUP_REC ;
                        BEGIN
                            dbms_output.put_line('------  S T A R T ------');

                            v_lookup_rec  := NULL;
                            v_lookup_rec.INTERFACE_NAME        := 'WEB_CREATE_LOOKUP';
                            v_lookup_rec.DATA_TYPE             := 'ADD';
                            v_lookup_rec.LOOKUP_TYPE           := '".$type."';  
                            v_lookup_rec.LOOKUP_CODE           := '".$request->LOOKUP_CODE."';  
                            v_lookup_rec.MEANING               := '".$request->MEANING."'; 
                            v_lookup_rec.DESCRIPTION           := '".$request->DESCRIPTION."'; 
                            v_lookup_rec.ENABLED_FLAG          := '".$enabledFlag."'; 
                            v_lookup_rec.START_DATE_ACTIVE     := '".$request->from_date."';       
                            v_lookup_rec.END_DATE_ACTIVE       := '".$request->to_date."'; 
                            v_lookup_rec.ATTRIBUTE1            := NULL;
                            v_lookup_rec.ATTRIBUTE2            := NULL;
                            v_lookup_rec.RETURN_STATUS         := NULL;
                            v_lookup_rec.RETURN_MESSAGE        := NULL;

                            PTFND_LOOKUPVAL_PKG.QUICK_UPLOAD( P_DATA_DATA       => v_lookup_rec);

                            :v_status := v_lookup_rec.return_status;


                            dbms_output.put_line('Output : interface_name = '|| v_lookup_rec.INTERFACE_NAME );
                            dbms_output.put_line('Output :  return_status = '|| v_lookup_rec.return_status );
                            dbms_output.put_line('Output :  message       = '|| v_lookup_rec.RETURN_MESSAGE );

                            dbms_output.put_line('------  E N D ------');
                    EXCEPTION WHEN OTHERS THEN
                        dbms_output.put_line('***Error-'||sqlerrm);
                    END;
                ";
        \Log::info($sql);
        // $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        $result = false;
        // $stmt->bindParam(':v_lookup_rec.return_status', $result['debug2'], PDO::PARAM_STR, 4000);
        // $stmt->bindParam(':v_debug2', $result['debug2'], PDO::PARAM_STR, 4000);
        $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 4000);

        // $stmt->bindParam(':v_lookup_rec.return_status', $result['status'], PDO::PARAM_STR, 4000);
        // $stmt->bindParam(':v_debug', $result['debug'], PDO::PARAM_STR, 4000);
        // $stmt->bindParam(':v_debug2', $result['debug2'], PDO::PARAM_STR, 4000);
        // $stmt->bindParam(':v_lookup_rec.return_status', $result['status'], PDO::PARAM_LOB, 4000);
        // $stmt->bindParam(':v_err_msg', $result['message'], PDO::PARAM_STR, 1000);
        $stmt->execute();
        // dd('xx', $result);

        return $result;
    }
}
