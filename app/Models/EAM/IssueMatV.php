<?php

namespace App\Models\EAM;

use App\Exports\EAM\IssueMatExport;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class IssueMatV extends Model
{

    protected $table = "pteam_issue_mat_v";

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
    protected $casts = [
    ];

    public function search($params, $limit = null)
    {
        $mapColumns = [
            'work_order_type_desc'
        ];
        $query = $this;
        foreach ($params as $key => $value) {
            $value = strtolower(trim($value));
            if ($value) {
                if (in_array($key, $mapColumns)) {
                    $query = $query->whereRaw(" lower({$key}) like '{$value}' ");
                }
            }
        }
        $dateSt = parseFromDateTh($params['transaction_date_st']. ' 00:00:00', 'H:i:s') ?? null;
        $dateEn = parseFromDateTh($params['transaction_date_en']. ' 23:59:59', 'H:i:s') ?? null;
        $jobSt = $params['job_no_st'] ?? null;
        $jobEn = $params['job_no_en'] ?? null;
        $assetSt = $params['asset_no_st'] ?? null;
        $assetEn = $params['asset_no_en'] ?? null;
        if ($dateSt != null) {
            $query = $query->whereRaw(" trunc(transaction_date) >= '{$dateSt}' ");
        }
        if ($dateEn != null) {
            $query = $query->whereRaw(" trunc(transaction_date) <= '{$dateEn}' ");
        }

        if ($jobSt != null) {
            $query = $query->whereRaw(" lower(job_no) >= lower('{$jobSt}') ");
        }
        if ($jobEn != null) {
            $query = $query->whereRaw(" lower(job_no) <= lower('{$jobEn}') ");
        }
        if ($assetSt != null) {
            $query = $query->whereRaw(" lower(asset_no) >= lower('{$assetSt}') ");
        }
        if ($assetEn != null) {
            $query = $query->whereRaw(" lower(asset_no) <= lower('{$assetEn}') ");
        }
        $query->orderBy('job_no');

        return ($limit == null) ? $query->get() : $query->paginate($limit);
    }

    public function reportMonthExcel($params)
    {
        $issues = $this->search($params);
        $exportArray = [
            array('Job No.',
            'Job Description',
            'Asset No.',
            'Asset Name',
            'Own Department',
            'Assign Department',
            'Item No.',
            'Item Description',
            'Transaction Date',
            'QTY',
            'UOM',
            'Unit Cost',
            'Amount')
        ];
        foreach ($issues as $issue) {
            array_push($exportArray, [
                $issue->job_no,
                $issue->job_description,
                $issue->asset_no,
                $issue->asset_name,
                $issue->own_dep_code . ': ' . $issue->own_dep_desc,
                $issue->assign_dep_code . ': ' . $issue->assign_dep_desc,
                $issue->item_no,
                $issue->item_description,
                parseToDateTh($issue->transaction_date),
                $issue->qty,
                $issue->uom,
                number_format($issue->unit_cost, 2),
                number_format($issue->amount, 2)
            ]);
        }
        $dateString = Carbon::now()->format('dmy');
        return Excel::download(new IssueMatExport($exportArray), 'รายงานCT-ข้อมูลการตัดจ่ายอะไหล่จากคลัง(Excel).xlsx');
    }
}
