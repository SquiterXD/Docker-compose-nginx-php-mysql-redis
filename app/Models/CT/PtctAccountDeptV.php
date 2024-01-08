<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctAccountDeptV extends Model
{
    use HasFactory;

    protected $table = 'PTCT_ACCOUNT_DEPT_V';
    public $timestamps = false;

    protected $guarded = [];

    public function scopeGetListDeptCodes($query, $toBudgetYear)
    {
        return $query->select(DB::raw("dept_code as dept_code_value, dept_code as dept_code_label, dept_code"))
            ->where('budget_year', '<=', $toBudgetYear)
            ->groupBy('dept_code')
            ->orderBy('dept_code');

    }

    public function scopeGetListDeptCodesYearBetween($query, $fromPeriodYear, $toPeriodYear)
    {
        return $query->select(DB::raw("dept_code as dept_code_value, dept_code as dept_code_label, dept_code"))
            ->where('period_year', '>=', $fromPeriodYear)
            ->where('period_year', '<=', $toPeriodYear)
            ->groupBy('dept_code')
            ->orderBy('dept_code');

    }

    public function scopeGetListCostCodes($query, $toPeriodYear)
    {
        return $query->select(DB::raw("cost_code as cost_code_value, cost_code as cost_code_label, cost_code"))
            ->where('period_year', '<=', $toPeriodYear)
            ->groupBy('cost_code')
            ->orderBy('cost_code');

    }

    public function scopeGetListCostCodesYearBetween($query, $fromBudgetYear, $toBudgetYear)
    {
        return $query->select(DB::raw("cost_code as cost_code_value, cost_code as cost_code_label, cost_code"))
            ->whereIn('budget_year', ['00', $fromBudgetYear, $toBudgetYear ])
            ->groupBy('cost_code')
            ->orderBy('cost_code');
    }

    public function scopeGetListAccountCodes($query)
    {
        return $query->select(DB::raw("acc_code || sub_acc_code as account_code_value, acc_code || sub_acc_code as account_code_label, acc_code, sub_acc_code, account_code_disp"))
            ->groupBy('acc_code', 'sub_acc_code', 'account_code_disp')
            ->orderBy('acc_code')
            ->orderBy('sub_acc_code');

    }

    public function scopeGetListTransferAccountCodes($query)
    {
        return $query->select(DB::raw("acc_code || sub_acc_code as account_code_value, acc_code || sub_acc_code as account_code_label, acc_code, sub_acc_code, account_code_disp"))
            ->where('transfer_account_flag', 'Y')
            ->groupBy('acc_code', 'sub_acc_code', 'account_code_disp')
            ->orderBy('acc_code')
            ->orderBy('sub_acc_code');

    }

    public function scopeGetListOemAccountTypes($query, $inAccCodes)
    {
        $query = $query->select(DB::raw("ACC_CODE AS ACCOUNT_CODE, ACCOUNT_TYPE, ACCOUNT_TYPE_DESC"));
        if($inAccCodes) {
            $query = $query->whereIn('ACC_CODE', $inAccCodes);
        }
        $query = $query->groupBy('ACC_CODE', 'ACCOUNT_TYPE', 'ACCOUNT_TYPE_DESC')
            ->orderBy('ACC_CODE')
            ->orderBy('ACCOUNT_TYPE');

        return $query;
    }
    
}
