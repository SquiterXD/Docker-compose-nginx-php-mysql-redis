<?php

namespace App\Models\EAM;

use App\Exports\EAM\IssueMatExport;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;

class RequestMatNonV extends Model
{

    protected $table = "pteam_request_mat_non_v";
    protected $dates = ['current_date', 'create_date'];
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

    public function searchHead($params, $limit = null)
    {
        $reqNoSt = $params['work_request_number_st'] ?? null;
        $reqNoEn = $params['work_request_number_en'] ?? $reqNoSt;
        $dateSt = $params['create_date_st'] ?? null;
        $dateEn = $params['create_date_en'] ?? null;
        $subInv = $params['subinventory'] ?? null;
        $locator = $params['locator'] ?? null;
        $wipEntitySt = $params['wip_entity_name_st'] ?? null;
        $wipEntityEn = $params['wip_entity_name_en'] ?? $wipEntitySt;
        $itemCode = $params['item_code'] ?? null;
        $prNumber = $params['pr_number'] ?? null;

        $query = $this::select('department_code', 'asset_number', 'wip_entity_name', 'create_date', 'owning_department_code', 'pr_number');

        if ($reqNoSt != null) {
            $query = $query->whereRaw(" lower(work_request_number) between lower('{$reqNoSt}') and lower('{$reqNoEn}') ");
        }
        if ($dateSt != null) {
            $dateSt = parseFromDateTh($dateSt . ' 00:00:00', 'H:i:s');
            $query = $query->whereRaw(" trunc(create_date) >= '{$dateSt}' ");
        }
        if ($dateEn != null) {
            $dateEn = parseFromDateTh($dateEn . ' 23:59:59', 'H:i:s');
            $query = $query->whereRaw(" trunc(create_date) <= '{$dateEn}' ");
        }
        if ($subInv != null) {
            $query = $query->whereRaw(" lower(subinventory) like lower('{$subInv}') ");
        }
        if ($locator != null) {
            $query = $query->whereRaw(" lower(locator) like lower('{$locator}') ");
        }
        if ($wipEntitySt != null) {
            $query = $query->whereRaw(" lower(wip_entity_name) between lower('{$wipEntitySt}') and lower('{$wipEntityEn}') ");
        }
        if ($itemCode != null) {
            $query = $query->whereRaw(" lower(item_code) like lower('{$itemCode}') ");
        }
        if ($prNumber != null) {
            $query = $query->whereRaw(" lower(pr_number) = lower('{$prNumber}') ");
        }
        $query->groupBy('department_code', 'asset_number', 'wip_entity_name', 'create_date', 'owning_department_code', 'pr_number');
        $query->orderBy('department_code');
        $query->orderBy('wip_entity_name');
        $query->orderBy('asset_number');
        $query->orderBy('create_date');
        $query->orderBy('owning_department_code');
        $query->orderBy('pr_number');
        
        return ($limit == null) ? $query->get() : $query->paginate($limit);
        
    }

    public function report($params)
    {
        $data = $this->searchHead($params);
        foreach ($data as $value) {
            $value['rows'] = RequestMatNonV::where('department_code', $value->department_code)
                ->where('asset_number', $value->asset_number)
                ->where('wip_entity_name', $value->wip_entity_name)
                ->where('create_date', $value->create_date)
                ->where('owning_department_code', $value->owning_department_code)
                ->where('pr_number', $value->pr_number)
                ->get();
        }
        
        return $data;
    }
}
