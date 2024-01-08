<?php

namespace App\Http\Controllers\IE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\IE\Receipt;
use App\Models\IE\ReceiptLine;
use App\Models\IE\ReceiptLineInfo;
use App\Models\IE\CashAdvance;
use App\Models\IE\Reimbursement;
use App\Models\IE\Category;
use App\Models\IE\SubCategory;
use App\Models\IE\SubCategoryInfo;
use App\Models\IE\CACategory;
use App\Models\IE\CASubCategory;
use App\Models\IE\CASubCategoryInfo;
use App\Models\IE\Policy;
use App\Models\IE\PolicyRate;
use App\Models\IE\MileageUnit;
use App\Models\IE\Currency;
use App\Models\IE\VAT;
use App\Models\IE\WHT;
use App\Models\IE\Preference;
use App\Models\IE\FNDListOfValues;
use App\Models\IE\APReportingEntity;
use App\Models\IE\AccountInfo;
use App\Models\IE\APWTTypeV;
use App\Models\IE\WHTRevenueNameV;
use App\Models\IE\APImpItemGroupV;
use App\Models\IE\PONumberV;
use App\Models\IE\INVTobaccoV;
use App\Models\IE\APINVImpExpenseV;
use App\Repositories\IE\RequestRepo;

use Carbon\Carbon;
use App\Repositories\IE\InterfaceRepo;

class ReceiptLineController extends Controller
{
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

    public function formCreate(Request $request, $receiptId)
    {
        // GET RECEIPT DATA
        $receipt = Receipt::find($receiptId);
        $receiptParentId = $receipt->receiptable_id;
        $receiptType = $receipt->receipt_type;
        $parent = $receipt->parent;
        $exchangeRate = $parent->exchange_rate;
        $parentCurrencyId = $parent->currency_id;

        $categoryLists = Category::active()
            ->when($receiptType, function ($query, $receiptType) {
                if( in_array($receiptType, ['CASH-ADVANCE','CLEARING']) ){
                    return $query->whereHas('subCategories', function($q){
                        $q->where('use_in_ca', true);
                    });
                }elseif ($receiptType == 'REIMBURSEMENT') {
                    return $query->whereHas('subCategories', function($q){
                        $q->where('use_in_reim', true);
                    });
                }
                return $query;
            })
            ->orderBy('name')
            ->pluck('name','category_id')
            ->all();
        $subCategoryLists = [];

        return view('ie.commons.receipts.lines._form_create',
            compact(
                'receipt',
                'receiptType',
                'receiptParentId',
                'parent',
                'categoryLists',
                'subCategoryLists',
                'parentCurrencyId',
                'exchangeRate'
            ));
    }

    public function getSubCategories(Request $request, $receiptId)
    {
        $receipt = Receipt::find($receiptId);
        $receiptParentId = $receipt->receiptable_id;
        $receiptType = $receipt->receipt_type;
        $categoryId = $request->category_id;
        $parent = $receipt->parent;
        $orgId = $parent->org_id;
        
        $subCategoryLists = [];

        if($categoryId){
            $query = SubCategory::where('category_id',$categoryId)
                ->active()
                ->when($receiptType, function ($query, $receiptType) {
                    if( in_array($receiptType, ['CASH-ADVANCE', 'CLEARING'])){
                        return $query->where('use_in_ca', true);
                    }elseif ($receiptType == 'REIMBURSEMENT') {
                        return $query->where('use_in_reim', true);
                    }
                    return $query;
                })
                ->onDateActive()
                ->get();

            foreach ($query as $key => $item) {
                if($item->wht_flag){
                    $selectedOrg = $item->org_options ?? [];
                    if(in_array($orgId, $selectedOrg)){
                        $subCategoryLists[$item->sub_category_id] = $item->name;
                    }
                }else {
                    $subCategoryLists[$item->sub_category_id] = $item->name;
                }
            }
        }

        return view('ie.commons.receipts.lines._ddl_sub_categories',compact('subCategoryLists'));
    }

    public function getInputFormInformations(Request $request, $receiptId, $subCategoryId)
    {
        $formId = "#form-create-receipt-line";
        $receiptLine = new ReceiptLine;
        // GET RECEIPT DATA
        $receipt = Receipt::find($receiptId);
        $receiptParentId = $receipt->receiptable_id;
        $receiptType = $receipt->receipt_type;
        $parent = $receipt->parent;
        $orgId = $parent->org_id;

        $subCategory = SubCategory::find($subCategoryId);

        // BRANCH & DEPARTMENT
        $defaultDescription = null;
        $defaultDistributionType = null;

        $APWTTypeLists = APWTTypeV::select('description','value')->pluck('description','value')->all();
        $WHTRevenueNameLists = WHTRevenueNameV::select('description','value')->pluck('description','value')->all();
        $APImpItemGroupLists = APImpItemGroupV::select('description','value')->pluck('description','value')->all();
        $PONumberLists = PONumberV::select('po_number','po_number')->pluck('po_number','po_number')->all();
        $INVTobaccoLists = INVTobaccoV::select(\DB::raw("item_code || ' : ' || item_description AS full_description"),'item_code')
                    ->pluck('full_description','item_code')->take(100)->all();
        $APINVImpExpenseLists = APINVImpExpenseV::select('description','value')->pluck('description','value')->all();

        $distributionTypeLists = [
            'ภาษีเงินได้หัก ณ ที่จ่าย' => 'ภาษีเงินได้หัก ณ ที่จ่าย',
            'สินค้าต่างประเทศ' => 'สินค้าต่างประเทศ',
            'ใบเสร็จรับเงิน' => 'ใบเสร็จรับเงิน'
        ];

        $informations = SubCategoryInfo::where('sub_category_id',$subCategoryId)
            ->active()
            ->get();

        return view('ie.commons.receipts.lines._form_informations',
            compact(
                'receipt',
                'receiptLine',
                'receiptType',
                'defaultDescription',
                'informations',
                'defaultDistributionType',
                'distributionTypeLists',
                'APWTTypeLists',
                'WHTRevenueNameLists',
                'APImpItemGroupLists',
                'PONumberLists',
                'INVTobaccoLists',
                'APINVImpExpenseLists',
                'formId'
            ));
    }

