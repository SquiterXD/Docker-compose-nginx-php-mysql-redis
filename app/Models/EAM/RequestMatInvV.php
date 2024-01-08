<?php

namespace App\Models\EAM;

use App\Exports\EAM\IssueMatExport;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;

class RequestMatInvV extends Model
{

    protected $table = "pteam_request_mat_inv_v";
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
        $reqNoEn = $params['work_request_number_en'] ?? null;
        $dateSt = $params['create_date_st'] ?? null;
        $dateEn = $params['create_date_en'] ?? null;
        $subInv = $params['subinventory'] ?? null;
        $locator = $params['locator'] ?? null;
        $wipEntitySt = $params['wip_entity_name_st'] ?? null;
        $wipEntityEn = $params['wip_entity_name_en'] ?? null;
        $itemCode = $params['item_code'] ?? null;
        
        $query = $this::selectRaw("department_code, asset_number, wip_entity_name, create_date, owning_department_code
        , NVL(SUBSTR(wip_entity_name, 0, INSTR(wip_entity_name, '-')-1), wip_entity_name) AS wip_entity_name_pre
        , NVL(SUBSTR(wip_entity_name, INSTR(wip_entity_name, '-')+1 ), wip_entity_name) AS wip_entity_name_post");

        if ($reqNoSt != null) {
            $query = $query->whereRaw(" to_number(work_request_number) >= to_number('{$reqNoSt}') ");
        }
        if ($reqNoEn != null) {
            $query = $query->whereRaw(" to_number(work_request_number) <= to_number('{$reqNoEn}') ");
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
            $query = $query->whereRaw(" lower(p_subinventory) like lower('{$subInv}') ");
        }
        if ($locator != null) {
            $query = $query->whereRaw(" lower(p_locator) like lower('{$locator}') ");
        }
        if ($wipEntitySt != null) {
            $query = $query->whereRaw(" lower(wip_entity_name) >= lower('{$wipEntitySt}') ");
        }
        if ($wipEntityEn != null) {
            $query = $query->whereRaw(" lower(wip_entity_name) <= lower('{$wipEntityEn}') ");
        }
        if ($itemCode != null) {
            $query = $query->whereRaw(" lower(item_code) like lower('{$itemCode}') ");
        }
        $query->groupBy('department_code', 'asset_number', 'wip_entity_name', 'create_date', 'owning_department_code', 'work_request_number');
        $query->orderBy('department_code', 'asc');
        $query->orderByRaw('to_number(wip_entity_name_pre)  asc');
        $query->orderByRaw('to_number(wip_entity_name_post)  asc');
        $query->orderByRaw('to_number(work_request_number)  desc');
        $query->orderBy('asset_number');
        $query->orderBy('create_date');
        $query->orderBy('owning_department_code');
        
        return ($limit == null) ? $query->get() : $query->paginate($limit);
        
    }

    public function report($params)
    {
        $data = $this->searchHead($params);
        foreach ($data as $value) {
            $value['rows'] = RequestMatInvV::where('department_code', $value->department_code)
                ->where('asset_number', $value->asset_number)
                ->where('wip_entity_name', $value->wip_entity_name)
                ->where('create_date', $value->create_date)
                ->where('owning_department_code', $value->owning_department_code)
                ->orderBy('wip_entity_name')
                ->get();
        }
        return $data;
    }
}
