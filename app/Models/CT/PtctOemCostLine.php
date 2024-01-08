<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctOemCostLine extends Model
{
    use HasFactory;

    protected $table = 'PTCT_OEM_COST_LINES';
    protected $primaryKey   = 'oem_cost_line_id';
    public $timestamps = false;

    protected $guarded = [];

    protected $fillable = [
        "oem_cost_line_id"
        ,"oem_cost_header_id"
        ,"account_code"
        ,"sub_account_code"
        ,"account_type"
        ,"expense_amount"
        ,"transfer_data"
        ,"attribute_category"
        ,"attribute1"
        ,"attribute2"
        ,"attribute3"
        ,"attribute4"
        ,"attribute5"
        ,"attribute6"
        ,"attribute7"
        ,"attribute8"
        ,"attribute9"
        ,"attribute10"
        ,"attribute11"
        ,"attribute12"
        ,"attribute13"
        ,"attribute14"
        ,"attribute15"
        ,"program_code"
        ,"created_at"
        ,"updated_at"
        ,"deleted_at"
        ,"created_by_id"
        ,"updated_by_id"
        ,"deleted_by_id"
        ,"web_batch_no"
        ,"interface_status"
        ,"interfaced_msg"
        ,"created_by"
        ,"creation_date"
        ,"last_updated_by"
        ,"last_update_date"
        ,"tran_id"
        ,"stg_no"
        ,"file_name"
        ,"interface_name"
        ,"record_status"
        ,"interface_msg"
    ];

    public static function getListOemAccountCodes(){

        $results = DB::table("FND_FLEX_VALUE_SETS")
            ->join("FND_FLEX_VALUES_VL", "FND_FLEX_VALUES_VL.FLEX_VALUE_SET_ID", "=" , "FND_FLEX_VALUE_SETS.FLEX_VALUE_SET_ID")
            ->selectRaw("FND_FLEX_VALUES_VL.FLEX_VALUE AS ACCOUNT_CODE, FND_FLEX_VALUES_VL.DESCRIPTION AS ACCOUNT_DESC")
            ->whereRaw("FND_FLEX_VALUE_SETS.FLEX_VALUE_SET_NAME = 'TOAT_GL_ACCT_CODE-MAIN_ACCOUNT'")
            ->whereRaw("FND_FLEX_VALUES_VL.ENABLED_FLAG = 'Y'")
            ->whereRaw("FND_FLEX_VALUES_VL.ATTRIBUTE6  = 'Y'")
            ->orderBy("FND_FLEX_VALUES_VL.FLEX_VALUE")
            ->get();

        return $results;

    }

    public static function getListOemSubAccountCodes($accCodes) {

        $results = DB::table("FND_FLEX_VALUE_SETS")
            ->join("FND_FLEX_VALUES_VL", "FND_FLEX_VALUES_VL.FLEX_VALUE_SET_ID", "=" , "FND_FLEX_VALUE_SETS.FLEX_VALUE_SET_ID")
            ->selectRaw("FND_FLEX_VALUES_VL.PARENT_FLEX_VALUE_LOW || FND_FLEX_VALUES_VL.FLEX_VALUE AS SUB_ACCOUNT_DISP, FND_FLEX_VALUES_VL.PARENT_FLEX_VALUE_LOW AS ACCOUNT_CODE, FND_FLEX_VALUES_VL.FLEX_VALUE AS SUB_ACCOUNT_CODE, FND_FLEX_VALUES_VL.DESCRIPTION AS SUB_ACCOUNT_DESC, FND_FLEX_VALUES_VL.ATTRIBUTE4 as ACCOUNT_TYPE")
            ->whereRaw("FND_FLEX_VALUE_SETS.FLEX_VALUE_SET_NAME = 'TOAT_GL_ACCT_CODE-SUB_ACCOUNT'")
            ->whereIn("FND_FLEX_VALUES_VL.PARENT_FLEX_VALUE_LOW", $accCodes)
            ->whereRaw("FND_FLEX_VALUES_VL.ENABLED_FLAG = 'Y'")
            ->orderBy("FND_FLEX_VALUES_VL.PARENT_FLEX_VALUE_LOW")
            ->orderBy("FND_FLEX_VALUES_VL.FLEX_VALUE")
            ->get();

        return $results;

    }

    // public static function updateExpRec($createdBy, $yearMainId, $allocateGroup, $allocateGroupCode, $targetAccountCode, $newExpAmount) {

    //     $resResult = [
    //         "status"    => "C",
    //         "message"   => ""
    //     ];

    //     // CALL PACKAGE
    //     $db     = DB::connection('oracle')->getPdo();
    //     $sql = "
    //     DECLARE 
    //         v_debug                 NUMBER :=0;
    //         P_RETURN_STATUS         VARCHAR2(1) := NULL;
    //         P_RETURN_MESSAGE        VARCHAR2(4000) := NULL;
    //         v_data_rec      apps.PTCT_M015_PKG.CT15_UPDATE_EXP_REC;
    //     BEGIN

    //         dbms_output.put_line('------  S T A R T ------');

    //         v_data_rec  := NULL;

    //         v_data_rec.CREATED_BY               := {$createdBy};
    //         v_data_rec.YEAR_MAIN_ID             := {$yearMainId};
    //         v_data_rec.ALLOCATE_GROUP           := '{$allocateGroup}';
    //         v_data_rec.ALLOCATE_GROUP_CODE      := '{$allocateGroupCode}';
    //         v_data_rec.TARGET_ACCOUNT_CODE      := '{$targetAccountCode}';
    //         v_data_rec.NEW_EXP_AMOUNT           := {$newExpAmount};

    //         v_data_rec.RETURN_STATUS        := NULL; 
    //         v_data_rec.RETURN_MESSAGE       := NULL;
        
    //         apps.PTCT_M015_PKG.WEB_UPDATE_EXP( P_PARAM_DATA => v_data_rec );
                    
    //         :P_RETURN_STATUS := v_data_rec.RETURN_STATUS;
    //         :P_RETURN_MESSAGE := v_data_rec.RETURN_MESSAGE;               
                                
    //         dbms_output.put_line('------  E N D ------');

    //     EXCEPTION WHEN OTHERS THEN
    //         dbms_output.put_line('***Error-'||sqlerrm);
    //     END;
    //     ";

    //     $sql = preg_replace("/[\r\n]*/", "", $sql);

    //     $stmt = $db->prepare($sql);

    //     $stmt->bindParam(':P_RETURN_STATUS', $resResult['status'], \PDO::PARAM_STR, 1);
    //     $stmt->bindParam(':P_RETURN_MESSAGE', $resResult['message'], \PDO::PARAM_STR, 4000);

    //     $stmt->execute();

    //     return $resResult;

    // }

}