    public function getInputFormAmount(Request $request, $receiptId, $subCategoryId)
    {
        if(!$request->form_id){
            $formId = "#form-create-receipt-line";
        }else{
            $formId = $request->form_id;
        }
        // GET RECEIPT DATA
        $receipt = Receipt::find($receiptId);
        $receiptParentId = $receipt->receiptable_id;
        $receiptType = $receipt->receipt_type;
        $parent = $receipt->parent;
        $orgId = $parent->org_id;
        $exchangeRate = $parent->exchange_rate;
        $parentCurrencyId = $parent->currency_id;

        // GET LIST DATA (CHANGE WHEN CONNECT ORACLE)
        $baseMileageUnit = null;//Preference::getBaseMileageUnit($orgId);
        $mileageUnitLists = [];//MileageUnit::active()->pluck('description','mileage_unit_id')->all();
        $baseCurrencyId = Preference::getBaseCurrency();
        $VATs = VAT::apVat()->where('org_id', $orgId)->orderBy('tax')->get();
        $WHTs = WHT::where('org_id', $orgId)->orderBy('wht_name')->get();
        $VATLists = VAT::apVat()->where('org_id', $orgId)->orderBy('tax')->pluck('tax','tax_rate_code')->all();
        $WHTLists = WHT::active()->where('org_id', $orgId)->orderBy('wht_name')->pluck('wht_name','pay_awt_group_id')->all();

        $subCategory = SubCategory::find($subCategoryId);
        // if($receiptType == 'CLEARING'){
        //     $subCategory = CASubCategory::find($subCategoryId);
        // }elseif($receiptType == 'REIMBURSEMENT'){
        //     $subCategory = SubCategory::find($subCategoryId);
        // }
        //GET POLICY BY SUBCATEGORY
        $rateMileage = null;
        $rateExpense = null;
        $policyExpense = Policy::where('sub_category_id',$subCategoryId)
                                ->where('type','EXPENSE')
                                ->active()->first();
        if($policyExpense){
            $rateExpense = PolicyRate::getRateByCondition(
                $policyExpense->policy_id,
                // $parent->user->employee->position_po_level,
                null,
                $receipt->location_id
            );
        }
        $policyMileage = Policy::where('sub_category_id',$subCategoryId)
            ->where('type','MILEAGE')
            ->active()->first();
        if($policyMileage){
            $rateMileage = PolicyRate::getRateByCondition(
                $policyMileage->policy_id,
                // $parent->user->employee->position_po_level,
                null,
                $receipt->location_id
            );
        }

        // DEFAULT QUANTITY
        $defaultQuantity = 1;
        $defaultSecondQuantity = 1;

        // DEFAULT AMOUNT
        $defaultAmount = number_format(0,2);
        $defaultAmountIncVat = number_format(0,2);
        $defaultVatId = null;
        $defaultWhtId = null;
        $calVat = false;
        $showInputVat = false;
        if($receipt->currency_id == $parentCurrencyId){
            if($subCategory->vat_id){
                $showInputVat = true;
                $defaultVatId = $subCategory->vat_id;
            }
            if($subCategory->wht_id){
                $showInputVat = true;
                $defaultWhtId = $subCategory->wht_id;
            }
        }

        // DEFAULT DISTANCE
        $defaultMileageDistance = 0;

        return view('ie.commons.receipts.lines._form_amount',
            compact(
                'receipt',
                'receiptType',
                'parent',
                'baseMileageUnit',
                'mileageUnitLists',
                'baseCurrencyId',
                'parentCurrencyId',
                'exchangeRate',
                'VATLists',
                'WHTLists',
                'VATs',
                'WHTs',
                'subCategory',
                'policyExpense',
                'rateExpense',
                'policyMileage',
                'rateMileage',
                'defaultQuantity',
                'defaultSecondQuantity',
                'defaultAmount',
                'defaultAmountIncVat',
                'defaultMileageDistance',
                'defaultVatId',
                'defaultWhtId',
                'formId',
                'calVat',
                'showInputVat'
            ));
    }

