<?php

namespace App\Models\EAM;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class WorkRequestV extends Model
{

    protected $table = "pteam_work_req_v";
    public $primaryKey = 'WORK_REQUEST_NUMBER';
    public $timestamps = false;
    protected $dates = [
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_updated_by',
        'created_by',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];
    public function ListAllWorkReq()
    {
        $datas = self::all();
        // $district = [];
        return $datas;
    }

    private $limit = 20;

    public function SearchWorkReq($request)
    {   
        $limit = $request->p_limit ?? $this->limit;
        $query = $this;
        $query = $this->scopeSearch($query,$request);

        $result = $query->paginate($limit);      

        foreach ($result as $value) {
            $value->expected_resolution_date = parseToDateTh($value->expected_resolution_date);
            $value->expected_start_date = parseToDateTh($value->expected_start_date);
            $value->approved_date = parseToDateTh($value->approved_date);
            $value->creation_date = parseToDateTh($value->creation_date);
        }

        return response()->json($result);

    }

    public function SearchWorkReqWithHierarchyV($request, $attribute1)
    {
        $limit = $request->p_limit ?? $this->limit;
        $query = $this;
        $query = $this->scopeSearch($query,$request);

        $result = $query->whereIn('employee_id', $attribute1)
                        ->paginate($limit);
        foreach ($result as $value) {
            $value->expected_resolution_date = parseToDateTh($value->expected_resolution_date);
            $value->expected_start_date = parseToDateTh($value->expected_start_date);
            $value->approved_date = parseToDateTh($value->approved_date);
            $value->creation_date = parseToDateTh($value->creation_date);
        }

        return response()->json($result);

    }

    public function scopeSearch($q, $search)
    {
        $mapColumns = ['work_request_number','asset_number','asset_desc',
                        'owning_dept_code','work_request_status_desc','receiving_dept_code',
                        'employee_desc','work_request_type_desc','work_request_priority_desc',
                        'expected_resolution_date','work_order_number','expected_resolution_date_from',
                        'expected_resolution_date_to','creation_date_st','creation_date_en']; 
        foreach ($search as $key => $value) {
            $value = strtolower(trim($value));
            if ($value) {
                if (in_array($key, $mapColumns)) {
                    if ($key == 'expected_resolution_date') {
                        $value = parseFromDateTh($value);
                        $q = $q->whereRaw("trunc(EXPECTED_RESOLUTION_DATE) =  '{$value}'");
                    } else if ($key == 'expected_resolution_date_from') {
                        $value = parseFromDateTh($value);
                        if (isset($search['expected_resolution_date_to'])){
                            $dateTo = parseFromDateTh($search['expected_resolution_date_to']);
                            $q = $q->whereRaw("(trunc(EXPECTED_RESOLUTION_DATE) >= '{$value}' and trunc(EXPECTED_RESOLUTION_DATE) <='{$dateTo}')");
                        } else {
                            $q = $q->whereRaw("trunc(EXPECTED_RESOLUTION_DATE) >= '{$value}'");
                        }
                    } else if ($key == 'expected_resolution_date_to') {
                        $value = parseFromDateTh($value);
                        if (isset($search['expected_resolution_date_from'])){
                            $dateFrom = parseFromDateTh($search['expected_resolution_date_from']);
                            $q = $q->whereRaw("(trunc(EXPECTED_RESOLUTION_DATE) >= '{$dateFrom}' and trunc(EXPECTED_RESOLUTION_DATE) <='{$value}')");
                        } else {
                            $q = $q->whereRaw("trunc(EXPECTED_RESOLUTION_DATE) <= '{$value}'");
                        }
                    } else if ($key == 'creation_date_st') {
                        $value = parseFromDateTh($value);
                        if (isset($search['creation_date_en'])){
                            $dateTo = parseFromDateTh($search['creation_date_en']);
                            $q = $q->whereRaw("(trunc(EXPECTED_START_DATE) >= '{$value}' and trunc(EXPECTED_START_DATE) <='{$dateTo}')");
                        } else {
                            $q = $q->whereRaw("trunc(EXPECTED_START_DATE) >= '{$value}'");
                        }
                    } else if ($key == 'creation_date_en') {
                        $value = parseFromDateTh($value);
                        if (isset($search['creation_date_st'])){
                            $dateFrom = parseFromDateTh($search['creation_date_st']);
                            $q = $q->whereRaw("(trunc(EXPECTED_START_DATE) >= '{$dateFrom}' and trunc(EXPECTED_START_DATE) <='{$value}')");
                        } else {
                            $q = $q->whereRaw("trunc(EXPECTED_START_DATE) <= '{$value}'");
                        }
                    } else {
                        $q = $q->whereRaw(" lower({$key}) like '{$value}' ");
                    }
                }
            }
        }
        return $q;
    }

    public function searchTableOpenJobPending($params)
    {
        $mapColumns = [ 'expected_start_date','asset_number','asset_desc',
                        'receiving_dept_code'               ]; 
        $query = self::query();
        foreach ($params as $key => $value) {
            $value = strtolower(trim($value));
            if ($value) {
                if (in_array($key, $mapColumns)) {
                    if ( in_array($key, ['expected_start_date', 'expected_end_date']) ) {
                        $date = parseFromDateTh($value);
                        $query = $query->whereRaw(" trunc(expected_start_date) = '{$date}' ");
                    } else if( in_array($key, ['receiving_dept_code']) ){
                        $query = $query->whereRaw("lower({$key}) = lower('{$value}')");
                    } else if( in_array($key, ['asset_number']) ){
                        $query = $query->whereRaw("lower({$key}) = lower('{$value}')");
                    } else {
                        $query = $query->whereRaw("lower({$key}) like lower('%{$value}%')");
                    }
                }
            }
        }
        return $query;
    }


}
