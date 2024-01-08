<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctStdcostYear extends Model
{
    use HasFactory;

    protected $table = 'PTCT_STDCOST_YEAR';
    protected $primaryKey   = 'year_main_id';
    public $timestamps = false;

    protected $fillable = [
        "year_main_id"
        ,"period_year"
        ,"budget_year"
        ,"prdgrp_year_id"
        ,"allocate_year_id"
        ,"version_no"
        ,"dept_code"
        ,"period_name_from"
        ,"period_name_to"
        ,"month_from"
        ,"month_to"
        ,"total_month"
        ,"prev_period_year"
        ,"prev_period_name_from"
        ,"prev_period_name_to"
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
        ,"as_of_date"
        ,"period_year_thai"
    ];

    /**
	 * Relationship to accs
	 *
	 * @return void
	 */
	public function accs()
	{
		return $this->hasMany(PtctStdcostYearAcc::class, 'year_main_id');
	}

    public static function buildData($pYearMainId) {

        $resResult = [
            "status"    => "C",
            "message"   => ""
        ];

        // CALL PACKAGE
        $db     = DB::connection('oracle')->getPdo();
        $sql    =   "DECLARE
                        R_RETURN_STATUS         VARCHAR2(1) := NULL;
                        R_RETURN_MESSAGE        VARCHAR2(1000) := NULL;
                        v_debug                 NUMBER :=1;     
                        BEGIN

                        dbms_output.put_line('---------------------  S T A R T. -------------------');
                        
                        PTCT_M015_PKG.BUILD_DATA(P_YEAR_MAIN_ID     => {$pYearMainId} 
                                                , P_RETURN_STATUS   => :R_RETURN_STATUS 
                                                , P_RETURN_MESSAGE  => :R_RETURN_MESSAGE );
                        
                        dbms_output.put_line('OUTPUT :' || :R_RETURN_STATUS || ' MSG :' || :R_RETURN_MESSAGE  );                        

                        dbms_output.put_line('---------------------  E N D. -------------------');

                        EXCEPTION WHEN others THEN 
                            dbms_output.put_line(v_debug||'**call_error'||sqlerrm);                   
                        END ;
                    ";
        
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':R_RETURN_STATUS', $resResult['status'], \PDO::PARAM_STR, 200);
        $stmt->bindParam(':R_RETURN_MESSAGE', $resResult['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $resResult;

    }

    public static function createMain($periodYear, $prdgrpYearId, $allocateYearId, $deptCode, $periodNameFrom, $periodNameTo, $programCode) {

        $resResult = [
            "status"        => "C",
            "message"       => "",
            "year_main_id"  => 0,
        ];

        // CALL PACKAGE
        $db     = DB::connection('oracle')->getPdo();
        $sql = "
        DECLARE 
            v_debug                 NUMBER :=0;
            P_RETURN_STATUS         VARCHAR2(1) := NULL;
            P_RETURN_MESSAGE        VARCHAR2(4000) := NULL;
            P_YEAR_MAIN_ID          NUMBER :=0;
            v_main_rec              apps.PTCT_M015_PKG.WEB_MAIN_PARAMETERS;
            O_main_rec              apps.PTCT_M015_PKG.WEB_MAIN_PARAMETERS;
        BEGIN

            dbms_output.put_line('------  S T A R T ------');

            v_main_rec  := NULL;

            v_main_rec.PERIOD_YEAR          := {$periodYear};
            v_main_rec.PRDGRP_YEAR_ID       := {$prdgrpYearId};
            v_main_rec.ALLOCATE_YEAR_ID     := {$allocateYearId};
            v_main_rec.DEPT_CODE            := '{$deptCode}';
            v_main_rec.PERIOD_NAME_FROM     := '{$periodNameFrom}';
            v_main_rec.PERIOD_NAME_TO       := '{$periodNameTo}';
            v_main_rec.PROGRAM_CODE         := '{$programCode}';

            v_main_rec.RETURN_STATUS        := NULL; 
            v_main_rec.RETURN_MESSAGE       := NULL;

            O_main_rec := apps.PTCT_M015_PKG.CREATE_MAIN(P_MAIN_PARAM => v_main_rec);

            :P_RETURN_STATUS := O_main_rec.RETURN_STATUS;
            :P_RETURN_MESSAGE := O_main_rec.RETURN_MESSAGE;
            :P_YEAR_MAIN_ID := O_main_rec.YEAR_MAIN_ID;

            dbms_output.put_line('------  E N D ------');

        EXCEPTION WHEN OTHERS THEN
            dbms_output.put_line('***Error-'||sqlerrm);
        END;
        ";

        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':P_RETURN_STATUS', $resResult['status'], \PDO::PARAM_STR, 1);
        $stmt->bindParam(':P_RETURN_MESSAGE', $resResult['message'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':P_YEAR_MAIN_ID', $resResult['year_main_id'], \PDO::PARAM_INT);

        $stmt->execute();

        return $resResult;

    }

    public static function createMain18($periodYear, $prdgrpYearId, $allocateYearId, $ct14AllocateYearId, $ct14Version, $deptCode, $periodNameFrom, $periodNameTo, $costCode, $programCode) {

        $resResult = [
            "status"        => "C",
            "message"       => "",
            "year_main_id"  => null,
        ];

        // CALL PACKAGE
        $db     = DB::connection('oracle')->getPdo();
        $sql = "
        DECLARE 
            v_debug                 NUMBER :=0;
            P_RETURN_STATUS         VARCHAR2(1) := NULL;
            P_RETURN_MESSAGE        VARCHAR2(4000) := NULL;
            P_YEAR_MAIN_ID          NUMBER :=0;
            v_main_rec        apps.PTCT_M018_PKG.WEB_MAIN_PARAMETERS;
            O_main_rec        apps.PTCT_M018_PKG.WEB_MAIN_PARAMETERS;
        BEGIN

            dbms_output.put_line('------  S T A R T ------');

            v_main_rec  := NULL;

            v_main_rec.PERIOD_YEAR          := {$periodYear};
            v_main_rec.PRDGRP_YEAR_ID       := {$prdgrpYearId};
            v_main_rec.CT14_ALLOCATE_YEAR_ID := {$ct14AllocateYearId};
            v_main_rec.CT14_VERSION_NO      := '{$ct14Version}';
            v_main_rec.ALLOCATE_YEAR_ID     := {$allocateYearId};
            v_main_rec.DEPT_CODE            := '{$deptCode}';
            v_main_rec.PERIOD_NAME_FROM     := '{$periodNameFrom}';
            v_main_rec.PERIOD_NAME_TO       := '{$periodNameTo}';
            v_main_rec.COST_CODE            := '{$costCode}';
            v_main_rec.PROGRAM_CODE         := '{$programCode}';

            v_main_rec.RETURN_STATUS        := NULL; 
            v_main_rec.RETURN_MESSAGE       := NULL;

            O_main_rec := apps.PTCT_M018_PKG.CREATE_MAIN(P_MAIN_PARAM => v_main_rec);

            :P_RETURN_STATUS := O_main_rec.RETURN_STATUS;
            :P_RETURN_MESSAGE := O_main_rec.RETURN_MESSAGE;
            :P_YEAR_MAIN_ID := O_main_rec.YEAR_MAIN_ID;

            dbms_output.put_line('------  E N D ------');

        EXCEPTION WHEN OTHERS THEN
            dbms_output.put_line('***Error-'||sqlerrm);
        END;
        ";

        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':P_RETURN_STATUS', $resResult['status'], \PDO::PARAM_STR, 1);
        $stmt->bindParam(':P_RETURN_MESSAGE', $resResult['message'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':P_YEAR_MAIN_ID', $resResult['year_main_id'], \PDO::PARAM_INT);

        $stmt->execute();

        return $resResult;

    }

    // public static function newYear($periodYear) {

    //     $resResult = [
    //         "status"        => "C",
    //         "message"       => "",
    //         "year_main_id"  => null,
    //     ];

    //     // CALL PACKAGE
    //     $db     = DB::connection('oracle')->getPdo();
    //     $sql = "
    //     DECLARE 
    //         v_debug                 NUMBER :=0;
    //         v_msg                   VARCHAR2(2000) := NULL;
    //     BEGIN

    //         dbms_output.put_line('------  S T A R T ------');

    //         :v_msg := PTCT_M018_PKG.NEW_YEAR(P_PERIOD_YEAR => {$periodYear});

    //         dbms_output.put_line('------  E N D ------');

    //     EXCEPTION WHEN OTHERS THEN
    //         dbms_output.put_line('***Error-'||sqlerrm);
    //     END;
    //     ";

    //     $sql = preg_replace("/[\r\n]*/", "", $sql);
    //     $stmt = $db->prepare($sql);

    //     $stmt->bindParam(':v_msg', $resResult['message'], \PDO::PARAM_STR, 2000);

    //     $stmt->execute();

    //     return $resResult;

    // }

    public static function newYear($periodYear, $prdgrpYearId, $allocateYearId, $ct14AllocateYearId, $ct14VersionNo, $costCode, $periodNameFrom, $periodNameTo, $pPlanVersionNo, $programCode) {

        $resResult = [
            "status"        => "C",
            "message"       => "",
            "year_main_id"  => 0,
        ];

        // CALL PACKAGE
        $db     = DB::connection('oracle')->getPdo();

        $sql = "
        DECLARE 
            v_debug                 NUMBER :=0;
            P_RETURN_STATUS         VARCHAR2(1) := NULL;
            P_RETURN_MESSAGE        VARCHAR2(4000) := NULL;
            P_YEAR_MAIN_ID          NUMBER :=0;
            v_main_rec              APPS.PTCT_M018_PKG.WEB_MAIN_PARAMETERS;
            O_main_rec              APPS.PTCT_M018_PKG.WEB_MAIN_PARAMETERS;
        BEGIN

            dbms_output.put_line('------  S T A R T ------');

            v_main_rec  := NULL;

            v_main_rec.PERIOD_YEAR          := {$periodYear};
            v_main_rec.PRDGRP_YEAR_ID       := {$prdgrpYearId};
            v_main_rec.ALLOCATE_YEAR_ID     := {$allocateYearId};
            v_main_rec.VERSION_NO           := '{$pPlanVersionNo}';
        ";
        if($ct14VersionNo) {
            $sql = $sql . "
            v_main_rec.CT14_VERSION_NO      := '{$ct14VersionNo}';
            ";
        }
        if($ct14AllocateYearId) {
            $sql = $sql . "
            v_main_rec.CT14_ALLOCATE_YEAR_ID := {$ct14AllocateYearId};
            ";
        }
        if($costCode) {
            $sql = $sql . "
            v_main_rec.COST_CODE            := '{$costCode}';
            ";
        }
        $sql = $sql . "
            v_main_rec.PERIOD_NAME_FROM     := '{$periodNameFrom}';
            v_main_rec.PERIOD_NAME_TO       := '{$periodNameTo}';
            
            v_main_rec.PROGRAM_CODE         := '{$programCode}';

            v_main_rec.RETURN_STATUS        := NULL; 
            v_main_rec.RETURN_MESSAGE       := NULL;

            :P_RETURN_MESSAGE := APPS.PTCT_M018_PKG.NEW_YEAR(P_PERIOD_YEAR => {$periodYear}
                                                            ,P_MAIN_PARAM  => v_main_rec);

            dbms_output.put_line('------  E N D ------');

        EXCEPTION WHEN OTHERS THEN
            dbms_output.put_line('***Error-'||sqlerrm);
        END;
        ";

        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':P_RETURN_MESSAGE', $resResult['message'], \PDO::PARAM_STR, 4000);

        $stmt->execute();

        return $resResult;

    }
    
}
