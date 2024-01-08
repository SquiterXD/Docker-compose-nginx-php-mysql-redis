<?php

namespace App\Models\PM;

use App\Models\PM\PtpmBiweeklyRequestHeaders;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;

class PtpmBiweeklyRequestLines extends Model
{
    use HasFactory;
 
    protected $table = 'oapm.ptpm_biweekly_request_lines';

    protected $primaryKey = 'bi_request_line_id';
    
    // protected $fillable = [
    //     'request_qty',
    // ];
    
    protected $fillable = ['qty','request_qty','request_uom', 'uom2'];


    public function header()
    {
        return $this->belongsTo(PtpmBiweeklyRequestHeaders::class, 'bi_request_header_id', 'bi_request_header_id');
    }

    public function generateLines($biweekly_id, $tobacco_group, $bi_request_header_id){
        // try{

            $db = DB::getPdo();
            
            if($tobacco_group){
                $sql = "
                    DECLARE
                        V_RESULT VARCHAR2(200);
                    BEGIN
                        :V_RESULT := APPS.PTPM_MICS_PKG.AUTO_BIWEEKLY_LINE (
                            P_BIWEEKLY_ID => {$biweekly_id},
                            P_TOBACCO_GROUP => '{$tobacco_group}',
                            P_BI_REQUEST_HEADER_ID => {$bi_request_header_id});
                        DBMS_OUTPUT.PUT_LINE ( 'V_RESULT => ' || V_RESULT );
                    END;
                ";
        
            }else{
                $sql = "
                    DECLARE
                        V_RESULT VARCHAR2(200);
                    BEGIN
                        :V_RESULT := APPS.PTPM_MICS_PKG.AUTO_BIWEEKLY_LINE (
                            P_BIWEEKLY_ID => {$biweekly_id},
                            P_BI_REQUEST_HEADER_ID => {$bi_request_header_id});
                        DBMS_OUTPUT.PUT_LINE ( 'V_RESULT => ' || V_RESULT );
                    END;
                ";
        
            }
            
            $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);
            logger($sql);
    
            $result = [];
            $stmt->bindParam(':V_RESULT', $result['status'], \PDO::PARAM_STR, 20);
            $stmt->execute();
        // }catch(Exception $e){

        // }
        
        return $result;
    }
}