    public function store(Request $request, $receiptId)
    {
        \DB::beginTransaction();
        try {
            $receipt = Receipt::find($receiptId);
            $receiptType = $receipt->receipt_type;
            $parent = $receipt->parent;
            $orgId = $parent->org_id;
            if(!$parent->isPendingReceipt()){
                throw new \Exception("Request enable to add receipt line now.", 1);
            }

            // PREPARE RECEIPT LINE DATA
            $receiptLine = new ReceiptLine();
            $receiptLine->receipt_id = $receiptId;
            $receiptLine->branch_code = $request->branch_code ?? -1;
            $receiptLine->department_code = $request->department_code ?? -1;
            if($request->category_id){
                $receiptLine->category_id = $request->category_id;
            }else{
                // if($receiptType == 'CLEARING'){
                //     $subCategory = CASubCategory::find($request->sub_category_id);
                //     $receiptLine->category_id = $subCategory->category->ca_category_id;
                // }elseif($receiptType == 'REIMBURSEMENT'){
                //     $subCategory = SubCategory::find($request->sub_category_id);
                //     $receiptLine->category_id = $subCategory->category->category_id;
                // }
                $subCategory = SubCategory::find($request->sub_category_id);
                $receiptLine->category_id = $subCategory->category->category_id;
            }
            $receiptLine->sub_category_id = $request->sub_category_id;
            $receiptLine->description = $request->description;
            // QUANTITY & AMOUNT
            $receiptLine->quantity = $request->quantity;
            $receiptLine->uom = $request->uom;
            $receiptLine->second_quantity = $request->second_quantity;
            $receiptLine->second_uom = $request->second_uom;
            $receiptLine->transaction_quantity = (int)$request->quantity * (int)$request->second_quantity;
            $receiptLine->amount = $request->amount;
            $receiptLine->amount_inc_vat = $request->amount_inc_vat;
            $receiptLine->total_amount = $receiptLine->amount;
            $receiptLine->total_amount_inc_vat = $receiptLine->amount_inc_vat;

            $receiptLine->wht_flag = $request->wht_flag ? true : false;
            $receiptLine->wht_cert = $receiptLine->wht_flag ? $request->wht_cert : null;

            $exchangeRate = $receipt->exchange_rate;
            ////////////////////////////////////
            // CASE USE POLICY (EXPENSE, MILEAGE)
            if($request->policy_id){
                $receiptLine->policy_id = $request->policy_id;
                $receiptLine->rate_id = $request->rate_id;
                $linePolicy = Policy::find($receiptLine->policy_id);
                // EXPENSE
                if($linePolicy->type == 'EXPENSE'){
                    $receiptLine->primary_amount = $request->primary_amount;
                    $receiptLine->primary_amount_inc_vat = $request->primary_amount_inc_vat;
                }
                // MILEAGE
                if($linePolicy->type == 'MILEAGE'){
                    // MILEAGE DETAIL
                    $receiptLine->mileage_unit_id = -1;//Preference::getBaseMileageUnit($parent->org_id);
                    $receiptLine->mileage_distance = $request->mileage_distance;
                    $receiptLine->mileage_start = $request->mileage_start ? $request->mileage_start : null;
                    $receiptLine->mileage_end = $request->mileage_end ? $request->mileage_end : null;
                    // MILEAGE ALWAYS USE BASE CURRENCY (NOT CAL WITH EXCHANGE RATE)
                    $receiptLine->primary_amount = $receiptLine->amount;
                    $receiptLine->primary_amount_inc_vat = $receiptLine->amount_inc_vat;
                }
            }else{
            /////////////////////////////////
            // CASE NOT USE POLICY (ACTUAL)
                $receiptLine->primary_amount = $request->primary_amount;
                $receiptLine->primary_amount_inc_vat = $request->primary_amount_inc_vat;
            }
            // PRIMARY => CALCULATE (WITH EXCHANGE RATE) TO BASE CURRENCY
            $receiptLine->total_primary_amount = $receiptLine->primary_amount;
            $receiptLine->total_primary_amount_inc_vat = $receiptLine->primary_amount_inc_vat;

            // WHT & VAT
            if($request->wht_id){
                $receiptLine->wht_id = $request->wht_id;
                $receiptLine->wht_amount = (float)$request->wht_amount;
                $receiptLine->primary_wht_amount = (float)$request->primary_wht_amount;
            }
            if($request->vat_id){
                $receiptLine->vat_id = $request->vat_id;
                // $receiptLine->vat_amount = $request->primary_vat_amount / $exchangeRate;
                $receiptLine->vat_amount = (float)$receiptLine->amount_inc_vat - (float)$receiptLine->amount;
                $receiptLine->primary_vat_amount = $request->primary_vat_amount;
            }

            $emp = $receipt->employee;
            $emp->org_id = $orgId;

            $lineSubCategory = SubCategory::find($receiptLine->sub_category_id);
            $useAllCOAFlag = $lineSubCategory->use_all_segments;
            $budgetYear = getBudgetYear($parent->gl_date ?? $parent->request_date);

            if($useAllCOAFlag){
                $lineSegments = InterfaceRepo::composeGLCodeCombinationSegmentsBySubCategory($lineSubCategory);
            }else {
                $lineSegments = InterfaceRepo::composeGLCodeCombinationSegments(
                    null, // company
                    null, // evm
                    null, // department
                    null, // cost center
                    $budgetYear, // budget year
                    $lineSubCategory->budget_type_code, // budget type
                    $lineSubCategory->budget_detail_code, // budget detail
                    $lineSubCategory->budget_reason_code, // budget reason
                    null, // account
                    $lineSubCategory->sub_account_code, // sub account 
                    $lineSubCategory->reserve1_code, // reserve1
                    $lineSubCategory->reserve2_code  // reserve2
                );
            }
            $glCodeCombination = InterfaceRepo::getGLCodeCombinationOfEmpBySegments($emp,$lineSegments,$parent->gl_date);

            $receiptLine->code_combination_id = $glCodeCombination['code_combination_id'];
            $receiptLine->concatenated_segments = $glCodeCombination['concatenated_segments'];
            // $receiptLine->code_combination_id = null;
            // $receiptLine->concatenated_segments = null;

            $receiptLine->last_updated_by = \Auth::user()->user_id;
            $receiptLine->created_by = \Auth::user()->user_id;

            ///// DFF //////
            if(in_array($receiptType, ['CLEARING', 'REIMBURSEMENT'])){
                $groupTaxCode = APReportingEntity::select(\DB::raw("entity_name AS full_description"),'entity_name')
                    ->whereOrgId($orgId)
                    ->orderBy('entity_name')
                    ->first();

                $receiptLine->dff_type = 'tax_invoice';
                $receiptLine->dff_pay_for = $receipt->vendor_name ?? ($receipt->vendor_id != 'other' ? optional($receipt->vendor)->vendor_name : null);
                $receiptLine->dff_group_tax_code = $groupTaxCode ? $groupTaxCode->entity_name : null;

                $receiptLine->dff_tax_invoice_number = $receipt->receipt_number;
                $receiptLine->dff_tax_invoice_date = $receipt->receipt_date;
                $receiptLine->dff_product_value = $receiptLine->total_amount;

                $receiptLine->dff_address = $receipt->vendor_tax_address ?? ($receipt->vendor_id != 'other' ? optional($receipt->vendor)->getTaxAddress() : null);
                $receiptLine->dff_branch_number = $receipt->vendor_branch_name ?? ($receipt->vendor_id != 'other' ? optional($receipt->vendor)->getBranchNumber() : null);
                $receiptLine->dff_tax_id = $receipt->vendor_tax_id ?? ($receipt->vendor_id != 'other' ? optional($receipt->vendor)->getTaxID() : null);
            }

            ///// DFF DISTRIBUTION //////
            if(!!$request->distribution_type){
                $receiptLine->distribution_type = $request->distribution_type;

                if($request->distribution_type == 'ภาษีเงินได้หัก ณ ที่จ่าย'){
                    $receiptLine->distribution_wht_date = $request->distribution_wht_date ? \DateTime::createFromFormat(trans('date.format'), $request->distribution_wht_date)->format('Y-m-d') : null;
                    $receiptLine->distribution_cert_number = $request->distribution_cert_number;
                    $receiptLine->distribution_income_type = $request->distribution_income_type;
                    $receiptLine->distribution_income_name = $request->distribution_income_name;
                }

                if($request->distribution_type == 'สินค้าต่างประเทศ'){
                    $receiptLine->distribution_import_type = $request->distribution_import_type;
                    $receiptLine->distribution_po_number = $request->distribution_po_number;
                    $receiptLine->distribution_ref_number = $request->distribution_ref_number;
                    $receiptLine->distribution_expense_type = $request->distribution_expense_type;
                    $receiptLine->distribution_shipment = $request->distribution_shipment;
                }

                if($request->distribution_type == 'ใบเสร็จรับเงิน'){
                    $receiptLine->distribution_receipt_number = $request->distribution_receipt_number;
                    $receiptLine->distribution_receipt_date = $request->distribution_receipt_date ? \DateTime::createFromFormat(trans('date.format'), $request->distribution_receipt_date)->format('Y-m-d') : null;
                }
            }

            $receiptLine->save();

            // INSERT RECEIPT LINE INFORMATIONS
            $infos = SubCategoryInfo::where('sub_category_id',$receiptLine->sub_category_id)
                        ->active()
                        ->get();
            // if($receiptType == 'CLEARING'){
            //     $infos = CASubCategoryInfo::where('ca_sub_category_id',$receiptLine->sub_category_id)
            //             ->active()
            //             ->get();
            // }elseif($receiptType == 'REIMBURSEMENT'){
            //     $infos = SubCategoryInfo::where('sub_category_id',$receiptLine->sub_category_id)
            //             ->active()
            //             ->get();
            // }            
            if(count($infos)>0){
                foreach($infos as $info){
                    if($request->sub_category_infos[$info->sub_category_info_id]){
                        $receiptLineInfo = new ReceiptLineInfo();
                        $receiptLineInfo->receipt_id = $receiptId;
                        $receiptLineInfo->receipt_line_id = $receiptLine->receipt_line_id;
                        $receiptLineInfo->sub_category_id = $receiptLine->sub_category_id;
                        $receiptLineInfo->sub_category_info_id = $info->sub_category_info_id;
                        if($info->form_type == 'date'){
                            $receiptLineInfo->description = \DateTime::createFromFormat(trans('date.format'), $request->sub_category_infos[$info->sub_category_info_id])->format('Y-m-d');
                        }else{
                            $receiptLineInfo->description = $request->sub_category_infos[$info->sub_category_info_id];
                        }
                        $receiptLineInfo->last_updated_by = \Auth::user()->user_id;
                        $receiptLineInfo->created_by = \Auth::user()->user_id;
                        $receiptLineInfo->save();
                    }
                }
            }

            $resultOverBudget = RequestRepo::validateIsNotOverBudget($parent, $receipt->receipt_type);

            \DB::commit();

        } catch (\Exception $e) {
            // ERROR CREATE RECEIPT LINE
            \DB::rollBack();
            \Log::error($e->getMessage());
            if($request->ajax()){
                return \Response::json(["status"=>"error","err_msg"=>$e->getMessage()], 200);
            }else{
                return abort('403');
            }
        }

        if($request->ajax()){
            return \Response::json(["status"=>"success","err_msg"=>""], 200);
        }else{
            return redirect()->route('ie.commons.receipts.show',['receiptId'=>$receiptId]);
        }
    }

    public function formCOA(Request $request, $receiptId, $receiptLineId)
    {
        $receiptLine = ReceiptLine::find($receiptLineId);
        if(!$receiptLine){ abort(404); }

        // GET RECEIPT DATA
        $receipt = Receipt::find($receiptId);
        $receiptParentId = $receipt->receiptable_id;
        $receiptType = $receipt->receipt_type;
        $exchangeRate = $receipt->exchange_rate_for_cal;
        $parent = $receipt->parent;
        $orgId = $parent->org_id;
        $parentCurrencyId = $parent->currency_id;

        $accountInfo = FNDListOfValues::subAccount()->first();

        $year = getBudgetYear();

        $defaultCombinationCode = $receiptLine->concatenated_segments;
        $segment = explode('.', $defaultCombinationCode);

        if( isset($segment[0]) ){
            $companyCode = $segment[0];
        }else $companyCode = '01';

        if( isset($segment[1]) ){
            $evmCode = $segment[1];
        }else $evmCode = '0';

        if( isset($segment[2]) ){
            $departmentCode = $segment[2];
        }else $departmentCode = '00000000';

        if( isset($segment[3]) ){
            $costCenterCode = $segment[3];
        }else $costCenterCode = '00';

        if( isset($segment[4]) ){
            $budgetYearCode = $segment[4];
        }else $budgetYearCode = $year;

        if( isset($segment[5]) ){
            $budgetTypeCode = $segment[5];
        }else $budgetTypeCode = '000';

        if( isset($segment[6]) ){
            $budgetDetailCode = $segment[6];
        }else $budgetDetailCode = '000000';

        if( isset($segment[7]) ){
            $budgetReasonCode = $segment[7];
        }else $budgetReasonCode = '0';

        if( isset($segment[8]) ){
            $accountCode = $segment[8];
        }else $accountCode = '651000';

        if( isset($segment[9]) ){
            $subAccountCode = $segment[9];
        }else $subAccountCode = '651000';

        if( isset($segment[10]) ){
            $reserve1Code = $segment[10];
        }else $reserve1Code = '0';

        if( isset($segment[11]) ){
            $reserve2Code = $segment[11];
        }else $reserve2Code = '0';

        $companyLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->company()->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $evmLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->EVM()->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $departmentLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->department()->enabled()->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $costCenterLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->costCenter()->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $budgetYearLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->budgetYear()->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $budgetTypeLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->budgetType()->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $budgetDetailLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->budgetDetail()->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $budgetReasonLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->budgetReason()->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $accountLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->account()->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $subAccountLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->subAccount()->byParentValue($accountInfo->parent_flex_value_set_name,$accountCode)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $reserve1Lists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->reserve1()->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $reserve2Lists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->reserve2()->orderBy('flex_value')->pluck('full_description','flex_value')->all();

        return view('ie.commons.receipts.lines._form_coa',
            compact(
                'receipt',
                'receiptLine',
                'receiptType',
                'receiptParentId',
                'parent',
                'parentCurrencyId',
                'exchangeRate',
                'defaultCombinationCode',
                'companyCode',
                'evmCode',
                'departmentCode',
                'costCenterCode',
                'budgetYearCode',
                'budgetTypeCode',
                'budgetDetailCode',
                'budgetReasonCode',
                'accountCode',
                'subAccountCode',
                'reserve1Code',
                'reserve2Code',
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
                'reserve2Lists'
            ));
    }

