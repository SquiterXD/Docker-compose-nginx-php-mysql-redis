<?php

namespace App\Http\Controllers\IR\Ajax\Lov;

use App\Http\Controllers\Controller;
use App\Http\Requests\IR\LovRequest;
use App\Models\IR\PtirClaimApplyCompany;
use App\Models\IR\PtirClaimHeader;
use App\Models\IR\Settings\PtirCompanies;
use App\Models\IR\Settings\PtirPolicySetHeaders;
use App\Models\IR\Settings\PtirPolicyGroupHeaders;
use App\Models\IR\Settings\PtirGasStationGroups;
use App\Models\IR\Settings\PtirPolicyGroupSets;
use App\Models\IR\PtirPersons;
use App\Models\IR\Settings\PtirGasStations;
use App\Models\IR\Settings\PtirGroupProducts;
use App\Models\IR\Settings\PtirPolicyGroupDists;
use App\Models\IR\Settings\PtirVehicles;
use App\Models\IR\Views\PtBiweeklyView;
use App\Models\IR\Views\PtfaLocationSeg2View;
use App\Models\IR\Views\PtirVendorView;
use App\Models\IR\Views\PtirVendorBranchView;
use App\Models\IR\Views\PtirCustomerView;
use App\Models\IR\Views\PtirPolicyTypeView;
use App\Models\IR\Views\PtirAccountsMappingView;
use App\Models\IR\Views\PtirGroupsView;
use App\Models\IR\Views\PtirPolicyCategoryView;
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
use App\Models\IR\Views\PtirFaVehiclesView;
use App\Models\IR\Views\PtirRenewCarInsurancesView;
use App\Models\IR\Views\PtirGasStationTypes;
use App\Models\IR\Views\PtirStatus;
use App\Models\IR\Views\PtirStockPeriodsView;
use App\Models\IR\Views\PtirGroupLocationView;
use App\Models\IR\Views\PtirInvOrgView;
use App\Models\IR\Views\PtirSubInventoryView;
use App\Models\IR\Views\PtirSubGroupView;
use App\Models\IR\Views\PtirUomView;
use App\Models\IR\Views\PtirInvoiceTypeView;
use App\Models\IR\Views\PtirGovernerPolicyTypesView;
use App\Models\IR\Views\PtirFaLocationView;
use App\Models\IR\Views\PtirLocationView;
use App\Models\IR\Views\PtirApInterfaceTypeView;
use App\Models\IR\Views\PtirArInterfaceTypeView;
use App\Models\IR\Views\PtirAssetAdjustHeadersView;
use App\Models\IR\Views\PtirAssetCatSegment1View;
use App\Models\IR\Views\PtirAssetCatSegment3View;
use App\Models\IR\Views\PtirAssetGroupView;
use App\Models\IR\Views\PtirAssetReceivableChargeView;
use App\Models\IR\Views\PtirBudgetYearsView;
use App\Models\IR\Views\PtirEffectiveDate;
use App\Models\IR\Views\PtirExpTypeAssetStockView;
use App\Models\IR\Views\PtirExpTypeCarGasView;
use App\Models\IR\Views\PtirGlInterfaceTypeView;
use App\Models\IR\Views\PtirItemView;
use App\Models\IR\Views\PtirPolicySetHeadersView;
use App\Models\IR\Views\PtirToatFaCategorySeg4View;
use App\Models\IR\Views\PtirToatFaCategorySeg5View;
use App\Models\IR\Views\PtirVehiclesView;
use App\Models\IR\Views\PtStatusYnView;
use App\Models\IR\Views\ToatFaBrandView;
use App\Models\IR\PtirExtendGasStations;
use App\Models\IR\PtirExpenseCarGas;
use App\Models\IR\PtirPolicyGroupLine;
use App\Models\IR\Views\FaCatSeg4VehicleV;

use Illuminate\Support\Facades\DB;

