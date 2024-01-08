<?php

namespace App\Models\IR;

use App\Models\IR\Views\GlPeriodYearView;
use App\Models\IR\Views\PtBiweeklyView;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\IR\Settings\PtglCoaCompanyView       as Company;
use App\Models\IR\Settings\PtglCoaEvmView           as Evm;
use App\Models\IR\Settings\PtglCoaDeptCodeView      as Department;           
use App\Models\IR\Settings\PtglCoaCostCenterView    as CostCenter;
use App\Models\IR\Settings\PtglCoaBudgetYearView    as BudgetYear;
use App\Models\IR\Settings\PtglCoaBudgetTypeView    as BudgetType;
use App\Models\IR\Settings\PtglCoaBudgetDetailView  as BudgetDetail;
use App\Models\IR\Settings\PtglCoaBudgetReasonView  as BudgetReason;
use App\Models\IR\Settings\PtglCoaMainAccountView   as MainAccount;
use App\Models\IR\Settings\PtglCoaSubAccountView    as SubAccount;
use App\Models\IR\Settings\PtglCoaReserved1View     as Reserved1;
use App\Models\IR\Settings\PtglCoaReserved2View     as Reserved2;

class ExpenseStockAssets extends Model
{
    use HasFactory;

    public function getExpenseAssetsStock($year, $month, $type, $policyId, $status)
    {
        if ($year == null || $year == '') {
            $periodYear =  (new GlPeriodYearView())->getYear($month);
            $periodYear =  isset($periodYear->period_year) ? $periodYear->period_year : '';
            $year = isset($periodYear) ? $periodYear : '';
        }

        $remove_new_expenses = PtirExpenseStockAssets::whereRaw("period_name = to_char(to_date(?, 'mm/yyyy'), 'Mon-yy')", [$month])
            ->where(function ($q){
                return $q->where('status', 'NEW');
                // ->whereNull('document_number');
            })
            ->when(!!$policyId, function($q) use($policyId){
                return $q->where('policy_set_header_id', $policyId);
            })
            ->where('expense_type_code', $type)
            ->delete();

        $collection = $this->callGetIndex($year, $month, $type, $policyId, $status);

        // dd($collection);

        $result = [];
        $arrayAsset = [];
        $listAssetNumber = [];
        $array = [];
        $coverageAmount = [];
        $listId = [];

        // push group data to array
        $collection2 = [];

        // group by expression
        // foreach($collection as $element) {
        //     $array[$element->flag][$element->policy_set_header_id] = $element;
        //     if (array_key_exists('STOCK001', $array)) {
        //         $coverageAmount[$element->policy_set_header_id][$element->department_cost_code] = 0;
        //     }

        //     if (array_key_exists('ASSET001', $array)) {
        //         $listAssetNumber[$element->policy_set_header_id][$element->asset_number] = new \stdClass();
        //         $listAssetNumber[$element->policy_set_header_id][$element->asset_number]->coverage_amount = 0;
        //         $listAssetNumber[$element->policy_set_header_id][$element->asset_number]->insurance_amount = 0;
        //         $listAssetNumber[$element->policy_set_header_id][$element->asset_number]->coverage_amount_cal = 0;
        //         $listAssetNumber[$element->policy_set_header_id][$element->asset_number]->insurance_amount_cal = 0;
        //         $listAssetNumber[$element->policy_set_header_id][$element->asset_number]->header_id = 0;                
        //         $listAssetNumber[$element->policy_set_header_id][$element->asset_number]->line_id = 0;            
        //         $listAssetNumber[$element->policy_set_header_id][$element->asset_number]->header_id2 = 0;                
        //         $listAssetNumber[$element->policy_set_header_id][$element->asset_number]->line_id2 = 0;
        //     }
        // }

        // group policy_set_header_id
        foreach($collection as $element) {

            if ($element->flag == 'STOCK001') {

                if (!isset($coverageAmount[$element->policy_set_header_id][$element->department_cost_code])) {
                    $coverageAmount[$element->policy_set_header_id][$element->department_cost_code] = 0;
                }

                if (!in_array($element->department_cost_code, $listId, TRUE)) {
                    array_push($listId, $element->department_cost_code);
                }
                if ($element->expense_id != null) {
                    $result[$element->flag][$element->policy_set_header_id][$element->department_cost_code] = $element;
                }
                else {
                    $result[$element->flag][$element->policy_set_header_id][$element->department_cost_code] = $element;
                    $coverageAmount[$element->policy_set_header_id][$element->department_cost_code] += $result['STOCK001'][$element->policy_set_header_id][$element->department_cost_code]->coverage_amount;
                    $result['STOCK001'][$element->policy_set_header_id][$element->department_cost_code]->coverage_amount = $coverageAmount[$element->policy_set_header_id][$element->department_cost_code];
                }
            }
            if ($element->flag == 'ASSET001') {

                if (!isset($listAssetNumber[$element->policy_set_header_id][$element->asset_number])) {
                    $listAssetNumber[$element->policy_set_header_id][$element->asset_number] = new \stdClass();
                    $listAssetNumber[$element->policy_set_header_id][$element->asset_number]->coverage_amount = 0;
                    $listAssetNumber[$element->policy_set_header_id][$element->asset_number]->insurance_amount = 0;
                    $listAssetNumber[$element->policy_set_header_id][$element->asset_number]->coverage_amount_cal = 0;
                    $listAssetNumber[$element->policy_set_header_id][$element->asset_number]->insurance_amount_cal = 0;
                    $listAssetNumber[$element->policy_set_header_id][$element->asset_number]->header_id = 0;                
                    $listAssetNumber[$element->policy_set_header_id][$element->asset_number]->line_id = 0;
                    $listAssetNumber[$element->policy_set_header_id][$element->asset_number]->header_id2 = 0;                
                    $listAssetNumber[$element->policy_set_header_id][$element->asset_number]->line_id2 = 0;
                }

                if ($element->expense_id != null) {
                    $arrayAsset[$element->policy_set_header_id][$element->asset_number] = $element;
                }
                else if ($element->expense_id == null && $element->reference_document_number == null){
                    
                    if ($element->program_code == 'IRP0004') {
                        if ($element->end_date_check == 'Y') {
                            $exStockAsset = PtirExpenseStockAssets::select(DB::raw("sum(insurance_amount_cal) insurance_amount_cal"))
                                ->where('asset_number', $element->asset_number)
                                ->where('policy_set_header_id', $element->policy_set_header_id)
                                ->where('expense_type_code', $type)
                                ->whereRaw("
                                    period_name != to_char(to_date(?, 'mm/yyyy'), 'Mon-yy')
                                    and status in ('CONFIRMED', 'INTERFACE')", 
                                    [$month]
                                )
                                ->first();
                            $element->insurance_amount_cal =  $element->insurance_amount_cal - $exStockAsset->insurance_amount_cal;
                        }
                        $element->header_id2 = $element->header_id;
                        $element->line_id2   = $element->line_id;
                    } else {
                        if ($element->end_date_check == 'Y') {
                            $exStockAsset = PtirExpenseStockAssets::select(DB::raw("sum(insurance_amount) insurance_amount"))
                                ->where('asset_number', $element->asset_number)
                                ->where('policy_set_header_id', $element->policy_set_header_id)
                                ->where('expense_type_code', $type)
                                ->whereRaw("period_name != to_char(to_date(?, 'mm/yyyy'), 'Mon-yy')
                                            and status in ('CONFIRMED', 'INTERFACE')", [$month])
                                            // or (asset_number = ? and status in ('CONFIRMED', 'INTERFACE'))", [$month, $element->asset_number])
                                ->first();

                            $element->insurance_amount = $element->insurance_amount - $exStockAsset->insurance_amount;
                        }
                      
                    }

                   
                    $arrayAsset[$element->policy_set_header_id][$element->asset_number] = $element;
                    $assetNumber = $element->asset_number;

                    if ($element->old_expense_id != null) {
                        if ($listAssetNumber[$element->policy_set_header_id][$assetNumber]->coverage_amount != 0) {
                            $listAssetNumber[$element->policy_set_header_id][$assetNumber]->coverage_amount += $arrayAsset[$element->policy_set_header_id][$assetNumber]->coverage_amount;
                            $listAssetNumber[$element->policy_set_header_id][$assetNumber]->insurance_amount += $arrayAsset[$element->policy_set_header_id][$assetNumber]->insurance_amount;
                        } else {
                            $listAssetNumber[$element->policy_set_header_id][$assetNumber]->coverage_amount = $arrayAsset[$element->policy_set_header_id][$assetNumber]->coverage_amount;
                            $listAssetNumber[$element->policy_set_header_id][$assetNumber]->insurance_amount = $arrayAsset[$element->policy_set_header_id][$assetNumber]->insurance_amount;
                        }

                        if ($listAssetNumber[$element->policy_set_header_id][$assetNumber]->coverage_amount_cal != 0) {
                            $listAssetNumber[$element->policy_set_header_id][$assetNumber]->coverage_amount_cal += $arrayAsset[$element->policy_set_header_id][$assetNumber]->coverage_amount_cal;
                            $listAssetNumber[$element->policy_set_header_id][$assetNumber]->insurance_amount_cal += $arrayAsset[$element->policy_set_header_id][$assetNumber]->insurance_amount_cal;
                        } else {
                            $listAssetNumber[$element->policy_set_header_id][$assetNumber]->coverage_amount_cal = $arrayAsset[$element->policy_set_header_id][$assetNumber]->coverage_amount_cal;
                            $listAssetNumber[$element->policy_set_header_id][$assetNumber]->insurance_amount_cal = $arrayAsset[$element->policy_set_header_id][$assetNumber]->insurance_amount_cal;
                        }
                    } else {
                        $listAssetNumber[$element->policy_set_header_id][$assetNumber]->coverage_amount += $arrayAsset[$element->policy_set_header_id][$assetNumber]->coverage_amount;
                        $listAssetNumber[$element->policy_set_header_id][$assetNumber]->insurance_amount += $arrayAsset[$element->policy_set_header_id][$assetNumber]->insurance_amount;
                        $listAssetNumber[$element->policy_set_header_id][$assetNumber]->coverage_amount_cal += $arrayAsset[$element->policy_set_header_id][$assetNumber]->coverage_amount_cal;
                        $listAssetNumber[$element->policy_set_header_id][$assetNumber]->insurance_amount_cal += $arrayAsset[$element->policy_set_header_id][$assetNumber]->insurance_amount_cal;
                    }
                    if ($element->program_code == 'IRP0003') {
                        $listAssetNumber[$element->policy_set_header_id][$assetNumber]->header_id = $element->header_id;
                        $listAssetNumber[$element->policy_set_header_id][$assetNumber]->line_id = $element->line_id;
                        $listAssetNumber[$element->policy_set_header_id][$assetNumber]->header_id2 += 0;
                        $listAssetNumber[$element->policy_set_header_id][$assetNumber]->line_id2 += 0;
                    } else if ($element->program_code == 'IRP0004') {
                        if ($listAssetNumber[$element->policy_set_header_id][$assetNumber]->header_id != 0) {
                            $listAssetNumber[$element->policy_set_header_id][$assetNumber]->header_id += 0;
                            $listAssetNumber[$element->policy_set_header_id][$assetNumber]->line_id   += 0;
                        } else {
                            $listAssetNumber[$element->policy_set_header_id][$assetNumber]->header_id = $element->header_id;
                            $listAssetNumber[$element->policy_set_header_id][$assetNumber]->line_id   = $element->line_id;
                        }
                        $listAssetNumber[$element->policy_set_header_id][$assetNumber]->header_id2 = $element->header_id;
                        $listAssetNumber[$element->policy_set_header_id][$assetNumber]->line_id2 = $element->line_id;
                    }

                    $arrayAsset[$element->policy_set_header_id][$assetNumber]->coverage_amount =  $listAssetNumber[$element->policy_set_header_id][$assetNumber]->coverage_amount;
                    $arrayAsset[$element->policy_set_header_id][$assetNumber]->insurance_amount =  $listAssetNumber[$element->policy_set_header_id][$assetNumber]->insurance_amount;
                    $arrayAsset[$element->policy_set_header_id][$assetNumber]->coverage_amount_cal =  $listAssetNumber[$element->policy_set_header_id][$assetNumber]->coverage_amount_cal;
                    $arrayAsset[$element->policy_set_header_id][$assetNumber]->insurance_amount_cal =  $listAssetNumber[$element->policy_set_header_id][$assetNumber]->insurance_amount_cal;
                    $arrayAsset[$element->policy_set_header_id][$assetNumber]->header_id = $listAssetNumber[$element->policy_set_header_id][$assetNumber]->header_id;
                    $arrayAsset[$element->policy_set_header_id][$assetNumber]->line_id = $listAssetNumber[$element->policy_set_header_id][$assetNumber]->line_id;
                    $arrayAsset[$element->policy_set_header_id][$assetNumber]->header_id2 = $listAssetNumber[$element->policy_set_header_id][$assetNumber]->header_id2;
                    $arrayAsset[$element->policy_set_header_id][$assetNumber]->line_id2 = $listAssetNumber[$element->policy_set_header_id][$assetNumber]->line_id2;

                }
            }

            if ($element->reference_document_number != null && $element->old_period_name == $month) {
                array_push($collection2, $element);
            }
        }

        foreach($arrayAsset as $policy) {
                foreach($policy as $element) {
                    array_push($collection2, $element);
                }
        }
        foreach($result as $flag) {
            foreach($flag as $departmentCode) {
                foreach($listId as $id) {
                    if (array_key_exists($id, $departmentCode)) {
                        if (!empty($departmentCode[$id])) {
                            array_push($collection2, $departmentCode[$id]);
                        }
                    }
                }
            }
            
        }

        $collection2 = collect($collection2)->whereIn('status', ['New', 'NEW'])->whereNull('document_number')->values()->toArray();

        // dd($collection2);

        $now = Carbon::now();
        foreach ($collection2 as $element) {

            if(!$element->expense_id){
                $expense                            = new PtirExpenseStockAssets;
                $element->status                    = strtoupper($element->status);
                $expense->status                    = strtoupper($element->status);
                $expense->period_name               = Carbon::createFromFormat('m/Y', $element->period_name)->subYears(543)->format('M-y');
                $expense->document_header_id        = $element->header_id;
                $expense->document_line_id          = $element->line_id;
                $expense->expense_type_code         = $element->expense_type_code ?? $element->flag;
                $expense->policy_set_header_id      = $element->policy_set_header_id;
                $expense->policy_set_description    = $element->policy_set_description;
                $expense->group_code                = $element->group_code;
                $expense->department_code           = $element->department_cost_code;
                $expense->department_name           = $element->department_cost_desc;
                $expense->sector_code               = $element->department_code;
                $expense->sector_name               = $element->department_name;
                $expense->asset_number              = $element->asset_number;
                $expense->insurance_premium         = $element->premium_rate;
                $expense->expense_account_id        = $element->expense_account_id;
                $expense->expense_account           = $element->expense_account;
                $expense->expense_account_desc      = $this->getAccountDesc($expense->expense_account);
                $element->expense_account_desc      = $expense->expense_account_desc;
                // $expense->expense_account_desc      = $element->expense_account_desc;
                $expense->prepaid_account_id        = $element->prepaid_account_id;
                $expense->prepaid_account           = $element->prepaid_account;
                $expense->prepaid_account_desc      = $this->getAccountDesc($expense->prepaid_account);
                $element->prepaid_account_desc      = $expense->prepaid_account_desc;
                // $expense->prepaid_account_desc      = $element->prepaid_account_desc;
                $expense->coverage_amount           = $element->coverage_amount;
                $expense->insurance_amount          = $element->insurance_amount;
                $expense->coverage_amount_cal       = $element->coverage_amount_cal;
                $expense->insurance_amount_cal      = $element->insurance_amount_cal;
                $expense->net_amount                = $element->insurance_amount + $element->insurance_amount_cal; /// $element->net_amount ?? 
                $expense->program_code              = 'IRP0008';
                $expense->created_at                = $now;
                $expense->updated_at                = $now;
                $expense->created_by_id             = optional(auth()->user())->user_id ?? -1;
                $expense->updated_by_id             = optional(auth()->user())->user_id ?? -1;
                $expense->created_by                = optional(auth()->user())->user_id ?? -1;
                $expense->last_updated_by           = optional(auth()->user())->user_id ?? -1;
                $expense->creation_date             = $now;
                $expense->last_update_date          = $now;
                $expense->expense_flag              = $element->expense_flag;
                $expense->save();

                $element->expense_id                = $expense->expense_id;
            }
        }

        return $collection2;
    }

    public function callGetIndex($year, $month, $type, $policyId, $status)
    {
        if ($year == null || $year == '') {
            $periodYear =  (new GlPeriodYearView())->getYear($month);
            $periodYear =  isset($periodYear->period_year) ? $periodYear->period_year : '';
            $year = isset($periodYear) ? $periodYear : '';
        }
        $policyId = $policyId == null ? '' : $policyId;
        $status   = $status == null ? '' : $status;
        // $sql = "select PTIR_IRP0008_PKG.fn_get_index_new(?,?,?,?,?) from dual";
        $sql = "select PTIR_IRP0008_PKG.fn_get_index_new(?,?,?,?,?) from dual";
        $result = DB::select($sql, [$month, $year, $type, $policyId, $status]);
        // $result = DB::statement($sql, [$month,$year,$type,$policyId,$status]);
        return $result;
    }

    private function getAccountDesc($account)
    {
        //// return only segment 3, 9, 10
        $segment = explode('.', $account);
        if(count($segment) == 12){
            $desc = $this->getDesc(3, $segment[2]).'.'.$this->getDesc(9, $segment[8]).'.'.$this->getDesc(10, $segment[9], $segment[8]);
        }else $desc = null;

        return $desc;
    }

    private function getDesc($segment, $value, $parentValue = null)
    {
        switch ($segment) {
            case 1:
                $desc = (new Company)->getDesciption($value);
                break;
            case 2:
                $desc = (new Evm)->getDesciption($value);
                break;
            case 3:
                $desc = (new Department)->getDesciption($value);
                break;
            case 4:
                $desc = (new CostCenter)->getDesciption($value, $parentValue);
                break;
            case 5:
                $desc = (new BudgetYear)->getDesciption($value);
                break;
            case 6:
                $desc = (new BudgetType)->getDesciption($value);
                break;
            case 7:
                $desc = (new BudgetDetail)->getDesciption($value, $parentValue);
                break;
            case 8:
                $desc = (new BudgetReason)->getDesciption($value);
                break;
            case 9:
                $desc = (new MainAccount)->getDesciption($value);
                break;
            case 10:
                $desc = (new SubAccount)->getDesciption($value, $parentValue);
                break;
            case 11:
                $desc = (new Reserved1)->getDesciption($value);
                break;
            case 12:
                $desc = (new Reserved2)->getDesciption($value);
                break;
            default:
                $desc = null;
        }

        return $desc;
    }
}
