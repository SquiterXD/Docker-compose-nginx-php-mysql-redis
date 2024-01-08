<?php

namespace App\Models\Planning;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use DB;
use PDO;

class ProductionPlan extends Model
{
    use HasFactory;
    protected $table = "ptpp_product_biweekly_plan";
    public $primaryKey = 'product_plan_id';
    protected $appends = [
        'created_at_format',
        'approved_at_format',
        'as_of_date_format'
        // 'creation_by'
    ];

    public function biWeekly()
    {
        return $this->hasOne(BiWeeklyV::class, 'biweekly_id', 'biweekly_id');
    }

    public function machine()
    {
        return $this->hasMany(ProductionPlanMachine::class, 'product_plan_id', 'product_plan_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'created_by_id');
    }

    public function scopeSearch($q, $param)
    {
        if ($param) {
            //get biWeekly
            $biWeekly = BiWeeklyV::getBiWeeklyPlan($param)->get();
            if (count($biWeekly) > 1) {
                $biWeekly = $biWeekly->pluck('biweekly_id');
                $q->whereIn('biweekly_id', $biWeekly);
            }else{
                $biWeekly = $biWeekly->first();
                $q->where('biweekly_id', optional($biWeekly)->biweekly_id);
            }
            return $q;
        }
        return $q;
    }

    public function getCreatedAtFormatAttribute()
    {
        return parseToDateTh($this->creation_date);
    }

    public function getApprovedAtFormatAttribute()
    {
        return parseToDateTh($this->approved_date);
    }

    public function getAsOfDateFormatAttribute()
    {
        return parseToDateTh($this->as_of_date);
    }

    public function getNextPlanSeq()
    {
        $nextPlanSeq = \DB::select("select ptpp_product_biweekly_plan_s.nextval from dual");
        return ['planSeq' => $nextPlanSeq[0]];
    }

    public function callPackageCreateTapDetail($header)
    {
        $db = DB::connection('oracle')->getPdo();
        $sql = " declare
                    v_header_info  PTPP_PRODUCT_BIWEEKLY_PLAN%ROWTYPE;
                    v_status       VARCHAR2(10);
                    v_err_msg      VARCHAR2(1000);
                    BEGIN
                        v_header_info.product_plan_id       := {$header->product_plan_id};
                        v_header_info.biweekly_id           := {$header->biweekly_id};
                        v_header_info.ref_om_biweekly_id    := {$header->ref_om_biweekly_id};
                        v_header_info.machine_biweekly_id    := {$header->machine_biweekly_id};
                        v_header_info.product_type          := {$header->product_type};
                        v_header_info.version_no            := {$header->version_no};
                        v_header_info.approved_status       := '{$header->approved_status}';
                        v_header_info.ref_om_org_id         := {$header->ref_om_org_id};
                        v_header_info.define_product_cigaret := '{$header->define_product_cigaret}';
                        v_header_info.program_code          := '{$header->program_code}';
                        PTPP_PLAN_PRODUCT_PKG.MAIN (p_plan_info         => v_header_info
                                                    , P_RETURN_STATUS    => :v_status
                                                    , P_RETURN_MESSAGE   => :v_err_msg
                                                );
                    END;";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        logger($sql);

        $result = [];
        $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':v_err_msg', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $result;
    }
}
