<?php

namespace App\Models\Planning\ProductionDaily;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionDailyPlan extends Model
{
    use HasFactory;
    protected $table = "ptpp_plan_daily";
    public $primaryKey = 'daily_id';
    public $timestamps = false;
    protected $appends = [
        'can',
        'created_at_format',
        'updated_at_format',
        'creation_date_format',
        'last_update_date_format',
        'approved_at_format',
        'as_of_date_format',
        'status_lable_html'
    ];

    public function planDailyT()
    {
        return $this->hasMany(ProductionDailyT::class, 'daily_id', 'daily_id');
    }
    
    public function planDailyTLast()
    {
        return $this->hasOne(ProductionDailyT::class, 'daily_id', 'daily_id')->orderBy('batch_no', 'desc');
    }

    public function machines()
    {
        return $this->hasMany(ProductionDailyMachine::class, 'daily_id', 'daily_id');
    }

    public function ppBiweekly()
    {
        return $this->hasOne(\App\Models\Planning\BiWeeklyV::class, 'biweekly_id', 'biweekly_id');
    }

    public function ptBiWeekly()
    {
        return $this->hasOne(\App\Models\Planning\PtBiweeklyV::class, 'biweekly_id', 'biweekly_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by_id');
    }

    public function getCreatedAtFormatAttribute()
    {
        return parseToDateTh($this->creation_date);
    }

    public function getUpdatedAtFormatAttribute()
    {
        return parseToDateTh($this->updated_at);
    }

    public function getApprovedAtFormatAttribute()
    {
        return parseToDateTh($this->approved_at);
    }

    public function getAsOfDateFormatAttribute()
    {
        return parseToDateTh($this->as_of_date);
    }

    public function getLastUpdateDateFormatAttribute()
    {
        return parseToDateTh($this->last_update_date);
    }

    public function getCreationDateFormatAttribute()
    {
        return parseToDateTh($this->creation_date);
    }

    public function getCanAttribute()
    {
        $can = (object)[];
        $status = trim($this->approved_status);
        // switch (strtoupper($status)) {
        switch ($status) {
            case 'Approved':
                $can->edit = false;
                $can->approve = false;
                break;
            case 'Inactive':
                $can->edit = true;
                $can->approve = true;
                break;
            default:
                $can->edit = true;
                $can->approve = true;
                break;
        }

        return $can;
    }

    public function getStatusLableHtmlAttribute()
    {
        return view('planning.production-daily._lable_status', ['status' => trim($this->approved_status)])->render();
    }

    public function scopeGetFindWithData()
    {
        return (new self)->with(['ptBiweekly', 'ppBiWeekly']);
    }

    public function scopeSearch($q, $param)
    {
        if ($param) {
            //get biWeekly
            $biWeekly = \App\Models\Planning\BiWeeklyV::getBiWeeklyPlan($param)->first();
            $q->where('biweekly_id', optional($biWeekly)->biweekly_id);
            return $q;
        }
        return $q;
    }

    public function importPlanDaily($biWeekly)
    {
        $db = \DB::connection('oracle')->getPdo();
        $sql = "declare
                    v_status            varchar2(20);
                    v_err_msg           varchar2(2000);
                    begin
                        ptpm_main.import_pp_daily_plan(p_year       => {$biWeekly->period_year}
                                                    , p_biweekly    => {$biWeekly->biweekly}
                                                    , p_status      => :v_status
                                                    , p_err_msg     => :v_err_msg
                                                );

                        dbms_output.put_line('Status : ' || v_status);
                        dbms_output.put_line('Error : ' || v_err_msg);
                    commit;
                    end;";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        logger($sql);

        $result = [];
        $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':v_err_msg', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $result;
    }

    public function createJob($batchNo, $username)
    {
        $db = \DB::connection('oracle')->getPdo();
        $sql = "declare 
                    v_status                varchar2(5);
                    v_err_msg               varchar2(2000);
                    begin
                        ptpm_main.create_job(p_program_code => 'PMP0010'
                                        , p_web_batch_no    => '{$batchNo}'
                                        , p_user_name       => '{$username}'
                                        , p_status          => :v_status
                                        , p_err_msg         => :v_err_msg
                                    );
                        dbms_output.put_line('Status : ' || v_status);
                        dbms_output.put_line('Error : ' || v_err_msg);
                    commit;
                    end;";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        logger($sql);

        $result = [];
        $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':v_err_msg', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $result;
    }

    public function getTransactionJobCompleted($periodYear, $biWeekly)
    {
        $data = collect(\DB::select("
                select  count(*) transaction_num
                    from    ptmes_biweekly_plan_jobs_v pbpj
                    where   1=1
                    and     pbpj.period_year = {$periodYear}
                    and     pbpj.plan_biweekly = {$biWeekly}
                    and     pbpj.plan_revision_no = (select  max(ppjh.plan_revision_no)
                                                    from    ptpm_planning_job_headers ppjh
                                                    where   ppjh.period_year = pbpj.period_year
                                                    and     ppjh.period_name = pbpj.period_name
                                                    and     ppjh.biweekly = pbpj.biweekly)
                    and     exists (select  'Y'
                                    from    gme_batch_header gbh,
                                            gme_material_details gmd
                                    where   gbh.batch_id = pbpj.batch_id
                                    and     gbh.organization_id = pbpj.organization_id
                                    and     gbh.batch_id = gmd.batch_id
                                    and     gbh.organization_id = gmd.organization_id
                                    and     gmd.actual_qty > 0)
            "));

        return $data->first();
    }
}
