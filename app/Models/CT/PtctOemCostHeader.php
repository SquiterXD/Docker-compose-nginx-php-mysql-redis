<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctOemCostHeader extends Model
{
    use HasFactory;

    protected $table = 'PTCT_OEM_COST_HEADERS';
    protected $primaryKey   = 'oem_cost_header_id';
    public $timestamps = false;

    protected $guarded = [];

    protected $fillable = [
        "oem_cost_header_id"
        ,"prdgrp_year_id"
        ,"cost_code"
        ,"product_group"
        ,"product_inventory_item_id"
        ,"product_quantity"
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
        ,"allocate_year_id"
        ,"year_main_id"
        ,"period_year"
    ];

    /**
	 * Relationship to lines
	 *
	 * @return void
	 */
	public function lines()
	{
		return $this->hasMany(PtctOemCostLine::class, 'oem_cost_header_id');
	}

    public static function createMain($periodYear, $prdgrpYearId, $allocateYearId, $ct14AllocateYearId, $costCode) {

        $resResult = [
            "status"        => "C",
            "message"       => "",
        ];

        // CALL PACKAGE
        $db     = DB::connection('oracle')->getPdo();
        $sql = "
        DECLARE 
            v_debug                 NUMBER :=0;
            P_RETURN_STATUS         VARCHAR2(1) := NULL;
            P_RETURN_MESSAGE        VARCHAR2(4000) := NULL;
            P_YEAR_MAIN_ID          NUMBER :=0;
            v_main_rec        apps.PTCT_M017_PKG.WEB_MAIN_PARAMETERS;
            O_main_rec        apps.PTCT_M017_PKG.WEB_MAIN_PARAMETERS;
        BEGIN

            dbms_output.put_line('------  S T A R T ------');

            v_main_rec  := NULL;

            v_main_rec  := NULL;

            v_main_rec.PERIOD_YEAR              := {$periodYear};
            v_main_rec.PRDGRP_YEAR_ID           := {$prdgrpYearId};
            v_main_rec.ALLOCATE_YEAR_ID         := {$allocateYearId};
            v_main_rec.ALLOCATE_YEAR_ID         := {$allocateYearId};
            v_main_rec.CT14_ALLOCATE_YEAR_ID    := {$ct14AllocateYearId};
            v_main_rec.COST_CODE                := {$costCode};
            v_main_rec.PROGRAM_CODE             := 'CTM0017';

            v_main_rec.RETURN_STATUS            := NULL; 
            v_main_rec.RETURN_MESSAGE           := NULL;

            O_main_rec := APPS.PTCT_M017_PKG.CREATE_MAIN(P_MAIN_PARAM  => v_main_rec);

            :P_RETURN_STATUS := O_main_rec.RETURN_STATUS;
            :P_RETURN_MESSAGE := O_main_rec.RETURN_MESSAGE;

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
