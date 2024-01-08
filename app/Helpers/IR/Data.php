<?php
use App\Models\IR\Views\GlCodeCombinationView;
// Piyawut A. 20211111
use App\Models\IR\Views\PtglCoaCompanyView;
use App\Models\IR\Views\PtglCoaEvmView;
use App\Models\IR\Views\PtglCoaDeptCodeView;
use App\Models\IR\Views\PtglCoaCostCenterView;
use App\Models\IR\Views\PtglCoaBudgetYearView;
use App\Models\IR\Views\PtglCoaBudgetTypeView;
use App\Models\IR\Views\PtglCoaBudgetDetailView;
use App\Models\IR\Views\PtglCoaBudgetReasonView;
use App\Models\IR\Views\PtglCoaMainAccountView;
use App\Models\IR\Views\PtglCoaSubAccountView;
use App\Models\IR\Views\PtglCoaReserved1View;
use App\Models\IR\Views\PtglCoaReserved2View;
use App\Models\IR\Views\PtirArInterfaceTypeView;
use App\Models\FndLookupValue;
use App\Models\IR\Views\PtirFaLocationView;
use App\Models\IR\PtirExpenseCarGas;

use App\Models\IR\PtirCars;
use App\Models\IR\Views\PtirVehiclesView;
use App\Models\IR\PtirStockLines;
use App\Models\IR\Settings\AssetGroupV;
use App\Models\IR\Settings\PtirPolicySetHeaders;

function getSumDataFormat($data, $field, $digit = 4)
{
    // dd($data);
    $total = $data->sum($field);
    if ($digit === 0) {
        return $total ?? 0;
    }
    return number_format($total ?? 0 , $digit);
}