    public function validateCombination(Request $request, $receiptId, $receiptLineId)
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
            
            $receipt = Receipt::find($receiptId);
            $emp = $receipt->employee;
            $parent = $receipt->parent;
            $orgId = $parent->org_id;
            $emp->org_id = $orgId;

            $lineSegments = InterfaceRepo::composeGLCodeCombinationSegments(
                $segments[0], // company
                $segments[1], // evm
                $segments[2], // department
                $segments[3], // cost center
                $segments[4], // budget year
                $segments[5], // budget type
                $segments[6], // budget detail
                $segments[7], // budget reason
                $segments[8], // account
                $segments[9], // sub account 
                $segments[10], // reserve1
                $segments[11]  // reserve2
            );

            $glCodeCombination = InterfaceRepo::getGLCodeCombinationOfEmpBySegments($emp,$lineSegments,$parent->gl_date);

            if( !$glCodeCombination['code_combination_id'] ) {
                $valid['status'] = 'E';
                $valid['title'] = 'Error';
                $valid['error_lists'][] = 'ไม่มี Combination Code นี้';
            }
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

    public function updateCOA(Request $request, $receiptId, $receiptLineId)
    {
        $validated = $request->validate([
            "company_code" => 'required',
            "evm_code" => 'required',
            "department_code" => 'required',
            "cost_center_code" => 'required',
            "budget_year_code" => 'required',
            "budget_type_code" => 'required',
            "budget_detail_code" => 'required',
            "budget_reason_code" => 'required',
            "account_code" => 'required',
            "sub_account_code" => 'required',
            "reserve1_code" => 'required',
            "reserve2_code" => 'required'
        ]);


        \DB::beginTransaction();
        try {

            $receiptLine = ReceiptLine::find($receiptLineId);
            if(!$receiptLine){ abort(404); }
            $receipt = $receiptLine->header;

            $lineSegments[1] = $request->company_code;
            $lineSegments[2] = $request->evm_code;
            $lineSegments[3] = $request->department_code;
            $lineSegments[4] = $request->cost_center_code;
            $lineSegments[5] = $request->budget_year_code;
            $lineSegments[6] = $request->budget_type_code;
            $lineSegments[7] = $request->budget_detail_code;
            $lineSegments[8] = $request->budget_reason_code;
            $lineSegments[9] = $request->account_code;
            $lineSegments[10] = $request->sub_account_code;
            $lineSegments[11] = $request->reserve1_code;
            $lineSegments[12] = $request->reserve2_code;

            $emp = $receipt->employee;
            $parent = $receipt->parent;
            $orgId = $parent->org_id;
            $emp->org_id = $orgId;
            $glCodeCombination = InterfaceRepo::getGLCodeCombinationOfEmpBySegments($emp,$lineSegments,$parent->gl_date);

            $receiptLine->code_combination_id = $glCodeCombination['code_combination_id'];
            $receiptLine->concatenated_segments = $glCodeCombination['concatenated_segments'];
            $receiptLine->save();

            \DB::commit();

        } catch (\Exception $e) {
            // ERROR CREATE RECEIPT LINE
            \DB::rollBack();
            \Log::error($e->getMessage());
            if($request->ajax()){
                return \Response::json(["status"=>"error","err_msg"=>$e->getMessage()], 200);
            }else{
                return back()->withErrors('Update Coa Error.');
            }
        }

        if($request->ajax()){
            return \Response::json(["status"=>"success","err_msg"=>""], 200);
        }else{
            return back()->with('success', 'Update Coa success.');
        }
    }

    public function formEdit(Request $request, $receiptId, $receiptLineId)
    {
        $receiptLine = ReceiptLine::find($receiptLineId);
        if(!$receiptLine){ abort(404); }

        // GET RECEIPT DATA
        $receipt = Receipt::find($receiptId);
        $receiptParentId = $receipt->receiptable_id;
        $receiptType = $receipt->receipt_type;
        $parent = $receipt->parent;
        $exchangeRate = $parent->exchange_rate;
        $parentCurrencyId = $parent->currency_id;

        // GET LIST DATA (CHANGE WHEN CONNECT ORACLE)
        $categoryLists = Category::active()
            ->when($receiptType, function ($query, $receiptType) {
                if( in_array($receiptType, ['CASH-ADVANCE','CLEARING']) ){
                    return $query->whereHas('subCategories', function($q){
                        $q->where('use_in_ca', true);
                    });
                }elseif ($receiptType == 'REIMBURSEMENT') {
                    return $query->whereHas('subCategories', function($q){
                        $q->where('use_in_reim', true);
                    });
                }
                return $query;
            })
            ->orderBy('name')
            ->pluck('name','category_id')
            ->all();

        $subCategoryLists = SubCategory::where('category_id',$receiptLine->category_id)
            ->when($receiptType, function ($query, $receiptType) {
                if( in_array($receiptType, ['CASH-ADVANCE', 'CLEARING'])){
                    return $query->where('use_in_ca', true);
                }elseif ($receiptType == 'REIMBURSEMENT') {
                    return $query->where('use_in_reim', true);
                }
                return $query;
            })
            ->active()
            ->onDateActive()
            ->orderBy('name')
            ->pluck('name','sub_category_id')
            ->all();


        return view('ie.commons.receipts.lines._form_edit',
            compact(
                'receipt',
                'receiptLine',
                'receiptType',
                'receiptParentId',
                'parent',
                'parentCurrencyId',
                'exchangeRate',
                'categoryLists',
                'subCategoryLists'
            ));
    }

