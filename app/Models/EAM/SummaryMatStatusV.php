<?php

namespace App\Models\EAM;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SummaryMatStatusV extends Model
{

    protected $table = "pteam_summary_mat_status_v";
    protected $dates = [];
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
        $wipEntitySt = $params['wip_entity_name_st'] ?? null;
        $wipEntityEn = $params['wip_entity_name_en'] ?? null;
        $assetSt = $params['asset_number_st'] ?? null;
        $assetEn = $params['asset_number_en'] ?? null;
        $reqNoSt = $params['work_request_number_st'] ?? null;
        $reqNoEn = $params['work_request_number_en'] ?? null;

        $query = $this;
        $query = $this->scopeSearch($query, $params);

        if($wipEntitySt != null && $wipEntityEn != null){
            $query = $query->whereRaw(" lower(wip_entity_name) between lower('{$wipEntitySt}') and lower('{$wipEntityEn}') ");
        }
        if($wipEntitySt != null){
            $query = $query->whereRaw(" lower(wip_entity_name) >= lower('{$wipEntitySt}') ");
        }
        if($wipEntityEn != null){
            $query = $query->whereRaw(" lower(wip_entity_name) <= lower('{$wipEntityEn}') ");
        }
        if ($assetSt != null) {
            $query = $query->whereRaw(" lower(asset_number) >= lower('{$assetSt}') ");
        }
        if ($assetEn != null) {
            $query = $query->whereRaw(" lower(asset_number) <= lower('{$assetEn}') ");
        }
        if ($reqNoSt != null) {
            $query = $query->whereRaw(" lower(work_request_number) >= lower('{$reqNoSt}') ");
        }
        if ($reqNoEn != null) {
            $query = $query->whereRaw(" lower(work_request_number) <= lower('{$reqNoEn}') ");
        }
            $query->orderBy('h1_owning_department_desc');
            $query->orderBy('h1_wip_entity_name');
        return ($limit == null) ? $query->get() : $query->paginate($limit);
    }

    public function scopeSearch($q, $search)
    {
        $mapColumns = [
            'wip_entity_name',
            'asset_number',
            'department_code',
            'h1_owning_department_desc',
            'h1_work_order_type_disp',
            'work_request_number',
            'h1_organization_id',
        ];
        foreach ($search as $key => $value) {
            $value = strtolower(trim($value));
            if ($value) {
                if (in_array($key, $mapColumns)) {
                    $q = $q->whereRaw(" lower({$key}) like '{$value}' ");
                }
            }
        }

        return $q;
    }

    public function report($params)
    {
        $data = $this->search($params);
        $costs = $this->getReportCost($data);
        $date = [
            'now' => Carbon::now()->format('d-M-y / H:i:s')
        ];
        return ['data' => $data, 'costs' => $costs, 'date' => $date];
    }

    public function getReportCost($data)
    {
        $costs = [
            'departments' => [],
            'purchased_qty' => 0,
            'purchased_amount' => 0,
            'received_qty' => 0,
            'received_amount' => 0,
            'required_qty' => 0,
            'required_amount' => 0,
            'issued_qty' => 0,
            'issued_amount' => 0,
        ];
        $currentDepartment = '';
        foreach ($data as $item) {
            if ($currentDepartment != $item['h1_owning_department_desc']) {
                $currentDepartment = $item['h1_owning_department_desc'];
                $costs['departments'][$currentDepartment] = [
                    'purchased_qty' => 0,
                    'purchased_amount' => 0,
                    'received_qty' => 0,
                    'received_amount' => 0,
                    'required_qty' => 0,
                    'required_amount' => 0,
                    'issued_qty' => 0,
                    'issued_amount' => 0,
                ];
            }
        }
        foreach ($data as $value) {
            $costs['purchased_qty'] =  $costs['purchased_qty'] + $value->h1_purchased_qty;
            $costs['purchased_amount'] = $costs['purchased_amount'] + $value->h1_purchased_amount;
            $costs['received_qty'] = $costs['received_qty'] + $value->h1_received_qty;
            $costs['received_amount'] = $costs['received_amount'] + $value->h1_received_amount;
            $costs['required_qty'] = $costs['required_qty'] + $value->h1_required_qty;
            $costs['required_amount'] = $costs['required_amount'] + $value->h1_required_amount;
            $costs['issued_qty'] = $costs['issued_qty'] + $value->h1_issued_qty;
            $costs['issued_amount'] = $costs['issued_amount'] + $value->h1_issued_amount;

            $currentDepartment = $value['h1_owning_department_desc'];
            $costs['departments'][$currentDepartment]['purchased_qty'] = $costs['departments'][$currentDepartment]['purchased_qty'] + $value->h1_purchased_qty;
            $costs['departments'][$currentDepartment]['purchased_amount'] = $costs['departments'][$currentDepartment]['purchased_amount'] + $value->h1_purchased_amount;
            $costs['departments'][$currentDepartment]['received_qty'] = $costs['departments'][$currentDepartment]['received_qty'] + $value->h1_received_qty;
            $costs['departments'][$currentDepartment]['received_amount'] = $costs['departments'][$currentDepartment]['received_amount'] + $value->h1_received_amount;
            $costs['departments'][$currentDepartment]['required_qty'] = $costs['departments'][$currentDepartment]['required_qty'] + $value->h1_required_qty;
            $costs['departments'][$currentDepartment]['required_amount'] = $costs['departments'][$currentDepartment]['required_amount'] + $value->h1_required_amount;
            $costs['departments'][$currentDepartment]['issued_qty'] = $costs['departments'][$currentDepartment]['issued_qty'] + $value->h1_issued_qty;
            $costs['departments'][$currentDepartment]['issued_amount'] = $costs['departments'][$currentDepartment]['issued_amount'] + $value->h1_issued_amount;
        }

        return $costs;
    }
}
