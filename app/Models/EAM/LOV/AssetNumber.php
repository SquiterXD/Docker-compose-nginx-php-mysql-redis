<?php

namespace App\Models\EAM\LOV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use App\Models\EAM\LOV\Departments;

class AssetNumber extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pteam_asset_number_v";

    private $limit = 20;

    public function search($request)
    {
        $limit = $request->p_limit ?? $this->limit;
        $query = $this->select('pteam_asset_number_v.*', 'pteam_asset_v.jp_status','pteam_departments_v.description as department_description')
                    ->leftJoin('pteam_asset_v', 'pteam_asset_number_v.asset_number', '=', 'pteam_asset_v.asset_number')
                    ->leftJoin('pteam_departments_v', 'pteam_asset_number_v.department', '=', 'pteam_departments_v.department_code');

        $query = $this->scopeSearch($query, $request->all());

        if($request->select2 == 1) {
            $query->whereRaw("LOWER(CONCAT(pteam_asset_number_v.asset_number, CONCAT(' : ', pteam_asset_number_v.description))) LIKE LOWER('%". $request->select."%')");
        }

        if($request->p_department_code != null) {
            $deptCode = substr($request->p_department_code, 0, 6);
            $query->whereRaw("(pteam_asset_number_v.department) like '$deptCode%'");
        }

        $query->orderBy('pteam_asset_number_v.asset_number', 'ASC');
        $result = $query->paginate($limit)->appends(request()->all());

        return $result;
    }

    public function scopeSearch($q, $params)
    {
        $mapColumns = ['asset_number', 'description', 'serial_number','department'];
        $profile = getDefaultData();
        foreach ($params as $key => $value) {
            $key = substr($key, 2);
            $value = strtolower(trim($value));
            if ($value) {
                if (in_array($key, $mapColumns)) {
                    $q = $q->whereRaw(" lower(pteam_asset_number_v.{$key}) like '{$value}' ");
                }
                if ($key == 'attr_filter_dept_by_auth') {
                    $deptCode = substr($profile->department_code, 0, 6);
                    $flagAllAssetNumber = Departments::where('department_code',$profile->department_code)->value('flag_all_asset_number');
                    // $q = $q->whereRaw("(pteam_asset_number_v.department) like '$deptCode%'");
                    if($flagAllAssetNumber != 'Yes'){
                        $q = $q->whereRaw("(pteam_asset_number_v.department) like '$deptCode%'");
                    }                    
                }
            }
        }

        return $q;
    }
}