    public function getInputFormEditInformations(Request $request, $receiptId, $receiptLineId)
    {
        $formId = "#form-edit-receipt-line";
        $receiptLine = ReceiptLine::find($receiptLineId);
        $receiptLine->distribution_wht_date = $receiptLine->distribution_wht_date ? dateFormatDisplay($receiptLine->distribution_wht_date) : null;
        $receiptLine->distribution_receipt_date = $receiptLine->distribution_receipt_date ? dateFormatDisplay($receiptLine->distribution_receipt_date) : null;
        $receipt = Receipt::find($receiptId);
        $parent = $receipt->parent;
        $orgId = $parent->org_id;
        $receiptParentId = $receipt->receiptable_id;
        $receiptType = $receipt->receipt_type;
        if(!$receiptLine){ abort(404); }

        // GET SUB-CATEGORY DATA
        $subCategory = SubCategory::find($receiptLine->subCategory->sub_category_id);

        // BRANCH & DEPARTMENT
        // $branchLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->EVM()->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $departmentLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->department()->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        // DEFAULT BRANCH & DEPARTMENT
        $defaultBranchCode = $receiptLine->branch_code;
        $defaultDepartmentCode = $receiptLine->department_code ?? -1;
        $defaultWhtFlag = $receiptLine->wht_flag;
        $defaultWhtCert = $receiptLine->wht_cert;
        $defaultDescription = $receiptLine->description;
        $defaultDistributionType = $receiptLine->distribution_type;

        $APWTTypeLists = APWTTypeV::select('description','value')->pluck('description','value')->all();
        $WHTRevenueNameLists = WHTRevenueNameV::select('description','value')->pluck('description','value')->all();
        $APImpItemGroupLists = APImpItemGroupV::select('description','value')->pluck('description','value')->all();
        $PONumberLists = PONumberV::select('po_number','po_number')->pluck('po_number','po_number')->all();
        $INVTobaccoLists = INVTobaccoV::select(\DB::raw("item_code || ' : ' || item_description AS full_description"),'item_code')
                    ->where('item_code', 'like', '%'.$receiptLine->distribution_ref_number.'%')
                    ->pluck('full_description','item_code')->take(100)->all();
        $APINVImpExpenseLists = APINVImpExpenseV::select('description','value')->pluck('description','value')->all();

        // SUB-CATEGORY INFORMATION
        $informations = SubCategoryInfo::where('sub_category_id',$subCategory->sub_category_id)
            ->active()
            ->get();
        $distributionTypeLists = ['ภาษีเงินได้หัก ณ ที่จ่าย' => 'ภาษีเงินได้หัก ณ ที่จ่าย',
                                    'สินค้าต่างประเทศ' => 'สินค้าต่างประเทศ',
                                    'ใบเสร็จรับเงิน' => 'ใบเสร็จรับเงิน'];
        $receiptInfos = ReceiptLineInfo::where('receipt_line_id',$receiptLineId)->get();
        $receiptInfoLists = ReceiptLineInfo::where('receipt_line_id',$receiptLineId)
                                    ->pluck('description','sub_category_info_id')
                                    ->all();

        return view('ie.commons.receipts.lines._form_informations',
            compact(
                'receipt',
                'receiptLine',
                'receiptType',
                'departmentLists',
                // 'branchLists',
                'defaultBranchCode',
                'defaultDepartmentCode',
                'defaultWhtFlag',
                'defaultWhtCert',
                'informations',
                'receiptInfos',
                'receiptInfoLists',
                'defaultDistributionType',
                'distributionTypeLists',
                'APWTTypeLists',
                'WHTRevenueNameLists',
                'APImpItemGroupLists',
                'PONumberLists',
                'INVTobaccoLists',
                'APINVImpExpenseLists',
                'defaultDescription',
                'formId'
            ));
    }

    public function getInputFormEditAmount(Request $request, $receiptId, $receiptLineId)
    {
        $formId = "#form-edit-receipt-line";

        $receiptLine = ReceiptLine::find($receiptLineId);
        if(!$receiptLine){ abort(404); }

        // GET RECEIPT DATA
        $receipt = Receipt::find($receiptId);
        $receiptParentId = $receipt->receiptable_id;
        $receiptType = $receipt->receipt_type;
        $parent = $receipt->parent;
        $orgId = $parent->org_id;
        $exchangeRate = $parent->exchange_rate;
        $parentCurrencyId = $parent->currency_id;

        // GET LIST DATA (CHANGE WHEN CONNECT ORACLE)
        $baseMileageUnit = -1;//Preference::getBaseMileageUnit($orgId);
        $mileageUnitLists = [];//MileageUnit::active()->pluck('description','mileage_unit_id')->all();
        $baseCurrencyId = Preference::getBaseCurrency();
        $VATs = VAT::apVat()->where('org_id', $orgId)->orderBy('tax')->get();
        $WHTs = WHT::where('org_id', $orgId)->orderBy('wht_name')->get();
        $VATLists = VAT::apVat()->where('org_id', $orgId)->orderBy('tax')->pluck('tax','tax_rate_code')->all();
        $WHTLists = WHT::active()->where('org_id', $orgId)->orderBy('wht_name')->pluck('wht_name','pay_awt_group_id')->all();

        $subCategory = SubCategory::find($receiptLine->sub_category_id);
        // if($receiptType == 'CLEARING'){
        //     $subCategory = CASubCategory::find($receiptLine->sub_category_id);
        // }elseif($receiptType == 'REIMBURSEMENT'){
        //     $subCategory = SubCategory::find($receiptLine->sub_category_id);
        // }
        $rateExpense = null;
        $rateMileage = null;
        //GET POLICY BY SUBCATEGORY
        if($receiptLine->policy_id){
            $policyExpense = Policy::where('policy_id',$receiptLine->policy_id)
                                ->where('type','EXPENSE')
                                ->active()->first();
            if($policyExpense){
                $rateExpense = PolicyRate::find($receiptLine->rate_id);
            }
            $policyMileage = Policy::where('policy_id',$receiptLine->policy_id)
                                    ->where('type','MILEAGE')
                                    ->active()->first();
            if($policyMileage){
                $rateMileage = PolicyRate::find($receiptLine->rate_id);
            }
        }else{
            $policyExpense = null;
            $policyMileage = null;
        }

        // DEFAULT QUANTITY
        $defaultQuantity = 1;
        if($receiptLine->quantity){
            $defaultQuantity = $receiptLine->quantity;
        }
        $defaultSecondQuantity = 1;
        if($receiptLine->second_quantity){
            $defaultSecondQuantity = $receiptLine->second_quantity;
        }

        // DEFAULT QUANTITY
        $defaultAmount = number_format(0,2);
        if($receiptLine->amount){
            $defaultAmount = $receiptLine->amount;
        }
        $defaultAmountIncVat = number_format(0,2);
        if($receiptLine->amount_inc_vat){
            $defaultAmountIncVat = $receiptLine->amount_inc_vat;
        }
        $defaultVatId = $receiptLine->vat_id;
        $defaultWhtId = $receiptLine->wht_id;
        $calVat = false;
        $showInputVat = false;
        if($receipt->currency_id == $parentCurrencyId){
            $showInputVat = true;
            // if($subCategory->vat_id){
            //     $showInputVat = true;
            //     $defaultVatId = $subCategory->vat_id;
            // }
            // if($subCategory->wht_id){
            //     $showInputVat = true;
            //     $defaultWhtId = $subCategory->wht_id;
            // }
            if($receiptLine->vat_id){
                $calVat = true;
            }
        }

        // DEFAULT DISTANCE
        $defaultMileageDistance = $receiptLine->mileage_distance;

        return view('ie.commons.receipts.lines._form_amount',
            compact(
                'receipt',
                'receiptLine',
                'receiptType',
                'parent',
                'baseMileageUnit',
                'mileageUnitLists',
                'baseCurrencyId',
                'parentCurrencyId',
                'exchangeRate',
                'VATLists',
                'WHTLists',
                'VATs',
                'WHTs',
                'subCategory',
                'policyExpense',
                'rateExpense',
                'policyMileage',
                'rateMileage',
                'defaultQuantity',
                'defaultSecondQuantity',
                'defaultAmount',
                'defaultAmountIncVat',
                'defaultMileageDistance',
                'defaultVatId',
                'defaultWhtId',
                'formId',
                'calVat',
                'showInputVat'
            ));
    }