class LovController extends Controller
{
    /**
     * ไว้ดึงค่า default สำหรับ irp 0007
     */
    public function defaultirp0007()
    {
        $datas = [];
        //year
        // $year     = PtBiweeklyView::whereRaw("sysdate between start_date and end_date")->first();
        $year     = PtBiweeklyView::whereRaw("
            to_date(to_char(start_date, 'DD-MM-YYYY'), 'DD-MM-YYYY') <= to_date(to_char(sysdate, 'DD-MM-YYYY'), 'DD-MM-YYYY')
            AND to_date(to_char(end_date, 'DD-MM-YYYY'), 'DD-MM-YYYY') >= to_date(to_char(sysdate, 'DD-MM-YYYY'), 'DD-MM-YYYY')
        ")->first();
        // function getBudgetYear()
        // {
        //     $year = date('Y');
        //     $now = new \DateTime();
        //     $chk = new \DateTime($year . '-10-1');
        //     return $now >= $chk ? ($year + 1 + 543) : ($year + 543);
        // }
        // dd($year);
        $datas['period_year'] = $year->period_year; // 2022
        // $datas['period_year'] = getBudgetYear();
        $datas['thai_year'] = $year->period_year_th; // 2565
        // $datas['period_year'] =  date('Y'); // 2565
        // dump('---ค้นหาปี---->' . $year->thai_year); //2565
        $policyqry = PtirPolicySetHeaders::where('active_flag', 'Y')->where('policy_category_code', 50);
        $policycount = $policyqry->count();
        // dump('---policycount-->' . $policycount); // 1
        $datas['policycount'] = $policycount;
        $policy = $policyqry->first();
        if ($policy) {
            // dd($policy);
            $datas['tag'] = $policy->include_tax_flag;
            // dump('policy_set_header_id--->' . $policy->policy_set_header_id); //13
            $policyv = PtirPolicySetHeadersView::where('active_flag', 'Y')
                ->where('gl_expense_account_id', $policy->account_id)
                ->where('policy_set_header_id', $policy->policy_set_header_id)
                ->first();
            // dd($policyv);
            // $datas['policy'] = $policy;
            // $datas['policyv'] = $policyv;
            $datas['policy_set_header_id'] = $policycount > 1 ? '' : $policyv->policy_set_header_id;
            $datas['program_code'] = $policycount > 1 ? '' : $policyv->program_code;
            $datas['policy_set_number'] = $policycount > 1 ? '' : $policyv->policy_set_number;
            $datas['policy_set_description'] = $policycount > 1 ? '' : $policyv->policy_set_description;
            $datas['description'] = $policycount > 1 ? '' : $policyv->description;
            $datas['group_code'] = $policycount > 1 ? '' : $policyv->group_code;
            $datas['group_desc'] = $policycount > 1 ? '' : $policyv->group_desc;
            $datas['policy_age'] = $policycount > 1 ? '' : $policyv->policy_age;
            $datas['account_id'] = $policycount > 1 ? '' : $policyv->account_id;
            $datas['account_code'] = $policycount > 1 ? '' : $policyv->account_code;
            $datas['acd'] = $policycount > 1 ? '' : $policyv->acd;
            $datas['account_combine'] = $policycount > 1 ? '' : $policyv->account_combine;
            $datas['include_tax_flag'] = $policycount > 1 ? '' : $policyv->include_tax_flag;
            $datas['active_flag'] = $policycount > 1 ? '' : $policyv->active_flag;
            $datas['gl_expense_account_id'] = $policycount > 1 ? '' : $policyv->gl_expense_account_id;
            $datas['gl_expense_account_code'] = $policycount > 1 ? '' : $policyv->gl_expense_account_code;
            $datas['gl_expense_account_desc'] = $policycount > 1 ? '' : $policyv->gl_expense_account_desc;
            $datas['gl_expense_account_combine'] = $policycount > 1 ? '' : $policyv->gl_expense_account_combine;
            $datas['account_code_desc'] = $policycount > 1 ? '' : $policyv->account_code_desc;

            // dump('---ค้น policy set header จาก category code 50 ', $policyv);

            $policyset = PtirPolicyGroupSets::where('policy_set_header_id', $policy->policy_set_header_id)->first();
            // $datas['policyset'] = $policyset;
            // dump('----group_header_id"---->' . $policyset->group_header_id); //9
            // dd('--end--');
            if ($policycount === 1 && $policyset) {
                // dd($policyset);
                $policygline = PtirPolicyGroupLine::where('GROUP_HEADER_ID', $policyset->group_header_id)->where('year', $year->period_year)->first();
                // $policygline = PtirPolicyGroupLine::where('GROUP_HEADER_ID', $policyset->group_header_id)->where('year',  date('Y'))->first();
                // $datas['policygline'] = $policygline;
                // dump('$policygline--->' . $policygline[0]->group_line_id);  //27
                if ($policygline) {
                    // dd($policygline);
                    $company = PtirPolicyGroupDists::where('group_header_id', $policyset->group_header_id)->where('group_line_id', $policygline->group_line_id)->orderBy('COMPANY_PERCENT', 'desc')->orderBy('GROUP_DISTRIBUTION_ID', 'asc')->first();
                    // dd($company);
                    /* The above code is returning the company row from the database. */
                    $datas['tax'] = $policygline->tax; // 6
                    $datas['revenue_stamp'] = $policygline->revenue_stamp; // 6
                    $datas['company_code'] = $company->company_code; // รหัสบริษัทประกันภัย
                    $datas['user_policy_number'] = $company->user_policy_number;  // เลข กรรมธรรม
                    // dump('$company->company_code--->' . $company->company_code); // 02
                    $c = PtirCompanies::where('company_number', '02')->first();
                    $datas['company_name'] = $c->company_name; //เทเวย์ประกันภัย
                    // dd($c);
                }
            }
        }

        $response = [];
        $response['datas'] = $datas;
        $response['successed'] = 'true';
        $response['status'] = 200;
        return response($response, $response['status']);
    }

    /**
    * Lov list companies
    */
    public function companiesLov(LovRequest $request)
    {
        $collection = (new PtirCompanies)->getCompaniesLov($request->company_id, $request->keyword);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get all vendor
    */
    public function supplierNumberLov(LovRequest $request) 
    {
        $collection = (new PtirVendorView)->getSupplierNumber($request->vendor_id, $request->keyword);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get all branch code
    */
    public function branchNumberLov(LovRequest $request)
    {
        $collection = (new PtirVendorBranchView)->getBranchNumber($request->vendor_id);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get all customer number and customer name
    */
    public function customerNumberLov(LovRequest $request)
    {
        $collection = (new PtirCustomerView)->getCustomerNumber($request->customer_id, $request->keyword);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get all policy header
    */
    public function policySetHeadersLov(LovRequest $request)
    {
        $collection = (new PtirPolicySetHeaders())->getPolicySetHeadersLov($request->policy_set_header_id, $request->keyword, $request->type, $request->type2);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get all policy type
    */ 
    public function policyTypeLov()
    {
        $collection = (new PtirPolicyTypeView())->getPolicyTypeLov();
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }


    /**
    * Get all account code combine
    */
    public function accountCodeCombineLov(LovRequest $request) 
    {
       $collection = (new PtirAccountsMappingView())->getAccountCodeCombineLov($request->account_id, $request->keyword);
       $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get all gas station group
    */
    public function gasStationGroupLov()
    {
        $collection = (new PtirGasStationGroups())->getGasStaionGroupsLov();
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get all group
    */
    public function groupLov(LovRequest $request)
    {
        $collection = (new PtirGroupsView())->getAllGroup($request->group_code);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get all policy category
    */
    public function policyCategoryLov(LovRequest $request)
    {
        $collection = (new PtirPolicyCategoryView())->getAllPolicyCategory($request->policy_category_code);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get all policy group header
    */
    public function policyGroupHeaderLov(LovRequest $request)
    {
        $collection = (new PtirPolicyGroupHeaders())->getPolicyGroupHeaderLov($request->group_header_id, $request->keyword);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get all policy group header
    */
    public function premiumRateLov(LovRequest $request) 
    {
        $collection = (new PtirPolicyGroupSets())->getPremiumRate($request->policy_set_header_id, $request->date_from, $request->date_to, $request->year);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get all company code
    */
    public function companiesCodeLov(LovRequest $request) 
    {
        $collection = (new PtglCoaCompanyView)->getCompanyCodeLov($request->compnany_code, $request->keyword);
        $response   = getResponse($collection);

       return response($response, $response['status']);
    }

    /**
    * Get all evm code
    */
    public function evmCodeLov(LovRequest $request) 
    {
       $collection = (new PtglCoaEvmView)->getEvmCodeLov($request->evm_code, $request->keyword);
       $response   = getResponse($collection);

       return response($response, $response['status']);
    }

    /**
    * Get all department code
    */
    public function departmentCodeLov(LovRequest $request) 
    {
       $collection = (new PtglCoaDeptCodeView)->getDepartmentCodeLov($request->department_code, $request->keyword);
       $response   = getResponse($collection);

       return response($response, $response['status']);
    }

    /**
    * Get all center code
    */
    public function costCenterCodeLov(LovRequest $request) 
    {
       $collection = (new PtglCoaCostCenterView)->getCostCenterCode($request->cost_center_code, $request->keyword, $request->department_code);
       $response   = getResponse($collection);

       return response($response, $response['status']);
    }

    /**
    * Get all budget year
    */
    public function budgetYearLov(LovRequest $request) 
    {
       $collection = (new PtglCoaBudgetYearView)->getBudgetYear($request->budget_year, $request->keyword);
       $response   = getResponse($collection);

       return response($response, $response['status']);
    }
    
    /**
    * Get all budget type
    */
    public function budgetTypeLov(LovRequest $request) 
    {
       $collection = (new PtglCoaBudgetTypeView)->getBudgetTypeLov($request->budget_type, $request->keyword);
       $response   = getResponse($collection);

       return response($response, $response['status']);
    }

    /**
    * Get all budget detail
    */
    public function budgetDetailLov(LovRequest $request)
    {
        $collection = (new PtglCoaBudgetDetailView)->getBudgetDetailLov($request->budget_detail, $request->keyword, $request->budget_type);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get all budget reason
    */
    public function budgetReasonLov(LovRequest $request)
    {
        $collection = (new PtglCoaBudgetReasonView)->getBudgetReason($request->budget_reason, $request->keyword);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get all main account
    */
    public function mainAccountLov(LovRequest $request)
    {
        $collection = (new PtglCoaMainAccountView)->getMainAccount($request->main_account, $request->keyword);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get all sub account
    */
    public function subAccountLov(LovRequest $request)
    {
        $collection = (new PtglCoaSubAccountView)->getSubAccount($request->sub_account, $request->keyword, $request->main_account);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }


    /**
    * Get all reserved1
    */
    public function reserved1(LovRequest $request)
    {
        $collection = (new PtglCoaReserved1View)->getReserved1($request->reserved1, $request->keyword);
        $response   = getResponse($collection);

       return response($response, $response['status']);
    }

    /**
    * Get all reserved1
    */
    public function reserved2(LovRequest $request)
    {
       $collection = (new PtglCoaReserved2View)->getReserved2($request->reserved2, $request->keyword);
       $response   = getResponse($collection);

       return response($response, $response['status']);
    }

    /**
    * Get license plate
    */
    public function licensePlateLov(LovRequest $request)
    {
       $license_plate = (isset($request->license_plate)) ? $request->license_plate.'%' : '%';
       $collection = PtirVehicles::select('license_plate') 
                                    ->where('license_plate', 'like', '%'.$license_plate.'%')
                                    ->take(50)
                                    ->orderBy('license_plate', 'asc')
                                    ->get();
       $response   = getResponse($collection);

       return response($response, $response['status']);
    }

    /**
    * Get vehicle type
    */
    public function vehiclesTypeLov(LovRequest $request)
    {
        $collection = (new PtirFaVehiclesView())->getVehicleTypeLov($request->vehicle_type_code, $request->keyword);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get renew type
    */
    public function renewTypeLov(LovRequest $request)
    {
        $collection = (new PtirRenewCarInsurancesView())->getRenewTypeLov($request->keyword);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    // Get renew type IRM0007
    public function renewTypeLovIRM07(LovRequest $request)
    {
        $collection = (new PtirRenewCarInsurancesView())->getRenewTypeLovIRM07($request->keyword);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get gas station type
    */
    public function gasStationTypeLov(LovRequest $request)
    {
        $collection = (new PtirGasStationTypes())->getGasStaionsTypeLov($request->keyword);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get status
    */
    public function statusLov() 
    {
        $collection = (new PtirStatus())->getStatusLov();
        $response   = getResponse($collection);

        return response($response['data'], $response['status']);
    }

    /**
    * Get period
    */
    public function periodsLov()
    {
        $collection = (new PtirStockPeriodsView())->getPeriodsLov();
        $response   = getResponse($collection);

        return response($response['data'], $response['status']);
    }

    /**
    * Get group location
    */
    public function groupLocationLov(LovRequest $request)
    {
        $collection = (new PtirGroupLocationView())->getGroupLocationLov($request->lookup_code, $request->keyword);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get sub group
    */
    public function subGroupLov(LovRequest $request)
    {
        $collection = (new PtirSubGroupView())->getAllSubGroupCode($request->policy_set_header_id, $request->keyword);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get organization
    */
    public function orgLov(LovRequest $request)
    {
        $collection = (new PtirInvOrgView())->getAllOrg($request->keyword);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get sub inventory
    */
    public function subInventoryLov(LovRequest $request)
    {
        $collection = (new PtirSubInventoryView())->getAllSubInventory($request->organization_id, $request->keyword);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get uom code
    */
    public function uomLov(LovRequest $request)
    {
        $collection = (new PtirUomView())->getAllUom($request->keyword);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get invoice type
    */
    public function invoiceTypeLov()
    {
        $collection = (new PtirInvoiceTypeView())->getAllInvoiceType();
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get governer policy type
    */
    public function governerPolicyTypeLov(LovRequest $request)
    {
        $collection = (new PtirGovernerPolicyTypesView())->getAllGovernerPolicyType($request->keyword);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get invoice number
    */
    public function invoiceNumberLov()
    {
        $collection = (new PtirPersons())->getAllInvoiceNumberLov();
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Lov department location
    */
    public function departmentLocationLov(LovRequest $request) 
    {
        $collection = (new PtirFaLocationView())->getAllLocation($request->meaning, $request->keyword);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get ap interface type
    */
    public function apInterfaceTypeLov(LovRequest $request)
    {
        $collection = (new PtirApInterfaceTypeView())->getAllApInterfaceType($request->lookup_code, $request->keyword);

        $response   = getResponse($collection);
        return response($response, $response['status']);
    }

    /**
    * Get ap interface type
    */
    public function glInterfaceTypeLov(LovRequest $request)
    {
        $collection = (new PtirGlInterfaceTypeView())->getAllGlInterfaceType($request->lookup_code, $request->keyword);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Lov department location
    */
    public function locationLov(LovRequest $request) 
    {
        $collection = (new PtirLocationView())->getAllLocation($request->meaning, $request->keyword);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get cat segment1
    */
    public function catSegment1Lov(LovRequest $request)
    {
        $collection = (new PtirAssetCatSegment1View())->getAllCatSegment1($request->value, $request->keyword);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get cat segment3
    */
    public function catSegment3Lov(LovRequest $request)
    {
        $collection = (new PtirAssetCatSegment3View())->getAllCatSegment3($request->value, $request->keyword);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get receivable charge
    */
    public function receivableChargeLov(LovRequest $request)
    {
        $collection = (new PtirAssetReceivableChargeView())->getAllAssetReceivableCharge($request->value, $request->keyword);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get effective date
    */
    public function effectiveDateLov(LovRequest $request)
    {
        $collection = (new PtirEffectiveDate())->getEffectiveDate($request->year);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get exp asset stock type
    */
    public function expAssetStockTypeLov(LovRequest $request) 
    {
        $collection = (new PtirExpTypeAssetStockView())->getTypeAssetStock($request->lookup_code, $request->keyword);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get exp car gas type
    */
    public function expCarGasTypeLov(LovRequest $request) 
    {
        $collection = (new PtirExpTypeCarGasView())->getTypeCarGas($request->lookup_code, $request->keyword);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get ar invoice num lov
    */
    public function arInvoiceNumLov(LovRequest $request) 
    {
        $collection = (new PtirClaimApplyCompany())->getArInvoiceLov($request->claim_apply_id, $request->keyword);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get policy vehicle lov
    */
    public function policySetHeadersVehicleLov(LovRequest $request) 
    {
        $collection = (new PtirFaVehiclesView())->getPolicySetHeaderLov($request->asset_number, $request->keyword);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get group code from policy_set_headers lov
    */
    public function groupCodePolicyLov(LovRequest $request) 
    {
        $collection = (new PtirPolicySetHeadersView())->getGroupLov($request->policy_set_header_id);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get revision lov
    */
    public function revisionLov(LovRequest $request) 
    {
        $collection = (new PtirAssetAdjustHeadersView())->getRevisionLov();
        $response   = getResponse($collection);

       return response($response, $response['status']);
    }

    /**
    * Get budget period year lov
    */
    public function budgetPeriodYearLov(LovRequest $request) 
    {
        $collection = PtirBudgetYearsView::all();
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get asset status lov
    */
    public function assetStatusLov(LovRequest $request) 
    {
        $collection = (new PtStatusYnView())->getStatus();
        $response   = getResponse($collection);
        return response($response, $response['status']);
    }

    /**
    * Get vehicle license plate lov
    */
    public function getVehicleLicensePlateLov(LovRequest $request)
    {
        $collection = (new PtirVehiclesView())->getLicensePlate($request->license_plate, 
                                                                $request->renew_type, 
                                                                $request->group,
                                                                $request->department_from,
                                                                $request->department_to);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get gas station type lov
    */
    public function gasStationTypeMasterLov(LovRequest $request)
    {
        $collection = (new PtirGasStations())->getGasStationsTypeLov($request->type_code);
        $response   = getResponse($collection);
        return response($response, $response['status']);
    }

    /**
    * Get claim document number lov
    */
    public function claimDocumentNumberLov(LovRequest $request)
    {
        $collection = (new PtirClaimHeader())->getDocumentNumber($request->keyword);
        $response   = getResponse($collection);
        return response($response, $response['status']);
    }
    // หน้า transaction ipr0010/irp0011
    public function irpDocumentNumberLov(LovRequest $request)
    {
        $collection = (new PtirClaimHeader())->getIRPDocumentNumber($request->keyword);
        $response   = getResponse($collection);
        return response($response, $response['status']);
    }
    // หน้า AR Interface
    public function ARDocumentNumberLov(LovRequest $request)
    {
        $collection = (new PtirClaimHeader())->getARDocumentNumber($request->keyword);
        $response   = getResponse($collection);
        return response($response, $response['status']);
    }

    /**
    * Gen company number
    */
    public function genCompanyNumber() {
        $collection = (new PtirCompanies())->genCompanyNumber();
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get policy id from claim
    */
    public function policySetHeadersClaimLov(LovRequest $request) {
        $collection = (new PtirClaimApplyCompany())->getPolicyNumber($request->keyword);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get group proportion
    */
    public function companyPercent(LovRequest $request) {
        $collection = (new PtirPolicyGroupDists())->getPercent($request->group_header_id, $request->year);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get policy_set_header_id from policy group
    */
    public function policyFromPolicyGroup(LovRequest $request) {
        $collection = (new PtirPolicyGroupSets())->getPolicyId($request->group_header_id);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get vehicle brand
    */
    public function vehicleBrand(LovRequest $request) {
        $collection = (new ToatFaBrandView())->getBrand($request->value, $request->keyword);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get category seg 4
    */
    public function categorySeg4(LovRequest $request) {
        $collection = (new PtirToatFaCategorySeg4View())->getAll($request->value, $request->keyword);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get category seg 5
     */
    public function categorySeg5(LovRequest $request) {
        $collection = (new PtirToatFaCategorySeg5View())->getByParent($request->value, $request->keyword, $request->parent_flex);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get asset group
    */
    public function assetGroup(LovRequest $request) {
        $collection = (new PtirAssetGroupView())->getGroup($request->value, $request->keyword);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get ar interface type code
    */
    public function arInterfaceType(LovRequest $request) {
        $collection = (new PtirArInterfaceTypeView())->getAllArInterfaceType($request->lookup_code, $request->keyword);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
    * Get default rate for irm0007
    */
    public function vehicleRate(LovRequest $request) {
        $collection = (new PtirPolicyGroupSets())->getLastRecordRate($request->policy_set_header_id);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    public function getGroupProducts(LovRequest $request) {
        $keyword = (isset($request->keyword)) ? '%'.$request->keyword.'%' : '%';
        $products = PtirGroupProducts::whereRaw("group_product_id = nvl(?, group_product_id)
            and description like ?
            and asset_group_code = nvl(?, asset_group_code)
            and policy_set_header_id = ?", 
            [$request->group_product_id, $keyword, $request->asset_group_code, $request->policy_set_header_id])
            ->get();

        $response = array();
        foreach ($products as $product) {
            $res['value']       = isset($product->group_product_id) ? $product->group_product_id : '';
            $res['description'] = isset($product->description) ? $product->description : '';
            $res['account_id']  = isset($product->account_id) ? $product->account_id : '';
            $res['account_combine'] = optional($product->accountMap)->account_combine;
            $res['active_flag'] = $product->active_flag;

            array_push($response, $res);
        }

        $response = getResponse($response);

        return response($response, $response['status']);
    }

    public function getItems(LovRequest $request)
    {
        $keyword = (isset($request->keyword)) ? '%' . $request->keyword . '%' : '%';
        $items = PtirItemView::whereRaw("item_code like ? or item_description like ?", [$keyword, $keyword])->limit(50)->get();
        $response = array();
        foreach ($items as $item) {
            $res['value']       = isset($item->item_code) ? $item->item_code : '';
            $res['description'] = isset($item->item_description) ? $item->item_description : '';
            $res['uom_code']    = isset($item->uom_code) ? $item->uom_code : '';
            $res['uom_desc']    = isset($item->uom_desc) ? $item->uom_desc : '';

            array_push($response, $res);
        }

        $response = getResponse($response);

        return response($response, $response['status']);
    }

    public function getLocationSeg2(LovRequest $request)
    {
        $keyword = (isset($request->keyword)) ? '%' . $request->keyword . '%' : '%';
        $locations = PtfaLocationSeg2View::whereRaw('meaning like ? or description like ?', [$keyword, $keyword])
            ->get();
        $response = array();
        foreach ($locations as $location) {
            $res['value']       = isset($location->segment2) ? $location->segment2 : '';
            $res['meaning']     = isset($location->meaning) ? $location->meaning : '';
            $res['description'] = isset($location->description) ? $location->description : '';

            array_push($response, $res);
        }

        $response = getResponse($response);

        return response($response, $response['status']);
    }

    public function getDefaultPeriodYear()
    {
        $year     = PtBiweeklyView::whereRaw("
            to_date(to_char(start_date, 'DD-MM-YYYY'), 'DD-MM-YYYY') <= to_date(to_char(sysdate, 'DD-MM-YYYY'), 'DD-MM-YYYY')
            AND to_date(to_char(end_date, 'DD-MM-YYYY'), 'DD-MM-YYYY') >= to_date(to_char(sysdate, 'DD-MM-YYYY'), 'DD-MM-YYYY')
        ")->first();
        $response['period_year'] = isset($year->period_year) ? (int)$year->period_year + 543 : '';
        $response = getResponse($response);

        return response($response, $response['status']);
    }

    public function getDefaultAccountForGovernor(LovRequest $request)
    {
        $account = DB::table('ptir_policy_group_sets a')->select('c.company_id', 'c.company_code', 'd.account_id')
            ->join('ptir_policy_group_lines b', 'a.group_header_id', '=', 'b.group_header_id')
            ->join('ptir_policy_group_dists c', 'b.group_line_id', '=', 'c.group_line_id')
            ->join('ptir_policy_set_headers d', 'a.policy_set_header_id', '=', 'd.policy_set_header_id')
            ->whereRaw("a.policy_set_header_id = ?
                                    and b.year = ?
                                    ", [$request->policy_set_header_id, $request->year])
            ->orderBy('c.company_percent', 'desc')
            ->first();

        $response = getResponse($account);

        return response($response, $response['status']);
    }

    public function assetGroupByProduct(LovRequest $request) {
        $collection = (new PtirAssetGroupView())->getGroupByProduct($request->value, $request->keyword, $request->policy_set_header_id);
        $response   = getResponse($collection);
       
        return response($response, $response['status']);
    }
    
    public function categorySeg4Vehicle(LovRequest $request)
    {
        $collection = (new FaCatSeg4VehicleV())->getAll($request->value, $request->keyword);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }
}