function getDescriptionAccount($segment_override)
{
    $explodeSegment = explode('.', $segment_override);
    $company = (new PtglCoaCompanyView)->companyDesc(getPrefixValueSetName().'_GL_ACCT_CODE-COMPANY_CODE', $explodeSegment[0], $explodeSegment[0]);
    $evm = (new PtglCoaEvmView)->emvDesc(getPrefixValueSetName().'_GL_ACCT_CODE-EVM', $explodeSegment[1], $explodeSegment[1]);
    $department = (new PtglCoaDeptCodeView)->departmentDesc(getPrefixValueSetName().'_GL_ACCT_CODE-DEPT_CODE', $explodeSegment[2], $explodeSegment[2]);
    $costCenter = (new PtglCoaCostCenterView)->costCenterDesc(getPrefixValueSetName().'_GL_ACCT_CODE-COST_CENTER', $explodeSegment[3], $explodeSegment[3], $explodeSegment[2]);
    $budgetYear = (new PtglCoaBudgetYearView)->budgetYearDesc(getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_YEAR', $explodeSegment[4], $explodeSegment[4]);
    $budgetType = (new PtglCoaBudgetTypeView)->budgetTypeDesc(getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_TYPE', $explodeSegment[5], $explodeSegment[5]);
    $budgetDetail = (new PtglCoaBudgetDetailView)->budgetDetailDesc(getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_DETAIL', $explodeSegment[6], $explodeSegment[6], $explodeSegment[5]);
    $budgetReason = (new PtglCoaBudgetReasonView)->budgetReasonDesc(getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_REASON', $explodeSegment[7], $explodeSegment[7]);
    $mainAccount = (new PtglCoaMainAccountView)->mainAccountDesc(getPrefixValueSetName().'_GL_ACCT_CODE-MAIN_ACCOUNT', $explodeSegment[8], $explodeSegment[8]);
    $subAccount = (new PtglCoaSubAccountView)->subAccountDesc(getPrefixValueSetName().'_GL_ACCT_CODE-SUB_ACCOUNT', $explodeSegment[9], $explodeSegment[9], $explodeSegment[8]);
    $reserved1 = (new PtglCoaReserved1View)->reserved1Desc(getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED1', $explodeSegment[10], $explodeSegment[10]);
    $reserved2 = (new PtglCoaReserved2View)->reserved2Desc(getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED2', $explodeSegment[11], $explodeSegment[11]);

    //Result
    $company = optional($company)->description ?? null;
    $evm = optional($evm)->description ?? null;
    $department = optional($department)->description ?? null;
    $costCenter = optional($costCenter)->description ?? null;
    $budgetYear = optional($budgetYear)->description ?? null;
    $budgetType = optional($budgetType)->description ?? null;
    $budgetDetail = optional($budgetDetail)->description ?? null;
    $budgetReason = optional($budgetReason)->description ?? null;
    $mainAccount = optional($mainAccount)->description ?? null;
    $subAccount = optional($subAccount)->description ?? null;
    $reserved1 = optional($reserved1)->description ?? null;
    $reserved2 = optional($reserved2)->description ?? null;

    $concatDesc = $company.'.'.$evm.'.'.$department.'.'.$costCenter.'.'.$budgetYear.'.'.$budgetType.'.'.$budgetDetail.'.'.$budgetReason.'.'.$mainAccount.'.'.$subAccount.'.'.$reserved1.'.'.$reserved2;

    return $concatDesc;
}

function getSegmentDisplay($segment_override){
    $explodeSegment = explode('.', $segment_override);
    $department = (new PtglCoaDeptCodeView)->departmentDesc(getPrefixValueSetName().'_GL_ACCT_CODE-DEPT_CODE', $explodeSegment[2], $explodeSegment[2]);
    $mainAccount = (new PtglCoaMainAccountView)->mainAccountDesc(getPrefixValueSetName().'_GL_ACCT_CODE-MAIN_ACCOUNT', $explodeSegment[8], $explodeSegment[8]);
    $subAccount = (new PtglCoaSubAccountView)->subAccountDesc(getPrefixValueSetName().'_GL_ACCT_CODE-SUB_ACCOUNT', $explodeSegment[9], $explodeSegment[9], $explodeSegment[8]);

    //Result
    $department = optional($department)->description ?? null;
    $mainAccount = optional($mainAccount)->description ?? null;
    $subAccount = optional($subAccount)->description ?? null;

    $concatDesc = $department.'.'.$mainAccount.'.'.$subAccount;
    return $concatDesc;
}

function getGlBatch($je_header_id){
    $je_header_id = $je_header_id ?? 0;
    $batchName = collect(\DB::select("
                select b.name
                from gl_je_headers h
                    , gl_je_batches b
                where 1=1
                and h.je_batch_id = b.je_batch_id
                and h.je_header_id = {$je_header_id}"));

    return optional($batchName)->first()->name ?? '';
}

// รายงาน AR Interface 15122021
function getDataArType($type){
    $type = PtirArInterfaceTypeView::where('lookup_code', $type)->first();
    return optional($type)->description ?? '';
}

function getArHeaderOracle($invoice_number){
    $data = collect(\DB::select("
                select RCTA.TRX_NUMBER
                    ,IFACE.interface_id 
                    ,RT.name
                    ,type
                from OAIR.PTIR_AR_INVOICE_INTERFACES IFACE 
                    ,RA_CUSTOMER_TRX_ALL             RCTA
                    ,RA_CUST_TRX_TYPES_ALL           RT
                where 1=1
                AND IFACE.VOUCHER_NUMBER      = RCTA.TRX_NUMBER
                AND IFACE.INTERFACE_STATUS    = 'S'
                AND RCTA.CUST_TRX_TYPE_ID     =  RT.CUST_TRX_TYPE_ID
                AND RCTA.ORG_ID               =  RT.ORG_ID
                AND IFACE.invoice_number      = '{$invoice_number}'"));

    return [ 'transaction_number' => optional($data)->first()->trx_number ?? ''
            , 'invoice_type' => optional($data)->first()->type ?? ''
        ];
}

function getCountPageAll($data, $lineLimit){
    $dataChunk = array_chunk($data, $lineLimit);
    $page = 0;
    foreach ($dataChunk as $values) {
        $page += count($values);
        foreach ($values as $value) {
            if (count($value) > $lineLimit) {
                $dataChunk = array_chunk($value, $lineLimit);
                $page += count($dataChunk) -1;
            }
        }
    }
    return $page;
}

function getGlGroup($group){
    $result = '';
    if ($group == 'CENTRAL') {
        $result = 'ส่วนกลาง';
    }elseif ($group == 'REGION') {
        $result = 'ส่วนภูมิภาค';
    }else{
        $result = 'โรจนะ';
    }

    return $result;
}

function negativeNum($value)
{
    // dd($value);
    return ($value < 0 ? "(".number_format(abs($value),2).")" : number_format($value,2))??'';
}

function getCompanyReport($datas)
{
    $lists = [];
    foreach ($datas as $data) {
        foreach ($data->claimApplyCompany->sortBy('company_id') as $company) {
            
            if (!isset($lists)) {
                array_push($lists, $company->company_name);
            }else {
                if (in_array($company->company_name, $lists)) {

                }else {
                    array_push($lists, $company->company_name);
                }
            }
        }
    }
    return $lists;
}

function allClaimAmount($claims) 
{
    $total = 0;
    foreach ($claims as $claim) {
        foreach ($claim->details as $detail) {
            foreach ($detail->claimApplyCompany as $company) {
                // $total += $company->ar_received_amount ? $company->ar_received_amount * $company->amount_ratio / 100 : 0;
                $total += $company->claim_amount;
            }
        }
    }

    // dd($total);

    return $total;
}

function sumClaimAmount($claim) 
{
    $total = 0;
    foreach ($claim->details as $detail) {
        foreach ($detail->claimApplyCompany as $company) {
            $total += $company->claim_amount;
        }
    }

    // dd($total);

    return $total;
}


function carForReport($month, $list, $carInsuranceDesc) 
{
    // license_plate
    // insurance_type_desc
    // $carInsuranceDesc = $list->insurance_type_desc;
    $monthText        = date('Y', strtotime($month)).date('m', strtotime($month));
    $cars = PtirCars::whereRaw("to_char(end_date, 'YYYYMM')  = '{$monthText}'")
                        ->where('status', 'CONFIRMED')
                        ->where('license_plate', $list->license_plate)
                        ->when($carInsuranceDesc, function($q) use ($carInsuranceDesc) {
                            $q->where('renew_type', $carInsuranceDesc);
                        })
                        ->get();
                        
    // dd($month, $carInsuranceDesc, date('Y', strtotime($month)), $cars);
    return $cars;
}

function expenseType($account)
{
    $coa =  explode('.' , $account);
    
    $mainAccount = (new PtglCoaMainAccountView)->mainAccountDesc(getPrefixValueSetName().'_GL_ACCT_CODE-MAIN_ACCOUNT', $coa[8], $coa[8]);
    $subAccount = (new PtglCoaSubAccountView)->subAccountDesc(getPrefixValueSetName().'_GL_ACCT_CODE-SUB_ACCOUNT', $coa[9], $coa[9], $coa[8]);

    $desc = $mainAccount->description.'.'.$subAccount->description;

    return $desc;
}

function amountByExpenseType($account, $renewType, $groupCode, $monthText, $text)
{
    if ($text) {
        $lists = $account->pluck('prepaid_account');
        $data = PtirExpenseCarGas::whereIn('prepaid_account', $lists)
                                        ->where('status', '!=', 'CANCELLED')
                                        ->where('expense_type_code', 'CAR001')
                                        ->where('period_name', $monthText)
                                        ->where('group_code', $groupCode)
                                        ->where('renew_type', $renewType)
                                        ->get();

        $total = $data->sum('net_amount');

        return $total;
    } else {
        $data = PtirExpenseCarGas::where('prepaid_account', $account)
                                        ->where('status', '!=', 'CANCELLED')
                                        ->where('expense_type_code', 'CAR001')
                                        ->where('period_name', $monthText)
                                        ->where('group_code', $groupCode)
                                        ->where('renew_type', $renewType)
                                        ->get();

        $sum = $data->sum('net_amount');

        return $sum;
    }
}

function insuranceExpense($data, $month)
{
    $monthText        = date('Y', strtotime($month)).date('m', strtotime($month));
    // dd($monthText, $data->license_plate, $data->renew_type);
    $car = PtirCars::whereRaw("to_char(start_date, 'YYYYMM')  = '{$monthText}'")
                        ->where('status', 'CONFIRMED')
                        ->where('license_plate', $data->license_plate)
                        ->where('renew_type', $data->renew_type)
                        ->first();

    $total = $car ? $car->insurance_amount : 0;
    
    return $total;
}

function getVehicleName($code)
{
    $vehicle = PtirVehiclesView::where('vehicle_type_code', $code)->first();
    $name    = $vehicle ? $vehicle->vehicle_type_name : '';
    return $name;
}

function getCompanyList($ID)
{
    $tb_set="
        select 
            DISTINCT pd.user_policy_number, pd.comments, cp.company_number, cp.company_name, pgh.policy_set_number, pgh.policy_set_description
        from 
            ptir_policy_group_dists pd,
            ptir_policy_group_sets ps,
            ptir_companies cp,
            ptir_policy_set_headers pgh
        where 1=1
        and pd.company_code = cp.company_number
        and ps.policy_set_header_id = pgh.policy_set_header_id
        and ps.policy_set_header_id = $ID
        order by company_number asc
        ";

    return $sets = \DB::table(\DB::raw("({$tb_set}) a"))->get();
}

function getDepartmentNameStock($code)
{
    $data = PtirStockLines::where('program_code', 'IRP0002')
                                ->where('department_code', $code)
                                ->first();

    $name    = $data ? $data->department_description : '';
    return $name;
}

function getGroupStock($code)
{
    $data = AssetGroupV::where('value', $code)->first();
    $name = $data ? $data->description : '';
    
    return $name;
}

function getPolicyName($code)
{
    $policy = PtirPolicySetHeaders::where('policy_set_number', $code)->first();
    $name   = $policy ? $policy->policy_set_description : '';
    
    return $name;
}