    public function update(Request $request, $receiptId, $receiptLineId)
    {
        $receiptLine = ReceiptLine::find($receiptLineId);
        if(!$receiptLine){ abort(404); }

        \DB::beginTransaction();
        try {
            $receipt = Receipt::find($receiptId);
            $receiptType = $receipt->receipt_type;
            $parent = $receipt->parent;
            if(!$parent->isPendingReceipt()){
                throw new \Exception("Request enable to add receipt line now.", 1);
            }
            if($request->category_id){
                $receiptLine->category_id = $request->category_id;
            }else{
                // if($receiptType == 'CLEARING'){
                //     $subCategory = CASubCategory::find($request->sub_category_id);
                //     $receiptLine->category_id = $subCategory->category->ca_category_id;
                // }elseif($receiptType == 'REIMBURSEMENT'){
                //     $subCategory = SubCategory::find($request->sub_category_id);
                //     $receiptLine->category_id = $subCategory->category->category_id;
                // }
                $subCategory = SubCategory::find($request->sub_category_id);
                $receiptLine->category_id = $subCategory->category->category_id;
            }
            $receiptLine->sub_category_id = $request->sub_category_id;
            // EDIT RECEIPT LINE DATA
            $receiptLine->branch_code = $request->branch_code ?? -1;
            $receiptLine->department_code = $request->department_code ?? -1;
            $receiptLine->description = $request->description;
            // QUANTITY & AMOUNT
            $receiptLine->quantity = $request->quantity;
            $receiptLine->uom = $request->uom;
            $receiptLine->second_quantity = $request->second_quantity;
            $receiptLine->second_uom = $request->second_uom;
            $receiptLine->transaction_quantity = (int)$request->quantity * (int)$request->second_quantity;
            $receiptLine->amount = $request->amount;
            $receiptLine->amount_inc_vat = $request->amount_inc_vat;
            $receiptLine->total_amount = $receiptLine->amount;
            $receiptLine->total_amount_inc_vat = $receiptLine->amount_inc_vat;

            $receiptLine->wht_flag = $request->wht_flag ? true : false;
            $receiptLine->wht_cert = $receiptLine->wht_flag ? $request->wht_cert : null;

            $exchangeRate = $parent->exchange_rate;
            ////////////////////////////////////
            // CASE USE POLICY (EXPENSE, MILEAGE)
            if($request->policy_id){
                $receiptLine->policy_id = $request->policy_id;
                $receiptLine->rate_id = $request->rate_id;
                $linePolicy = Policy::find($receiptLine->policy_id);
                // EXPENSE
                if($linePolicy->type == 'EXPENSE'){
                    $receiptLine->primary_amount = $request->primary_amount;
                    $receiptLine->primary_amount_inc_vat = $request->primary_amount_inc_vat;
                }
                // MILEAGE
                if($linePolicy->type == 'MILEAGE'){
                    // MILEAGE DETAIL
                    $receiptLine->mileage_unit_id = -1;//Preference::getBaseMileageUnit($parent->org_id);
                    $receiptLine->mileage_distance = $request->mileage_distance;
                    $receiptLine->mileage_start = $request->mileage_start ? $request->mileage_start : null;
                    $receiptLine->mileage_end = $request->mileage_end ? $request->mileage_end : null;
                    // MILEAGE ALWAYS USE BASE CURRENCY (NOT CAL WITH EXCHANGE RATE)
                    $receiptLine->primary_amount = $receiptLine->amount;
                    $receiptLine->primary_amount_inc_vat = $receiptLine->amount_inc_vat;
                }
            }else{
            /////////////////////////////////
            // CASE NOT USE POLICY (ACTUAL)
                $receiptLine->primary_amount = $request->primary_amount;
                $receiptLine->primary_amount_inc_vat = $request->primary_amount_inc_vat;
            }
            // PRIMARY => CALCULATE (WITH EXCHANGE RATE) TO BASE CURRENCY
            $receiptLine->total_primary_amount = $receiptLine->primary_amount;
            $receiptLine->total_primary_amount_inc_vat = $receiptLine->primary_amount_inc_vat;

            // WHT & VAT
            if($request->wht_id){
                $receiptLine->wht_id = $request->wht_id;
                $receiptLine->wht_amount = (float)$request->wht_amount;
                $receiptLine->primary_wht_amount = (float)$request->primary_wht_amount;
            }else{
                $receiptLine->wht_id = null;
                $receiptLine->wht_amount = 0;
                $receiptLine->primary_wht_amount = 0;
            }
            if($request->vat_id){
                $receiptLine->vat_id = $request->vat_id;
                // $receiptLine->vat_amount = $request->primary_vat_amount / $exchangeRate;
                $receiptLine->vat_amount = (float)$receiptLine->amount_inc_vat - (float)$receiptLine->amount;
                $receiptLine->primary_vat_amount = $request->primary_vat_amount;
            }else{
                $receiptLine->vat_id = null;
                $receiptLine->vat_amount = 0;
                $receiptLine->primary_vat_amount = 0;
            }

            $emp = $receipt->employee;
            $orgId = $parent->org_id;
            $emp->org_id = $orgId;

            $lineSubCategory = SubCategory::find($receiptLine->sub_category_id);
            $useAllCOAFlag = $lineSubCategory->use_all_segments;
            $budgetYear = getBudgetYear($parent->gl_date ?? $parent->request_date);

            if($useAllCOAFlag){
                $lineSegments = InterfaceRepo::composeGLCodeCombinationSegmentsBySubCategory($lineSubCategory);
            }else {
                $lineSegments = InterfaceRepo::composeGLCodeCombinationSegments(
                    null, // company
                    null, // evm
                    null, // department
                    null, // cost center
                    $budgetYear, // budget year
                    $lineSubCategory->budget_type_code, // budget type
                    $lineSubCategory->budget_detail_code, // budget detail
                    $lineSubCategory->budget_reason_code, // budget reason
                    null, // account
                    $lineSubCategory->sub_account_code, // sub account 
                    $lineSubCategory->reserve1_code, // reserve1
                    $lineSubCategory->reserve2_code // reserve2
                );
            }

            $glCodeCombination = InterfaceRepo::getGLCodeCombinationOfEmpBySegments($emp,$lineSegments,$parent->gl_date);

            $receiptLine->code_combination_id = $glCodeCombination['code_combination_id'];
            $receiptLine->concatenated_segments = $glCodeCombination['concatenated_segments'];
            // $receiptLine->code_combination_id = null;
            // $receiptLine->concatenated_segments = null;
    
            $receiptLine->last_updated_by = \Auth::user()->user_id;

            if(in_array($receiptType, ['CLEARING', 'REIMBURSEMENT'])){
                $receiptLine->dff_product_value = $receiptLine->total_amount;
            }

            ///// DFF DISTRIBUTION //////
            $receiptLine->distribution_type = null;

            $receiptLine->distribution_wht_date = null;
            $receiptLine->distribution_cert_number = null;
            $receiptLine->distribution_income_type = null;
            $receiptLine->distribution_income_name = null;

            $receiptLine->distribution_import_type = null;
            $receiptLine->distribution_po_number = null;
            $receiptLine->distribution_ref_number = null;
            $receiptLine->distribution_expense_type = null;
            $receiptLine->distribution_shipment = null;

            $receiptLine->distribution_receipt_number = null;
            $receiptLine->distribution_receipt_date = null;

            if(!!$request->distribution_type){
                $receiptLine->distribution_type = $request->distribution_type;

                if($request->distribution_type == 'ภาษีเงินได้หัก ณ ที่จ่าย'){
                    $receiptLine->distribution_wht_date = $request->distribution_wht_date ? \DateTime::createFromFormat(trans('date.format'), $request->distribution_wht_date)->format('Y-m-d') : null;
                    $receiptLine->distribution_cert_number = $request->distribution_cert_number;
                    $receiptLine->distribution_income_type = $request->distribution_income_type;
                    $receiptLine->distribution_income_name = $request->distribution_income_name;
                }

                if($request->distribution_type == 'สินค้าต่างประเทศ'){
                    $receiptLine->distribution_import_type = $request->distribution_import_type;
                    $receiptLine->distribution_po_number = $request->distribution_po_number;
                    $receiptLine->distribution_ref_number = $request->distribution_ref_number;
                    $receiptLine->distribution_expense_type = $request->distribution_expense_type;
                    $receiptLine->distribution_shipment = $request->distribution_shipment;
                }

                if($request->distribution_type == 'ใบเสร็จรับเงิน'){
                    $receiptLine->distribution_receipt_number = $request->distribution_receipt_number;
                    $receiptLine->distribution_receipt_date = $request->distribution_receipt_date ? \DateTime::createFromFormat(trans('date.format'), $request->distribution_receipt_date)->format('Y-m-d') : null;
                }
            }

            $receiptLine->save();

            // REMOVE OLD RECEIPT LINE INFORMATIONS
            foreach ($receiptLine->infos as $key => $oldInfo) {
                $oldInfo->delete();
            }

            // INSERT RECEIPT LINE INFORMATIONS INSTEAD
            // if($receiptType == 'CLEARING'){
            //     $infos = CASubCategoryInfo::where('ca_sub_category_id',$receiptLine->sub_category_id)
            //         ->active()
            //         ->get();
            // }elseif($receiptType == 'REIMBURSEMENT'){
            //     $infos = SubCategoryInfo::where('sub_category_id',$receiptLine->sub_category_id)
            //         ->active()
            //         ->get();
            // }
            $infos = SubCategoryInfo::where('sub_category_id',$receiptLine->sub_category_id)
                    ->active()
                    ->get();

            if(count($infos)>0){
                foreach($infos as $info){
                    if($request->sub_category_infos[$info->sub_category_info_id]){
                        $receiptLineInfo = new ReceiptLineInfo();
                        $receiptLineInfo->receipt_id = $receiptId;
                        $receiptLineInfo->receipt_line_id = $receiptLine->receipt_line_id;
                        $receiptLineInfo->sub_category_id = $receiptLine->sub_category_id;
                        $receiptLineInfo->sub_category_info_id = $info->sub_category_info_id;
                        if($info->form_type == 'date'){
                            $receiptLineInfo->description = \DateTime::createFromFormat(trans('date.format'), $request->sub_category_infos[$info->sub_category_info_id])->format('Y-m-d');
                        }else{
                            $receiptLineInfo->description = $request->sub_category_infos[$info->sub_category_info_id];
                        }
                        $receiptLineInfo->last_updated_by = \Auth::user()->user_id;
                        $receiptLineInfo->created_by = \Auth::user()->user_id;
                        $receiptLineInfo->save();
                    }
                }
            }

            // // EDIT RECEIPT LINE INFORMATIONS
            // $infos = SubCategoryInfo::where('sub_category_id',$receiptLine->sub_category_id)
            //             ->active()
            //             ->get();
            // if(count($infos)>0){
            //     foreach($infos as $info){
            //         if($request->sub_category_infos[$info->sub_category_info_id]){
            //             $receiptLineInfo = ReceiptLineInfo::where('receipt_id',$receiptId)
            //                                 ->where('receipt_line_id',$receiptLineId)
            //                                 ->where('sub_category_id',$receiptLine->sub_category_id)
            //                                 ->where('sub_category_info_id',$info->sub_category_info_id)
            //                                 ->first();
            //             if($info->form_type == 'date'){
            //                 $receiptLineInfo->description = \DateTime::createFromFormat(trans('date.format'), $request->sub_category_infos[$info->sub_category_info_id])->format('Y-m-d');
            //             }else{
            //                 $receiptLineInfo->description = $request->sub_category_infos[$info->sub_category_info_id];
            //             }
            //             $receiptLineInfo->save();
            //         }
            //     }
            // }

            $resultOverBudget = RequestRepo::validateIsNotOverBudget($parent, $receiptType);

            \DB::commit();

        } catch (\Exception $e) {
            // ERROR CREATE RECEIPT LINE
            \DB::rollBack();
            \Log::error($e->getMessage());
            if($request->ajax()){
                return \Response::json(["status"=>"error","err_msg"=>$e->getMessage()], 200);
            }else{
                return abort('403');
            }
        }

        if($request->ajax()){
            return \Response::json(["status"=>"success","err_msg"=>""], 200);
        }else{
            return redirect()->route('ie.commons.receipts.show',['receiptId'=>$receiptId]);
        }

    }

