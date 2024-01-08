<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use DB;

class PtctStdcostYearAcc extends Model
{
    use HasFactory;

    protected $table = 'PTCT_STDCOST_YEAR_ACC';
    protected $primaryKey = false;
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        "year_main_id"
        ,"target_account_code"
        ,"target_acc_code"
        ,"target_sub_acc_code"
        ,"actual_amount"
        ,"avg_actual_amount"
        ,"budget_amount"
        ,"estimate_expense_amount"
        ,"program_code"
        ,"created_at"
        ,"updated_at"
        ,"deleted_at"
        ,"created_by_id"
        ,"updated_by_id"
        ,"deleted_by_id"
        ,"created_by"
        ,"creation_date"
        ,"last_update_date"
        ,"last_updated_by"
        ,"last_update_login"
        ,"allocate_group_code"
        ,"allocate_group"
        ,"allocate_type"
        ,"reason_name"
        ,"comment"
    ];

    protected function setKeysForSaveQuery($query)
    {
        // $query->where($this->getKeyName(), '=', $this->getKeyForSaveQuery());
        return $query->where('year_main_id', $this->getAttribute('year_main_id'))
            ->where('allocate_group', $this->getAttribute('allocate_group'))
            ->where('allocate_group_code', $this->getAttribute('allocate_group_code'))
            ->where('target_account_code', $this->getAttribute('target_account_code'));

        return $query;
    }

    public static function updateExpRec($createdBy, $yearMainId, $allocateGroup, $allocateGroupCode, $targetAccountCode, $newExpAmount) {

        $resResult = [
            "status"    => "C",
            "message"   => ""
        ];

        // CALL PACKAGE
        $db     = DB::connection('oracle')->getPdo();
        $sql = "
        DECLARE 
            v_debug                 NUMBER :=0;
            P_RETURN_STATUS         VARCHAR2(1) := NULL;
            P_RETURN_MESSAGE        VARCHAR2(4000) := NULL;
            v_data_rec      apps.PTCT_M015_PKG.CT15_UPDATE_EXP_REC;
        BEGIN

            dbms_output.put_line('------  S T A R T ------');

            v_data_rec  := NULL;

            v_data_rec.CREATED_BY               := {$createdBy};
            v_data_rec.YEAR_MAIN_ID             := {$yearMainId};
            v_data_rec.ALLOCATE_GROUP           := '{$allocateGroup}';
            v_data_rec.ALLOCATE_GROUP_CODE      := '{$allocateGroupCode}';
            v_data_rec.TARGET_ACCOUNT_CODE      := '{$targetAccountCode}';
            v_data_rec.NEW_EXP_AMOUNT           := {$newExpAmount};

            v_data_rec.RETURN_STATUS        := NULL; 
            v_data_rec.RETURN_MESSAGE       := NULL;
        
            apps.PTCT_M015_PKG.WEB_UPDATE_EXP( P_PARAM_DATA => v_data_rec );
                    
            :P_RETURN_STATUS := v_data_rec.RETURN_STATUS;
            :P_RETURN_MESSAGE := v_data_rec.RETURN_MESSAGE;               
                                
            dbms_output.put_line('------  E N D ------');

        EXCEPTION WHEN OTHERS THEN
            dbms_output.put_line('***Error-'||sqlerrm);
        END;
        ";

        $sql = preg_replace("/[\r\n]*/", "", $sql);

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':P_RETURN_STATUS', $resResult['status'], \PDO::PARAM_STR, 1);
        $stmt->bindParam(':P_RETURN_MESSAGE', $resResult['message'], \PDO::PARAM_STR, 4000);

        $stmt->execute();

        return $resResult;

    }

}
