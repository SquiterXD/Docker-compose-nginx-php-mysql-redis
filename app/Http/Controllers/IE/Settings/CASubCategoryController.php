<?php

namespace App\Http\Controllers\IE\Settings;

use Illuminate\Http\Request;

use App\Http\Requests\IE\CASubCategoriesStoreRequest;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\IE\CACategory;
use App\Models\IE\CASubCategory;
use App\Models\IE\Policy;
use App\Models\IE\Preference;
use App\Models\IE\AccountInfo;
use App\Models\IE\FNDListOfValues;
use App\Models\IE\VAT;
use App\Models\IE\WHT;
use App\Models\IE\AccessibleOrg;
use App\Models\IE\HrOperatingUnit;

class CASubCategoryController extends Controller
{
    protected $perPage = 10;
    protected $orgId;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->orgId = getDefaultData()->bu_id;
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CACategory $ca_category)
    {
        $ca_sub_categories = CASubCategory::where('ca_category_id',$ca_category->ca_category_id)
                                // ->accessibleOrg($this->orgId)
                                ->paginate($this->perPage);
        $operatingUnits = HrOperatingUnit::all();

        return view('ie.settings.ca-sub-categories.index',
        	compact('ca_category',
        			'ca_sub_categories',
                    'operatingUnits'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  SubCategory $ca_sub_category
     * @return \Illuminate\Http\Response
     */
    public function create(CACategory $ca_category)
    {
        $year = getBudgetYear();

        $defaultCombinationCode = '01.0.00000000.00.'. $year .'.000.000000.0.651000.000.0.0';
        
        $defaultUseAllCOAFlag = 'N';
        $defaultCompanyCode = '01';
        $defaultEVMCode = '0';
        $defaultDepartmentCode = '00000000';
        $defaultCostCenterCode = '00';
        $defaultBudgetYearCode = $year;
        $defaultBudgetTypeCode = '000';
        $defaultBudgetDetailCode = '000000';
        $defaultBudgetReasonCode = '0';
        $defaultAccountCode = '651000';
        $defaultSubAccountCode = '000';
        $defaultReserve1Code = '0';
        $defaultReserve2Code = '0';

        $companyLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->company($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $evmLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->EVM($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $departmentLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->enabled()->department($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $costCenterLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->costCenter($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $budgetYearLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->budgetYear($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $budgetTypeLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->budgetType($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $budgetDetailLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->budgetDetail($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $budgetReasonLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->budgetReason($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $accountLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->account($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $subAccountLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->subAccount($this->orgId)->where('flex_value', $defaultSubAccountCode)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $reserve1Lists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->reserve1($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $reserve2Lists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->reserve2($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();

        $VATLists = VAT::apVat()->where('org_id',$this->orgId)->pluck('tax','tax_rate_code')->all();
        $WHTLists = WHT::where('org_id',$this->orgId)->pluck('wht_name','pay_awt_group_id')->all();
        $operatingUnits = HrOperatingUnit::all();

        return view('ie.settings.ca-sub-categories.create',
            compact('ca_category',
                    'VATLists',
                    'WHTLists',
                    'defaultCombinationCode',
                    'defaultUseAllCOAFlag',
                    'defaultCompanyCode',
                    'defaultEVMCode',
                    'defaultDepartmentCode',
                    'defaultCostCenterCode',
                    'defaultBudgetYearCode',
                    'defaultBudgetTypeCode',
                    'defaultBudgetDetailCode',
                    'defaultBudgetReasonCode',
                    'defaultAccountCode',
                    'defaultSubAccountCode',
                    'defaultReserve1Code',
                    'defaultReserve2Code',
                    'companyLists',
                    'evmLists',
                    'departmentLists',
                    'costCenterLists',
                    'budgetYearLists',
                    'budgetTypeLists',
                    'budgetDetailLists',
                    'budgetReasonLists',
                    'accountLists',
                    'subAccountLists',
                    'reserve1Lists',
                    'reserve2Lists',
                    'operatingUnits'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  SubCategory $ca_sub_category
     * @return \Illuminate\Http\Response
     */
    public function store(CASubCategoriesStoreRequest $request, CACategory $ca_category)
    {
        $ca_sub_category  = new CASubCategory();
        // $ca_sub_category->org_id = $this->orgId;
        $ca_sub_category->ca_category_id = $ca_category->ca_category_id;
        $ca_sub_category->name = $request->name;
        $ca_sub_category->description = $request->description;
        $ca_sub_category->start_date = \DateTime::createFromFormat(trans('date.format'), $request->start_date)->format('Y-m-d');
        if($request->end_date){
            $ca_sub_category->end_date = \DateTime::createFromFormat(trans('date.format'), $request->end_date)->format('Y-m-d');
        }else{
            $ca_sub_category->end_date = null;
        }

        $year = getBudgetYear();
        $ca_sub_category->use_all_coa_flag = $request->use_all_coa_flag ?? 'N';

        $ca_sub_category->company_code = $request->company_code ?? '01';
        $ca_sub_category->evm_code = $request->evm_code ??  '0';
        $ca_sub_category->department_code = $request->department_code ?? '00000000';
        $ca_sub_category->cost_center_code = $request->cost_center_code ?? '00';
        
        $ca_sub_category->budget_year_code = $request->budget_year_code ?? $year;
        $ca_sub_category->budget_type_code = $request->budget_type_code ?? '000';
        $ca_sub_category->budget_detail_code = $request->budget_detail_code ?? '000000';
        $ca_sub_category->budget_reason_code = $request->budget_reason_code ?? '0';

        $ca_sub_category->account_code = $request->account_code ?? '651000';
        $ca_sub_category->sub_account_code = $request->sub_account_code ?? '000';
        $ca_sub_category->reserve1_code = $request->reserve1_code ?? '0';
        $ca_sub_category->reserve2_code = $request->reserve2_code ?? '0';

        $ca_sub_category->vat_id = $request->vat_id;
        $ca_sub_category->wht_id = $request->wht_id;
        $ca_sub_category->branch_code = $request->branch_code ? $request->branch_code : null;

        $ca_sub_category->required_attachment = $request->required_attachment ? true : false ;

        if($request->ca_min_amount){
            $ca_sub_category->check_ca_min =  true;
            $ca_sub_category->ca_min_amount = $request->ca_min_amount;
        }else{
            $ca_sub_category->check_ca_min =  false;
            $ca_sub_category->ca_min_amount = null;
        }
        if($request->ca_max_amount){
            $ca_sub_category->check_ca_max =  true;
            $ca_sub_category->ca_max_amount = $request->ca_max_amount;
        }else{
            $ca_sub_category->check_ca_max =  false;
            $ca_sub_category->ca_max_amount = null;
        }
        $ca_sub_category->use_second_unit = $request->use_second_unit ? true : false ;
        if(!$request->use_second_unit){
            $ca_sub_category->unit = $request->unit;
        }else{
            $ca_sub_category->unit = $request->unit_1;
            $ca_sub_category->second_unit = $request->unit_2;
        }
        $ca_sub_category->active = $request->active ? true : false ;
        $ca_sub_category->last_updated_by = -1;
        $ca_sub_category->created_by = -1;
        $ca_sub_category->save();


        $request->accessible_orgs = ['81'];

        // SAVE ACCESIBLE ORG
        foreach($request->accessible_orgs as $accessible_org_id){
            $accessibleOrg = new AccessibleOrg();
            $accessibleOrg->org_id = $accessible_org_id;
            $accessibleOrg->last_updated_by = -1;
            $accessibleOrg->created_by = -1;
            $ca_sub_category->accessibleOrgs()->save($accessibleOrg);
        }

        return redirect()->route('ie.settings.ca-sub-categories.index',[$ca_category->ca_category_id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  SubCategory $ca_sub_category
     * @return \Illuminate\Http\Response
     */
    public function edit(CACategory $ca_category, CASubCategory $ca_sub_category)
    {
        $ca_sub_category->accessible_orgs = $ca_sub_category->accessibleOrgs()->pluck('org_id')->all();
        $ca_sub_category->start_date = dateFormatDisplay($ca_sub_category->start_date);
        $ca_sub_category->end_date = dateFormatDisplay($ca_sub_category->end_date);
        
        $year = getBudgetYear();

        $defaultUseAllCOAFlag = $ca_sub_category->use_all_coa_flag ?? 'N';
        $defaultCompanyCode = $ca_sub_category->company_code ?? '01';
        $defaultEVMCode = $ca_sub_category->evm_code ?? '0';
        $defaultDepartmentCode = $ca_sub_category->department_code ?? '00000000';
        $defaultCostCenterCode = $ca_sub_category->cost_center_code ?? '00';
        $defaultBudgetYearCode = $ca_sub_category->budget_year_code ?? $year;
        $defaultBudgetTypeCode = $ca_sub_category->budget_type_code ?? '000';
        $defaultBudgetDetailCode = $ca_sub_category->budget_detail_code ?? '000000';
        $defaultBudgetReasonCode = $ca_sub_category->budget_reason_code ?? '0';
        $defaultAccountCode = $ca_sub_category->account_code ?? '651000';
        $defaultSubAccountCode = $ca_sub_category->sub_account_code ?? '000';
        $defaultReserve1Code = $ca_sub_category->reserve1_code ?? '0';
        $defaultReserve2Code = $ca_sub_category->reserve2_code ?? '0';

        $defaultCombinationCode = $defaultCompanyCode.'.'.$defaultEVMCode.'.'.$defaultDepartmentCode.'.'.$defaultCostCenterCode.'.'.$defaultBudgetYearCode.'.'.$defaultBudgetTypeCode.'.'.$defaultBudgetDetailCode.'.'.$defaultBudgetReasonCode.'.'.$defaultAccountCode.'.'.$defaultSubAccountCode.'.'.$defaultReserve1Code.'.'.$defaultReserve2Code;

        $companyLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->company($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $evmLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->EVM($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $departmentLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->department($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $costCenterLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->costCenter($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $budgetYearLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->budgetYear($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $budgetTypeLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->budgetType($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $budgetDetailLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->budgetDetail($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $budgetReasonLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->budgetReason($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $accountLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->account($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $subAccountLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->subAccount($this->orgId)->where('flex_value', $defaultSubAccountCode)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $reserve1Lists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->reserve1($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $reserve2Lists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->reserve2($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();

        $VATLists = VAT::apVat()->where('org_id',$this->orgId)->pluck('tax','tax_rate_code')->all();
        $WHTLists = WHT::where('org_id',$this->orgId)->pluck('wht_name','pay_awt_group_id')->all();
        $operatingUnits = HrOperatingUnit::all();

        return view('ie.settings.ca-sub-categories.edit',
            compact('ca_category',
                    'ca_sub_category',
                    'VATLists',
                    'WHTLists',
                    'defaultUseAllCOAFlag',
                    'defaultSubAccountCode',
                    'defaultCombinationCode',
                    'defaultCompanyCode',
                    'defaultEVMCode',
                    'defaultDepartmentCode',
                    'defaultCostCenterCode',
                    'defaultBudgetYearCode',
                    'defaultBudgetTypeCode',
                    'defaultBudgetDetailCode',
                    'defaultBudgetReasonCode',
                    'defaultAccountCode',
                    'defaultSubAccountCode',
                    'defaultReserve1Code',
                    'defaultReserve2Code',
                    'companyLists',
                    'evmLists',
                    'departmentLists',
                    'costCenterLists',
                    'budgetYearLists',
                    'budgetTypeLists',
                    'budgetDetailLists',
                    'budgetReasonLists',
                    'accountLists',
                    'subAccountLists',
                    'reserve1Lists',
                    'reserve2Lists',
                    'operatingUnits'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  SubCategory $ca_sub_category
     * @return \Illuminate\Http\Response
     */
    public function update(CASubCategoriesStoreRequest $request, CACategory $ca_category, CASubCategory $ca_sub_category)
    {
        $ca_sub_category->name = $request->name;
        $ca_sub_category->description = $request->description;
        $ca_sub_category->start_date = \DateTime::createFromFormat(trans('date.format'), $request->start_date)->format('Y-m-d');
        if($request->end_date){
            $ca_sub_category->end_date = \DateTime::createFromFormat(trans('date.format'), $request->end_date)->format('Y-m-d');
        }else{
            $ca_sub_category->end_date = null;
        }

        $year = getBudgetYear();
        $ca_sub_category->use_all_coa_flag = $request->use_all_coa_flag ?? 'N';

        $ca_sub_category->company_code = $request->company_code ?? $ca_sub_category->company_code;
        $ca_sub_category->evm_code = $request->evm_code ?? $ca_sub_category->evm_code;
        $ca_sub_category->department_code = $request->department_code ?? $ca_sub_category->department_code;
        $ca_sub_category->cost_center_code = $request->cost_center_code ?? $ca_sub_category->cost_center_code;
        
        $ca_sub_category->budget_year_code = $request->budget_year_code ?? $ca_sub_category->budget_year_code;
        $ca_sub_category->budget_type_code = $request->budget_type_code ?? $ca_sub_category->budget_type_code;
        $ca_sub_category->budget_detail_code = $request->budget_detail_code ?? $ca_sub_category->budget_detail_code;
        $ca_sub_category->budget_reason_code = $request->budget_reason_code ?? $ca_sub_category->budget_reason_code;

        $ca_sub_category->account_code = $request->account_code ?? $ca_sub_category->account_code;
        $ca_sub_category->sub_account_code = $request->sub_account_code ?? $ca_sub_category->sub_account_code;

        $ca_sub_category->reserve1_code = $request->reserve1_code ?? $ca_sub_category->reserve1_code;
        $ca_sub_category->reserve2_code = $request->reserve2_code ?? $ca_sub_category->reserve2_code;

        $ca_sub_category->vat_id = $request->vat_id;
        $ca_sub_category->wht_id = $request->wht_id;
        $ca_sub_category->branch_code = $request->branch_code ? $request->branch_code : null;

        $ca_sub_category->required_attachment = $request->required_attachment ? true : false ;

        if($request->ca_min_amount){
            $ca_sub_category->check_ca_min =  true;
            $ca_sub_category->ca_min_amount = $request->ca_min_amount;
        }else{
            $ca_sub_category->check_ca_min =  false;
            $ca_sub_category->ca_min_amount = null;
        }
        if($request->ca_max_amount){
            $ca_sub_category->check_ca_max =  true;
            $ca_sub_category->ca_max_amount = $request->ca_max_amount;
        }else{
            $ca_sub_category->check_ca_max =  false;
            $ca_sub_category->ca_max_amount = null;
        }
        $ca_sub_category->use_second_unit = $request->use_second_unit ? true : false ;
        if(!$request->use_second_unit){
            $ca_sub_category->unit = $request->unit;
        }else{
            $ca_sub_category->unit = $request->unit_1;
            $ca_sub_category->second_unit = $request->unit_2;
        }

        $ca_sub_category->active = $request->active ? true : false ;
        $ca_sub_category->last_updated_by = -1;
        $ca_sub_category->save();


        $request->accessible_orgs = ['81'];

        $oldAccessibleOrgs = $ca_sub_category->accessibleOrgs()->pluck('org_id')->all();
        if($request->accessible_orgs != $oldAccessibleOrgs){
            // DELETE OLD ACCESIBLE ORG
            foreach($ca_sub_category->accessibleOrgs as $accessibleOrg){
                $accessibleOrg->delete();
            }
            // SAVE NEW ACCESIBLE ORG
            foreach($request->accessible_orgs as $accessible_org_id){
                $accessibleOrg = new AccessibleOrg();
                $accessibleOrg->org_id = $accessible_org_id;
                $accessibleOrg->last_updated_by = -1;
                $accessibleOrg->created_by = -1;
                $ca_sub_category->accessibleOrgs()->save($accessibleOrg);
            }
        }

        return redirect()->route('ie.settings.ca-sub-categories.index',[$ca_category->ca_category_id]);
    }

    public function inputSubAccountCode(Request $request, CACategory $ca_category)
    {
        $accountInfo = AccountInfo::whereOrgId($this->orgId)
                        ->subAccount()
                        ->first();
        $accountCode = $request->account_code;
        $subAccountCode = $request->sub_account_code;
        $subAccountLists = [''=>'-'];
        if($accountCode){
            $subAccountLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->subAccount($this->orgId)->byParentValue($accountInfo->parent_flex_value_set_name,$accountCode)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        }
        return view('ie.settings.ca-sub-categories._ddl_sub_account_code',
            compact('subAccountLists','subAccountCode'));
    }
}