    public function getShowInfos(Request $request, $receiptId, $receiptLineId)
    {
        $receiptLine = ReceiptLine::find($receiptLineId);
        if(!$receiptLine){ abort(404); }

        // GET RECEIPT DATA
        $receipt = Receipt::find($receiptId);
        $receiptParentId = $receipt->receiptable_id;
        $receiptType = $receipt->receipt_type;
        $parent = $receipt->parent;
        $orgId = $parent->org_id;
        $exchangeRate = $parent->exchange_rate;
        $parentCurrencyId = $parent->currency_id;

        // GET LIST DATA (CHANGE WHEN CONNECT ORACLE)
        $baseMileageUnit = -1;//Preference::getBaseMileageUnit($orgId);
        $mileageUnitLists = [];//MileageUnit::active()->pluck('description','mileage_unit_id')->all();
        $baseCurrencyId = Preference::getBaseCurrency();

        $branchLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->EVM()->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $departmentLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->department()->orderBy('flex_value')->pluck('full_description','flex_value')->all();

        $APWTTypeLists = APWTTypeV::select('description','value')->pluck('description','value')->all();
        $WHTRevenueNameLists = WHTRevenueNameV::select('description','value')->pluck('description','value')->all();
        $APImpItemGroupLists = APImpItemGroupV::select('description','value')->pluck('description','value')->all();
        $PONumberLists = PONumberV::select('po_number','po_number')->pluck('po_number','po_number')->all();
        $INVTobaccoLists = INVTobaccoV::select(\DB::raw("item_code || ' : ' || item_description AS full_description"),'item_code')
                    ->pluck('full_description','item_code')->take(100)->all();
        $APINVImpExpenseLists = APINVImpExpenseV::select('description','value')->pluck('description','value')->all();

        $distributionTypeLists = ['ภาษีเงินได้หัก ณ ที่จ่าย' => 'ภาษีเงินได้หัก ณ ที่จ่าย',
                                    'สินค้าต่างประเทศ' => 'สินค้าต่างประเทศ',
                                    'ใบเสร็จรับเงิน' => 'ใบเสร็จรับเงิน'];

        return view('ie.commons.receipts.lines._show_informations',
            compact(
                'receiptLine',
                'receipt',
                'baseMileageUnit',
                'mileageUnitLists',
                'baseCurrencyId',
                'parentCurrencyId',
                'exchangeRate',
                'branchLists',
                'departmentLists',
                'receiptType',
                'APWTTypeLists',
                'WHTRevenueNameLists',
                'APImpItemGroupLists',
                'PONumberLists',
                'INVTobaccoLists',
                'APINVImpExpenseLists',
                'distributionTypeLists',
            ));

    }

