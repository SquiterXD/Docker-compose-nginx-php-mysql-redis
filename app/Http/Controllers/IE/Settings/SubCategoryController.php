<?php

namespace App\Http\Controllers\IE\Settings;

use App\Models\IE\Category;
use App\Models\IE\SubCategory;
use App\Models\IE\Policy;
use App\Models\IE\Preference;
use App\Models\IE\AccountInfo;
use App\Models\IE\FNDListOfValues;
use App\Models\IE\VAT;
use App\Models\IE\WHT;
use App\Models\IE\AccessibleOrg;
use App\Models\IE\HrOperatingUnit;

use App\Http\Requests\IE\SubCategoriesStoreRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
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
    public function index(Category $category)
    {

        $sub_categories = SubCategory::whereCategoryId($category->category_id)
                            ->orderBy('name')
                            ->paginate($this->perPage);
        $operatingUnits = HrOperatingUnit::all();

        return view('ie.settings.sub-categories.index',
            compact(
                'category',
                'sub_categories',
                'operatingUnits'
            ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  SubCategory $sub_category
     * @return \Illuminate\Http\Response
     */
    public function create(Category $category)
    {
        $year = getBudgetYear();

        $defaultCombinationCode = '01.0.00000000.00.'. $year .'.000.000000.0.651000.000.0.0';

        // $VATLists = VAT::apVat()->where('org_id',$this->orgId)->pluck('tax','tax_rate_code')->all();
        // $WHTLists = WHT::where('org_id',$this->orgId)->pluck('wht_name','pay_awt_group_id')->all();
        $VATLists = VAT::apVat()->pluck('tax','tax_rate_code')->all();
        $WHTLists = WHT::pluck('wht_name','pay_awt_group_id')->all();
        $operatingUnits = HrOperatingUnit::all();
        $selectOrg = [];

        return view('ie.settings.sub-categories.create',
            compact(
                'category',
                'VATLists',
                'WHTLists',
                'defaultCombinationCode',
                'operatingUnits',
                'selectOrg'
            ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  SubCategory $sub_category
     * @return \Illuminate\Http\Response
     */
    public function store(SubCategoriesStoreRequest $request, Category $category)
    {

        $user = auth()->user();
        $sub_category  = new SubCategory();
        $sub_category->category_id = $category->category_id;
        $sub_category->name = $request->name;
        $sub_category->description = $request->description;
        $sub_category->start_date = \DateTime::createFromFormat(trans('date.format'), $request->start_date)->format('Y-m-d');
        if($request->end_date){
            $sub_category->end_date = \DateTime::createFromFormat(trans('date.format'), $request->end_date)->format('Y-m-d');
        }else{
            $sub_category->end_date = null;
        }

        $year = getBudgetYear();

        $combination_code = $request->combination_code;
        $segments = explode('.', $combination_code);
        if( count($segments) != 12 ){
            return back()->withErrors('Combination Code Error');
        }

        $sub_category->company_code = $segments[0] ?? '01';
        $sub_category->evm_code = $segments[1] ??  '0';
        $sub_category->department_code = $segments[2] ?? '00000000';
        $sub_category->cost_center_code = $segments[3] ?? '00';

        $sub_category->budget_year_code = $segments[4] ?? $year;
        $sub_category->budget_type_code = $segments[5] ?? '000';
        $sub_category->budget_detail_code = $segments[6] ?? '000000';
        $sub_category->budget_reason_code = $segments[7] ?? '0';

        $sub_category->account_code = $segments[8] ?? '651000';
        $sub_category->sub_account_code = $segments[9] ?? '000';
        $sub_category->reserve1_code = $segments[10] ?? '0';
        $sub_category->reserve2_code = $segments[11] ?? '0';

        $sub_category->vat_id = $request->vat_id;
        $sub_category->wht_id = $request->wht_id;
        $sub_category->use_second_unit = $request->use_second_unit ? true : false ;

        if(!$request->use_second_unit){
            $sub_category->unit = $request->unit;
        }else{
            $sub_category->unit = $request->unit_1;
            $sub_category->second_unit = $request->unit_2;
        }
        $sub_category->required_attachment = $request->required_attachment ? true : false ;
        $sub_category->allow_exceed_policy = $request->allow_exceed_policy ? true : false ;
        $sub_category->active = $request->active ? true : false ;
        $sub_category->use_in_reim = $request->use_in_reim ? true : false ;
        $sub_category->use_in_ca = $request->use_in_ca ? true : false ;
        $sub_category->use_all_segments = $request->use_all_segments ? true : false ;
        $sub_category->update_only_budget_year = $request->update_only_budget_year ? true : false ;
        $sub_category->wht_flag = $request->wht_flag ? true : false ;
        if($sub_category->wht_flag){
            $sub_category->org_options = $request->org_options;
        }else {
            $sub_category->org_options = [];
        }
        $sub_category->last_updated_by = $user->user_id;
        $sub_category->created_by = $user->user_id;
        $sub_category->save();

        $operatingUnits = HrOperatingUnit::all();

        // SAVE ACCESIBLE ORG
        foreach($operatingUnits as $org){
            $accessibleOrg = new AccessibleOrg();
            $accessibleOrg->org_id = $org->organization_id;
            $accessibleOrg->last_updated_by = $user->user_id;
            $accessibleOrg->created_by = $user->user_id;
            $sub_category->accessibleOrgs()->save($accessibleOrg);
        }

        // $request->accessible_orgs = ['81'];

        // // SAVE ACCESIBLE ORG
        // foreach($request->accessible_orgs as $accessible_org_id){
        //     $accessibleOrg = new AccessibleOrg();
        //     $accessibleOrg->org_id = $accessible_org_id;
        //     $accessibleOrg->last_updated_by = $user->user_id;
        //     $accessibleOrg->created_by = $user->user_id;
        //     $sub_category->accessibleOrgs()->save($accessibleOrg);
        // }

        return redirect()->route('ie.settings.sub-categories.index',[$category->category_id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  SubCategory $sub_category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category, SubCategory $sub_category)
    {
        $sub_category->accessible_orgs = $sub_category->accessibleOrgs()->pluck('org_id')->all();
        $sub_category->start_date = dateFormatDisplay($sub_category->start_date);
        $sub_category->end_date = dateFormatDisplay($sub_category->end_date);
        
        $year = getBudgetYear();

        $defaultUseAllCOAFlag = $sub_category->use_all_coa_flag ?? 'N';
        $defaultCombinationCode = $sub_category->combination_code;

        // $VATLists = VAT::apVat()->where('org_id',$this->orgId)->pluck('tax','tax_rate_code')->all();
        // $WHTLists = WHT::where('org_id',$this->orgId)->pluck('wht_name','pay_awt_group_id')->all();
        $VATLists = VAT::apVat()->pluck('tax','tax_rate_code')->all();
        $WHTLists = WHT::pluck('wht_name','pay_awt_group_id')->all();
        $operatingUnits = HrOperatingUnit::all();
        $selectOrg = optional($sub_category)->org_options ?? [];

        return view('ie.settings.sub-categories.edit',
            compact(
                'category',
                'sub_category',
                'VATLists',
                'WHTLists',
                'defaultCombinationCode',
                'operatingUnits',
                'selectOrg'
            ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  SubCategory $sub_category
     * @return \Illuminate\Http\Response
     */
    public function update(SubCategoriesStoreRequest $request, Category $category, SubCategory $sub_category)
    {
        $user = auth()->user();
        $sub_category->name = $request->name;
        $sub_category->description = $request->description;
        $sub_category->start_date = \DateTime::createFromFormat(trans('date.format'), $request->start_date)->format('Y-m-d');
        if($request->end_date){
            $sub_category->end_date = \DateTime::createFromFormat(trans('date.format'), $request->end_date)->format('Y-m-d');
        }else{
            $sub_category->end_date = null;
        }

        $year = getBudgetYear();

        $combination_code = $request->combination_code;
        $segments = explode('.', $combination_code);
        if( count($segments) != 12 ){
            return back()->withErrors('Combination Code Error');
        }

        $sub_category->company_code = $segments[0] ?? $sub_category->company_code;
        $sub_category->evm_code = $segments[1] ?? $sub_category->evm_code;
        $sub_category->department_code = $segments[2] ?? $sub_category->department_code;
        $sub_category->cost_center_code = $segments[3] ?? $sub_category->cost_center_code;

        $sub_category->budget_year_code = $segments[4] ?? $sub_category->budget_year_code;
        $sub_category->budget_type_code = $segments[5] ?? $sub_category->budget_type_code;
        $sub_category->budget_detail_code = $segments[6] ?? $sub_category->budget_detail_code;
        $sub_category->budget_reason_code = $segments[7] ?? $sub_category->budget_reason_code;

        $sub_category->account_code = $segments[8] ?? $sub_category->account_code;
        $sub_category->sub_account_code = $segments[9] ?? $sub_category->sub_account_code;
        $sub_category->reserve1_code = $segments[10] ?? $sub_category->reserve1_code;
        $sub_category->reserve2_code = $segments[11] ?? $sub_category->reserve2_code;

        $sub_category->vat_id = $request->vat_id;
        $sub_category->wht_id = $request->wht_id;
        $sub_category->use_second_unit = $request->use_second_unit ? true : false ;
        if(!$request->use_second_unit){
            $sub_category->unit = $request->unit;
        }else{
            $sub_category->unit = $request->unit_1;
            $sub_category->second_unit = $request->unit_2;
        }
        $sub_category->required_attachment = $request->required_attachment ? true : false ;
        $sub_category->allow_exceed_policy = $request->allow_exceed_policy ? true : false ;
        $sub_category->active = $request->active ? true : false ;
        $sub_category->use_in_reim = $request->use_in_reim ? true : false ;
        $sub_category->use_in_ca = $request->use_in_ca ? true : false ;
        $sub_category->use_all_segments = $request->use_all_segments ? true : false ;
        $sub_category->update_only_budget_year = $request->update_only_budget_year ? true : false ;
        $sub_category->wht_flag = $request->wht_flag ? true : false ;
        if($sub_category->wht_flag){
            $sub_category->org_options = $request->org_options;
        }else {
            $sub_category->org_options = [];
        }
        $sub_category->last_updated_by = $user->user_id;
        $sub_category->save();

        // $request->accessible_orgs = ['81'];

        // $oldAccessibleOrgs = $sub_category->accessibleOrgs()->pluck('org_id')->all();
        // if($request->accessible_orgs != $oldAccessibleOrgs){
        //     // DELETE OLD ACCESIBLE ORG
        //     foreach($sub_category->accessibleOrgs as $accessibleOrg){
        //         $accessibleOrg->delete();
        //     }
        //     // SAVE NEW ACCESIBLE ORG
        //     foreach($request->accessible_orgs as $accessible_org_id){
        //         $accessibleOrg = new AccessibleOrg();
        //         $accessibleOrg->org_id = $accessible_org_id;
        //         $accessibleOrg->last_updated_by = $user->user_id;
        //         $accessibleOrg->created_by = $user->user_id;
        //         $sub_category->accessibleOrgs()->save($accessibleOrg);
        //     }
        // }

        return redirect()->route('ie.settings.sub-categories.index',[$category->category_id]);
    }

    public function formSetAccount(Request $request, $categoryId)
    {
        $category = Category::find($categoryId);
        $defaultCombinationCode = $request->combination_code;

        $segments = explode('.', $defaultCombinationCode);
        if( count($segments) != 12 ){
            return 'Error!';
        }
        
        $year = getBudgetYear();

        $defaultCompanyCode = $segments[0];
        $defaultEVMCode = $segments[1];
        $departmentCode = $defaultDepartmentCode = $segments[2];
        $defaultCostCenterCode = $segments[3];
        $defaultBudgetYearCode = $segments[4];
        $budgetTypeCode = $defaultBudgetTypeCode = $segments[5];
        $defaultBudgetDetailCode = $segments[6];
        $defaultBudgetReasonCode = $segments[7];
        $accountCode = $defaultAccountCode = $segments[8];
        $defaultSubAccountCode = $segments[9];
        $defaultReserve1Code = $segments[10];
        $defaultReserve2Code = $segments[11];

        $costCenterInfo = FNDListOfValues::costCenter()->first();
        $budgetDetailInfo = FNDListOfValues::budgetDetail()->first();
        $subAccountInfo = FNDListOfValues::subAccount()->first();

        $companyLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')
            ->company($this->orgId)
            ->orderBy('flex_value')
            ->pluck('full_description','flex_value')
            ->all();

        $evmLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')
            ->EVM($this->orgId)
            ->orderBy('flex_value')
            ->pluck('full_description','flex_value')
            ->all();

        $departmentLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')
            ->department($this->orgId)
            ->enabled()
            ->orderBy('flex_value')
            ->pluck('full_description','flex_value')
            ->all();

        $costCenterLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')
            ->costCenter($this->orgId)
            ->byParentValue($costCenterInfo->parent_flex_value_set_name,$departmentCode)
            ->orderBy('flex_value')
            ->pluck('full_description','flex_value')
            ->all();

        $budgetYearLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')
            ->budgetYear($this->orgId)
            ->orderBy('flex_value')
            ->pluck('full_description','flex_value')
            ->all();

        $budgetTypeLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')
            ->budgetType($this->orgId)
            ->orderBy('flex_value')
            ->pluck('full_description','flex_value')
            ->all();

        $budgetDetailLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')
            ->budgetDetail($this->orgId)
            ->byParentValue($budgetDetailInfo->parent_flex_value_set_name,$budgetTypeCode)
            ->orderBy('flex_value')
            ->pluck('full_description','flex_value')
            ->all();

        $budgetReasonLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')
            ->budgetReason($this->orgId)
            ->orderBy('flex_value')
            ->pluck('full_description','flex_value')
            ->all();

        $accountLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')
            ->account($this->orgId)
            ->orderBy('flex_value')
            ->pluck('full_description','flex_value')
            ->all();

        $subAccountLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')
            ->subAccount($this->orgId)
            ->byParentValue($subAccountInfo->parent_flex_value_set_name,$accountCode)
            ->orderBy('flex_value')
            ->pluck('full_description','flex_value')
            ->all();

        $reserve1Lists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')
            ->reserve1($this->orgId)
            ->orderBy('flex_value')
            ->pluck('full_description','flex_value')
            ->all();

        $reserve2Lists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')
            ->reserve2($this->orgId)
            ->orderBy('flex_value')
            ->pluck('full_description','flex_value')
            ->all();


        return view('ie.settings.sub-categories._form_set_account', 
            compact(
                'category',
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
            ));
    }

    public function inputCostCenterCode(Request $request)
    {
        $costCenterInfo = FNDListOfValues::costCenter()->first();

        $departmentCode = $request->department_code;
        $costCenterCode = $request->cost_center_code;
        $costCenterLists = [''=>'-'];
        if($departmentCode){
            $costCenterLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')
                ->costCenter()->byParentValue($costCenterInfo->parent_flex_value_set_name,$departmentCode)
                ->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        }
        return view('ie.settings.sub-categories._ddl_cost_center_code',
            compact('costCenterLists','costCenterCode'));
    }

    public function inputBudgetDetailCode(Request $request)
    {
        $budgetDetailInfo = FNDListOfValues::budgetDetail()->first();

        $budgetTypeCode = $request->budget_type_code;
        $budgetDetailCode = $request->budget_detail_code;
        $budgetDetailLists = [''=>'-'];
        if($budgetTypeCode){
            $budgetDetailLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')
                ->budgetDetail()->byParentValue($budgetDetailInfo->parent_flex_value_set_name,$budgetTypeCode)
                ->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        }
        return view('ie.settings.sub-categories._ddl_budget_detail_code',
            compact('budgetDetailLists','budgetDetailCode'));
    }

    public function inputSubAccountCode(Request $request)
    {
        $subAccountInfo = FNDListOfValues::subAccount()->first();

        $accountCode = $request->account_code;
        $subAccountCode = $request->sub_account_code;
        $subAccountLists = [''=>'-'];
        if($accountCode){
            $subAccountLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')
                ->subAccount()->byParentValue($subAccountInfo->parent_flex_value_set_name,$accountCode)
                ->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        }
        return view('ie.settings.sub-categories._ddl_sub_account_code',
            compact('subAccountLists','subAccountCode'));
    }

    public function validateCombination(Request $request)
    {
        $valid = [
            'status' => 'P',
            'title' => '',
        ];

        $combinationCode = $request->combination_code;

        $segments = explode('.', $combinationCode);
        
        if( count($segments) != 12 ){
            $valid['status'] = 'E';
            $valid['title'] = 'Error';
            $valid['error_lists'][] = 'กรุณาระบุข้อมูลรหัสบัญชีให้ถูกต้อง';
        }else {

            $costCenterInfo = FNDListOfValues::costCenter()->first();
            $budgetDetailInfo = FNDListOfValues::budgetDetail()->first();
            $accountInfo = FNDListOfValues::subAccount()->first();

            $checkCompany = FNDListOfValues::company()->where('flex_value', $segments[0])->first();
            $checkEVM = FNDListOfValues::EVM()->where('flex_value', $segments[1])->first();
            $checkDepartment = FNDListOfValues::department()->where('flex_value', $segments[2])->first();
            $checkCostCenter = FNDListOfValues::costCenter()->byParentValue($costCenterInfo->parent_flex_value_set_name, $segments[2])
                ->where('flex_value', $segments[3])->first();
            $checkBudgetYear = FNDListOfValues::budgetYear()->where('flex_value', $segments[4])->first();
            $checkBudgetType = FNDListOfValues::budgetType()->where('flex_value', $segments[5])->first();
            $checkBudgetDetail = FNDListOfValues::budgetDetail()->byParentValue($budgetDetailInfo->parent_flex_value_set_name, $segments[5])
                ->where('flex_value', $segments[6])->first();
            $checkBudgetReason = FNDListOfValues::budgetReason()->where('flex_value', $segments[7])->first();
            $checkAccount = FNDListOfValues::account()->where('flex_value', $segments[8])->first();
            $checkSubAccount = FNDListOfValues::subAccount()->byParentValue($accountInfo->parent_flex_value_set_name, $segments[8])
                ->where('flex_value', $segments[9])->first();
            $checkReserve1 = FNDListOfValues::reserve1()->where('flex_value', $segments[10])->first();
            $checkReserve2 = FNDListOfValues::reserve2()->where('flex_value', $segments[11])->first();
            
            if( !$checkCompany ){
                $valid['status'] = 'E';
                $valid['title'] = 'Error';
                $valid['error_lists'][] = 'ไม่มี Company Code นี้';
            }
            if( !$checkEVM ){
                $valid['status'] = 'E';
                $valid['title'] = 'Error';
                $valid['error_lists'][] = 'ไม่มี Evm Code นี้';
            }
            if( !$checkDepartment ){
                $valid['status'] = 'E';
                $valid['title'] = 'Error';
                $valid['error_lists'][] = 'ไม่มี Department Code นี้';
            }
            if( !$checkCostCenter ){
                $valid['status'] = 'E';
                $valid['title'] = 'Error';
                $valid['error_lists'][] = 'ไม่มี Cost Center Code นี้';
            }
            if( !$checkBudgetYear ){
                $valid['status'] = 'E';
                $valid['title'] = 'Error';
                $valid['error_lists'][] = 'ไม่มี Budget Year Code นี้';
            }
            if( !$checkBudgetType ){
                $valid['status'] = 'E';
                $valid['title'] = 'Error';
                $valid['error_lists'][] = 'ไม่มี Budget Type Code นี้';
            }
            if( !$checkBudgetDetail ){
                $valid['status'] = 'E';
                $valid['title'] = 'Error';
                $valid['error_lists'][] = 'ไม่มี Company Code นี้';
            }
            if( !$checkBudgetReason ){
                $valid['status'] = 'E';
                $valid['title'] = 'Error';
                $valid['error_lists'][] = 'ไม่มี Budget Reason Code นี้';
            }
            if( !$checkAccount ){
                $valid['status'] = 'E';
                $valid['title'] = 'Error';
                $valid['error_lists'][] = 'ไม่มี Account Code นี้';
            }
            if( !$checkSubAccount ){
                $valid['status'] = 'E';
                $valid['title'] = 'Error';
                $valid['error_lists'][] = 'ไม่มี Sub Account Code นี้';
            }
            if( !$checkReserve1 ){
                $valid['status'] = 'E';
                $valid['title'] = 'Error';
                $valid['error_lists'][] = 'ไม่มี Reserve1 Code นี้';
            }
            if( !$checkReserve2 ){
                $valid['status'] = 'E';
                $valid['title'] = 'Error';
                $valid['error_lists'][] = 'ไม่มี Reserve2 Code นี้';
            }

        }

        if($request->ajax()){
            return \Response::json($valid, 200);
        }else{
            return $valid;
        }
    }

}
