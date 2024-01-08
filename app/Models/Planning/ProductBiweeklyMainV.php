<?php

namespace App\Models\Planning;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProductBiweeklyMainV extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "PTPP_PRODUCT_BIWEEKLY_MAIN_V";
    protected $dates = ['as_of_date', 'creation_date'];
    public $primaryKey = 'product_main_id';
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

    public function omBiWeekly()
    {
        return $this->hasOne(BiweeklyPeriod::class, 'biweekly_id', 'ref_om_biweekly_id');
    }

    public function firstSalesForecast()
    {
        return $this->hasOne(OMSalesForecast::class, 'biweekly_id', 'ref_om_biweekly_id')
                        ->orderBy('creation_date', 'desc')
                        ->where('approve_flag', 'Y');
    }

    public function plans()
    {
        return $this->hasMany(\App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyPlan::class, 'product_main_id', 'product_main_id');
    }

    public function ppBiweekly()
    {
        return $this->hasOne(BiWeeklyV::class, 'biweekly_id', 'biweekly_id');
    }

    public function ptBiWeekly()
    {
        return $this->hasOne(PtBiweeklyV::class, 'biweekly_id', 'biweekly_id');
    }

    public function tab1()
    {
        return $this->hasMany(
            \App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab1::class, 'product_main_id', 'product_main_id'
        );
    }

    public function machine()
    {
        return $this->hasMany(ProductionPlanMachine::class, 'product_plan_id', 'product_plan_id');
    }

    public function dailyBiWeekly()
    {
        return $this->hasOne(\App\Models\Planning\ProductionDaily\ProductionDailyPlan::class, 'biweekly_id', 'machine_biweekly_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by_id');
    }

    public function scopeByBiweely($q)
    {
        return $q->where('main_type', 'BIWEEKLY');
    }

    public function scopeisAdjustment($q)
    {
        return $q->where('main_type', 'ADJUSTMENT');
    }

    public function scopeIsApproved($q)
    {
        return $q->where('approved_status', 'Approved');
    }

    public function scopeSearch($q, $param)
    {
        $mapColumns = [
            'approved_status', 'thai_month'
        ];

        foreach ($param as $key => $value) {
            $value = strtolower(trim($value));
            if ($value) {
                if (in_array($key, $mapColumns)) {
                    $q->whereRaw(" lower({$key}) = '{$value}'");
                }
                if ($key == 'biweekly') {
                    $q->whereHas('ppBiWeekly', function ($query) use ($value) {
                        $query->where('biweekly', $value);
                    });
                }
                if ($key == 'budget_year') {
                    $q->whereHas('ppBiWeekly', function ($query) use ($value) {
                        $query->where('period_year_thai', $value);
                    });
                }
            }
        }
        return $q;

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

    public function scopeSearchDaily($q, $param)
    {
        if ($param) {
            //get biWeekly
            $biWeekly = BiWeeklyV::getBiWeeklyPlan($param)->first();
            $q->where('biweekly_id', optional($biWeekly)->biweekly_id);
            return $q;
        }
        return $q;
    }

    public function getCreatedAtFormatAttribute()
    {
        return parseToDateTh($this->creation_date);
    }

    public function getUpdatedAtFormatAttribute()
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
        switch (strtoupper($status)) {
            case 'ACTIVE':
                $can->edit = false;
                $can->approve = false;
                break;
            case 'APPROVED':
                $can->edit = false;
                $can->approve = false;
                break;
            case 'INACTIVE':
                $can->edit = true;
                $can->approve = true;
                break;
            case 'CANCEL':
                $can->edit = false;
                $can->approve = false;
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
        return view('planning.production-biweekly._lable_status', ['status' => trim($this->approved_status)])->render();
    }


    public function getFindWithData($productMainId)
    {
        return (new self)->with(['ptBiweekly', 'firstSalesForecast', 'omBiWeekly', 'ppBiWeekly', 'tab1', 'createdBy', 'updatedBy'])->find($productMainId);
    }

    //Piyawut A 20210617
    public function getProdMain($biWeeklyId)
    {
        $biWeekly = \App\Models\Planning\BiWeeklyV::where('biweekly_id', $biWeeklyId)->first();
        $productBiweekly = self::where('biweekly_id', $biWeeklyId)
                                ->with(['dailyBiWeekly'])
                                ->where('approved_status', 'Approved')
                                ->whereNotNull('approved_date')
                                ->orderBy('budget_year', 'desc')
                                ->orderBy('biweekly', 'desc')
                                ->orderBy('version_no', 'desc')
                                ->first();

        $productAdjustment = self::where('biweekly_id', $biWeeklyId)
                                ->with(['dailyBiWeekly'])
                                ->where('approved_status', 'Approved')
                                ->whereNotNull('approved_date')
                                ->orderBy('budget_year', 'desc')
                                ->orderBy('biweekly', 'desc')
                                ->orderBy('version_no', 'desc')
                                ->first();

        // เมื่อไม่มีปักษ์สร้าง จะอิงจากปักษ์ล่วงหน้าที่ Approve
        $productMachineBiweekly = [];
        $productNextBiweekly = [];
        $productBeforeBiweekly = [];
        if(!$productBiweekly || !$productAdjustment){
            $productMachineBiweekly = self::where('machine_biweekly_id', $biWeeklyId)
                                    ->where('approved_status', 'Approved')
                                    ->with(['dailyBiWeekly'])
                                    ->orderBy('budget_year', 'desc')
                                    ->orderBy('biweekly', 'desc')
                                    ->orderBy('version_no', 'desc')
                                    ->first();

            if (!$productMachineBiweekly) {
                $productNextBiweeklyproductNextBiweekly = self::where('next_biweekly_id', $biWeeklyId)
                                    ->where('approved_status', 'Approved')
                                    ->with(['dailyBiWeekly'])
                                    ->orderBy('budget_year', 'desc')
                                    ->orderBy('biweekly', 'desc')
                                    ->orderBy('version_no', 'desc')
                                    ->first();
            }

            if (!$productNextBiweekly && $biWeekly != null) {
                $productBeforeBiweekly = self::where('biweekly', $biWeekly->biweekly - 1)
                                    ->where('approved_status', 'Approved')
                                    ->with(['dailyBiWeekly'])
                                    ->orderBy('budget_year', 'desc')
                                    ->orderBy('biweekly', 'desc')
                                    ->orderBy('version_no', 'desc')
                                    ->first();
            }
            $productBiweekly = ($productMachineBiweekly? $productMachineBiweekly: $productNextBiweekly)
                                ? $productNextBiweekly: $productBeforeBiweekly;
        }

        if ($productAdjustment) {
            $productBiweekly = $productAdjustment;
        }

        return $productBiweekly;
    }
}