    public function duplicate(Request $request, $receiptId, $receiptLineId)
    {
        $receiptLine = ReceiptLine::find($receiptLineId);

        \DB::beginTransaction();
        try {

            $receipt = Receipt::find($receiptId);
            $receiptType = $receipt->receipt_type;
            $parent = $receipt->parent;
            if(!$parent->isPendingReceipt()){
                throw new \Exception("Request enable to add receipt line now.", 1);
            }

            // DUPLICATE RECEIPT LINE DATA
            $newReceiptLine = $receiptLine->replicate();
            $newReceiptLine->budget_status = null;
            $newReceiptLine->budget_status_msg = null;
            $newReceiptLine->last_updated_by = \Auth::user()->user_id;
            $newReceiptLine->created_by = \Auth::user()->user_id;
            $newReceiptLine->creation_date = Carbon::now();
            $newReceiptLine->last_update_date = Carbon::now();
            $newReceiptLine->save();

            // DUPLICATE RECEIPT LINE INFORMATIONS
            // if($receiptType == 'CLEARING'){
            //     $infos = CASubCategoryInfo::where('ca_sub_category_id',$newReceiptLine->sub_category_id)
            //         ->active()
            //         ->get();
            // }elseif($receiptType == 'REIMBURSEMENT'){
            //     $infos = SubCategoryInfo::where('sub_category_id',$newReceiptLine->sub_category_id)
            //         ->active()
            //         ->get();
            // }
            $infos = SubCategoryInfo::where('sub_category_id',$newReceiptLine->sub_category_id)
                    ->active()
                    ->get();

            if(count($infos)>0){

                $subCategoryInfos = $receiptLine->infos->pluck('description','sub_category_info_id')->all();

                foreach($infos as $info){
                    if(array_key_exists($info->sub_category_info_id, $subCategoryInfos)){
                        $newReceiptLineInfo = new ReceiptLineInfo();
                        $newReceiptLineInfo->receipt_id = $receiptId;
                        $newReceiptLineInfo->receipt_line_id = $newReceiptLine->receipt_line_id;
                        $newReceiptLineInfo->sub_category_id = $newReceiptLine->sub_category_id;
                        $newReceiptLineInfo->sub_category_info_id = $info->sub_category_info_id;
                        $newReceiptLineInfo->description = $subCategoryInfos[$info->sub_category_info_id];
                        $newReceiptLineInfo->last_updated_by = \Auth::user()->user_id;
                        $newReceiptLineInfo->created_by = \Auth::user()->user_id;
                        $newReceiptLineInfo->save();
                    }
                }
            }

        \DB::commit();

        } catch (\Exception $e) {
            // ERROR CREATE RECEIPT LINE
            \DB::rollBack();
            \Log::error($e->getMessage());
            if($request->ajax()){
                return \Response::json($e->getMessage(), 200);
            }else{
                return abort('403');
            }
        }

        if($request->ajax()){
            return \Response::json("success", 200);
        }else{
            return redirect()->route('ie.commons.receipts.show',['receiptId'=>$receiptId]);
        }

    }

    public function remove(Request $request, $receiptId, $receiptLineId)
    {
        $receiptLine = ReceiptLine::find($receiptLineId);
        if($receiptLine){
            $receiptLine->delete();
        }
        if($request->ajax()){
            return \Response::json("success", 200);
        }else{
            return redirect()->back()->withInput();
        }
    }

    // private function calWHTAmount($amount, $whtId)
    // {
    //     $wht = WHT::where('org_id',$this->orgId)->where('pay_awt_group_id',$whtId)->first();
    //     $whtRate = $wht->tax_rate;
    //     return (float)$amount * (float)$whtRate / 100;
    // }

    private function calVATAmount($amount, $vatId)
    {
        $vat = VAT::where('org_id',$this->orgId)->where('tax_rate_code',$vatId)->first();
        $vatRate = $vat->percentage_rate;
        return (float)$amount * (float)$vatRate / 100;
    }

    public function updateDFF(Request $request, $receiptId, $lineId)
    {
        \DB::beginTransaction();
        try {

            $line = ReceiptLine::find($lineId);

            $line->dff_type = $request->dff_type;
            $line->dff_pay_for = $request->pay_for;
            $line->dff_group_tax_code = $request->group_tax_code;
            $line->dff_tax_invoice_number = $request->tax_invoice_number;
            $line->dff_tax_invoice_date = $request->tax_invoice_date ? \DateTime::createFromFormat(trans('date.format'), $request->tax_invoice_date)->format('Y-m-d') : null;
            $line->dff_product_value = $request->product_value;
            $line->dff_address = $request->address;
            $line->dff_branch_number = $request->branch_number;
            $line->dff_tax_id = $request->tax_id;
            $line->dff_wht_flag = $request->wht_flag;
            $line->dff_wht_ref_number = $request->wht_ref_number;

            $line->save();

            \DB::commit();
            if($request->ajax()){
                $result['status'] = 'S';
                return $result;
            }else{
                return back()->with('success', 'Update DFF Success.');
            }

        } catch (\Exception $e) {
            // ERROR CREATE CASH ADVANCE
            \DB::rollBack();
            if($request->ajax()){
                $result['status'] = 'E';
                $result['err_msg'] = $e->getMessage();
                return $result;
            }else{
                // throw new \Exception($e->getMessage(), 1);
                \Log::error($e->getMessage());
                return back()->withErrors($e->getMessage());
            }
        }

    }

    public function updateDFFDistribution(Request $request, $receiptId, $lineId)
    {
        \DB::beginTransaction();
        try {

            $receiptLine = ReceiptLine::find($lineId);

            ///// DFF DISTRIBUTION //////
            $receiptLine->distribution_wht_date = null;
            $receiptLine->distribution_cert_number = null;
            $receiptLine->distribution_income_type = null;
            $receiptLine->distribution_income_name = null;

            $receiptLine->distribution_import_type = null;
            $receiptLine->distribution_po_number = null;
            $receiptLine->distribution_ref_number = null;
            $receiptLine->distribution_expense_type = null;
            $receiptLine->distribution_shipment = null;

            $receiptLine->distribution_receipt_number = null;
            $receiptLine->distribution_receipt_date = null;

            if($receiptLine->distribution_type == 'ภาษีเงินได้หัก ณ ที่จ่าย'){
                $receiptLine->distribution_wht_date = $request->distribution_wht_date ? \DateTime::createFromFormat(trans('date.format'), $request->distribution_wht_date)->format('Y-m-d') : null;
                $receiptLine->distribution_cert_number = $request->distribution_cert_number;
                $receiptLine->distribution_income_type = $request->distribution_income_type;
                $receiptLine->distribution_income_name = $request->distribution_income_name;
            }

            if($receiptLine->distribution_type == 'สินค้าต่างประเทศ'){
                $receiptLine->distribution_import_type = $request->distribution_import_type;
                $receiptLine->distribution_po_number = $request->distribution_po_number;
                $receiptLine->distribution_ref_number = $request->distribution_ref_number;
                $receiptLine->distribution_expense_type = $request->distribution_expense_type;
                $receiptLine->distribution_shipment = $request->distribution_shipment;
            }

            if($receiptLine->distribution_type == 'ใบเสร็จรับเงิน'){
                $receiptLine->distribution_receipt_number = $request->distribution_receipt_number;
                $receiptLine->distribution_receipt_date = $request->distribution_receipt_date ? \DateTime::createFromFormat(trans('date.format'), $request->distribution_receipt_date)->format('Y-m-d') : null;
            }

            $receiptLine->save();

            \DB::commit();
            if($request->ajax()){
                $result['status'] = 'S';
                return $result;
            }else{
                return back()->with('success', 'Update DFF Distribution Success.');
            }

        } catch (\Exception $e) {
            // ERROR CREATE CASH ADVANCE
            \DB::rollBack();
            if($request->ajax()){
                $result['status'] = 'E';
                $result['err_msg'] = $e->getMessage();
                return $result;
            }else{
                // throw new \Exception($e->getMessage(), 1);
                \Log::error($e->getMessage());
                return back()->withErrors($e->getMessage());
            }
        }

    }

    public function getInvTobacco(Request $request)
    {
        $INVTobaccoLists = INVTobaccoV::select(\DB::raw("item_code || ' : ' || item_description AS full_description"),'item_code')
            ->where(function($q) use($request){
                return $q->where('item_description', 'like', '%'.$request->q.'%')
                    ->orWhere('item_code', 'like', '%'.$request->q.'%');
            })
            ->take(100)->get();

        return response()->json($INVTobaccoLists);
    }

}