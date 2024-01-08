<?php

namespace App\Models\EAM;

use App\Exports\EAM\IssueMatExport;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;

class JobAccountDelV extends Model
{

    protected $table = "pteam_job_account_del_v";
    protected $dates = ['transaction_date'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    public function search($params, $limit = null)
    {
        $jobNoSt = $params['job_no_st'] ?? null;
        $jobNoEn = $params['job_no_en'] ?? $jobNoSt;
        $dateSt = $params['transaction_date_st'] ?? null;
        $dateEn = $params['transaction_date_en'] ?? null;
        $period = $params['period_name'] ?? null;

        $query = $this;

        if ($jobNoSt != null) {
            $query = $query->whereRaw(" lower(job_no) between lower('{$jobNoSt}') and lower('{$jobNoEn}') ");
        }
        if ($dateSt != null) {
            $dateSt = parseFromDateTh($dateSt. ' 00:00:00', 'H:i:s');
            $query = $query->whereRaw(" trunc(transaction_date) >= '{$dateSt}' ");
        }
        if ($dateEn != null) {
            $dateEn = parseFromDateTh($dateEn. ' 23:59:59', 'H:i:s');
            $query = $query->whereRaw(" trunc(transaction_date) <= '{$dateEn}' ");
        }
        if ($period != null) {
            $query = $query->whereRaw(" lower(period_name) like lower('{$period}') ");
        }
        $query->orderBy('job_no');
        return ($limit == null) ? $query->get() : $query->paginate($limit);
    }

    public function report($params)
    {
        $costs      = ['material' => 0, 'labor' => 0, 'direct_items' => 0, 'total' => 0];
        $jobNoSt    = $params['job_no_st'] ?? null;
        $jobNoEn    = $params['job_no_en'] ?? $jobNoSt;
        $dateSt     = $params['transaction_date_st'] ?? null;
        $dateEn     = $params['transaction_date_en'] ?? null;
        $period     = $params['period_name'] ?? null;

        $data = $this->selectRaw("
                        job_no
                        , job_description
                        , sum(actual_labor_cost) actual_labor_cost
                        , sum(actual_material_cost) actual_material_cost
                        , sum(direct_items_cost) direct_items_cost
                        , sum(total) total
                        , min(transaction_date) transaction_date_st
                        , max(transaction_date) transaction_date_en
                        -- , period_name
                        , job_status
                        , wo_type
                        , gl_transfer_status_code
                        , trunc(period_start_date) period_start_date
                        , trunc(schedule_close_date) schedule_close_date
                    ")
                    ->when($jobNoSt != null, function($q) use($jobNoSt, $jobNoEn) {
                        $q->whereRaw(" lower(job_no) between lower('{$jobNoSt}') and lower('{$jobNoEn}') ");
                    })
                    ->when($dateSt != null, function($q) use($dateSt) {
                        $dateSt = parseFromDateTh($dateSt. ' 00:00:00', 'H:i:s');
                        $q->whereRaw(" trunc(transaction_date) >= '{$dateSt}' ");
                    })
                    ->when($dateEn != null, function($q) use($dateEn) {
                        $dateEn = parseFromDateTh($dateEn. ' 23:59:59', 'H:i:s');
                        $q->whereRaw(" trunc(transaction_date) <= '{$dateEn}' ");
                    })
                    ->when($period != null, function($q) use($period) {
                        $q->whereRaw(" lower(period_name) like lower('{$period}') ");
                    })
                    ->groupByRaw("
                        job_no
                        , job_description
                        -- , period_name
                        , job_status
                        , wo_type
                        , gl_transfer_status_code
                        , trunc(period_start_date)
                        , trunc(schedule_close_date)
                    ")
                    ->orderBy('job_no')
                    ->get();
                    
        if (count($data)) {
            $costs['material']      = $data->sum('actual_material_cost');
            $costs['labor']         = $data->sum('actual_labor_cost');
            $costs['direct_items']  = $data->sum('direct_items_cost');
            $costs['total']         = $data->sum('total');
        }

        $fmDate = '';
        if (isset($params['transaction_date_st'])) {
            $fmDate = Carbon::parse(parseFromDateTh($params['transaction_date_st']))->format('d-M-y');
        } else {
            if(!isset($params['period_name'])){
                if (count($data)) {
                    $fmDate = $data->min('transaction_date_st');
                    if ($fmDate) {
                        $fmDate = Carbon::parse($fmDate)->format('d-M-y');
                    }
                }
            }else{
                if (count($data)) {
                    $fmDate = $data->min('period_start_date');
                    if ($fmDate) {
                        $fmDate = Carbon::parse($fmDate)->format('d-M-y');
                    }
                }
            }
        }

        $toDate = '';
        if (isset($params['transaction_date_en'])) {
            $toDate = Carbon::parse(parseFromDateTh($params['transaction_date_en']))->format('d-M-y');
        } else {
            if(!isset($params['period_name'])){
                $toDate = Carbon::parse(now())->format('d-M-y');
            }else{
                if (count($data)) {
                    $toDate = $data->min('schedule_close_date');
                    if ($toDate) {
                        $toDate = Carbon::parse($toDate)->format('d-M-y');
                    }
                }
            }
        }

        $date = [
            'from'  => $fmDate,
            'to'    => $toDate,
            'now'   => Carbon::now()->format('d-M-y H:i:s')
        ];

        return ['data' => $data, 'costs' => $costs, 'date' => $date];
    }
}
