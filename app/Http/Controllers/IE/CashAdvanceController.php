<?php

namespace App\Http\Controllers\IE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\IE\SetDueDateRequest;

use App\Repositories\IE\AttachmentRepo;
use App\Repositories\IE\ActivityLogRepo;
use App\Repositories\IE\RequestRepo;
use App\Repositories\IE\ApprovalRepo;
use App\Repositories\IE\MailRepo;
use App\Repositories\IE\InterfaceRepo;

use App\Models\IE\CashAdvance;
use App\Models\IE\CashAdvanceInfo;
use App\Models\IE\Preference;
use App\Models\IE\Employee;
use App\Models\IE\Category;
use App\Models\IE\SubCategory;
use App\Models\IE\SubCategoryInfo;
use App\Models\IE\Currency;
use App\Models\IE\Location;
use App\Models\IE\Establishment;
use App\Models\IE\Vendor;
use App\Models\IE\FNDListOfValues;
use App\Models\IE\CACategory;
use App\Models\IE\CASubCategory;
use App\Models\IE\CASubCategoryInfo;
use App\Models\IE\PurposeSetup;
use App\Models\IE\APPaymentTerm;
use App\Models\IE\APPaymentMethod;
use App\Models\IE\ReceiptLineInfo;
use App\Models\IE\HrOperatingUnit;
use App\Models\IE\APReportingEntity;
use App\Models\User;
use App\Models\IE\HierarchyType;
use App\Models\IE\HierarchyName;
use App\Models\IE\HierarchySetup;
use App\Models\HREmployee;
// use App\Models\IE\APTerm;
use App\Models\IE\InterfaceEncumbrance;
use App\Models\IE\InterfaceAPHeader;

use Carbon\Carbon;


class CashAdvanceController extends Controller
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

    public function index(Request $request)
    {
        if(!canView('/ie/cash-advances') && !canEnter('/ie/cash-advances')) {
            return redirect()->back()->withErrors(trans('403'));
        }

        $search = $request->search;
        $cashAdvances = CashAdvance::search($search)
            ->whereNull('apply_to')
            ->when(!\Auth::user()->isShowAll(), function($q){
                $q->whereCreatedBy(\Auth::user()->user_id)
                ->orWhere('requester_id', \Auth::user()->username);
            })
            ->with('user', 'apply')
            ->orderBy('creation_date','desc')
            ->paginate($this->perPage);
        $allowDuplicate = true;
        $statusSet = [
            'BLOCKED',
            'NEW_REQUEST',
            'CLEARING_REQUEST',
            'DECISION',
            'PROCESS',
            'REJECTED',
            'CANCELLED',
            'APPROVED',
            'CLEARED'
        ];

        $mappings = Preference::getMappingOU();

        return view('ie.cash-advances.index', compact(
            'cashAdvances',
            'search',
            'statusSet',
            'allowDuplicate',
            'mappings'
        ));
    }

    public function indexPending(Request $request)
    {
        if(!canView('/ie/cash-advances/pending') && !canEnter('/ie/cash-advances/pending')) {
            return redirect()->back()->withErrors(trans('403'));
        }

        $search = $request->search;
        $cashAdvances = CashAdvance::search($search)
            ->whereNull('apply_to')
            ->ByPendingUser(\Auth::user()->user_id)
            ->with('user', 'apply')
            ->orderBy('creation_date','desc')
            ->paginate($this->perPage);
        $statusSet = [
            'BLOCKED',
            'NEW_REQUEST',
            'CLEARING_REQUEST',
            'DECISION',
            'PROCESS',
            'REJECTED',
            'CANCELLED',
            'APPROVED',
            'CLEARED'
        ];

        $mappings = Preference::getMappingOU();

        return view('ie.cash-advances.index_pending', compact(
            'cashAdvances',
            'search',
            'statusSet',
            'mappings'
        ));
    }

    public function create()
    {
        if(!canEnter('/ie/cash-advances')) {
            return redirect()->back()->withErrors(trans('403'));
        }

        // GET PENDING TRASACTION
        $pendingRequestLists = [];

        $user = auth()->user();
        $requester = $user->PersonalDeptLocation ? $user : null;

        $employeeLists = HREmployee::select(\DB::raw("first_name || ' ' || last_name AS description"),'username')
            ->orderBy('username')
            ->pluck('description','username')
            ->all();

        $userLists = User::select('name', 'user_id')
            ->has('hrEmp')
            ->orderBy('username')
            ->pluck('name','user_id')
            ->all();

        $bankLists = [];
        $accountLists = [];
        $supplierLists = [];
        $defaultSupplier = [];
        $defaultSupplierId = null;
        $defaultPaymentMethod = optional(APPaymentMethod::active()->whereRaw('UPPER(payment_method_code) = ?', [strtoupper('Transfer')])->first())->payment_method_code ?? 'Transfer';

        // GET LIST DATA (CHANGE WHEN CONNECT ORACLE)
        $CACategoryLists = Category::active()
            ->where(function ($query) {
                return $query->whereHas('subCategories', function($q){
                    $q->where('use_in_ca', true);
                });
            })
            ->pluck('name','category_id')
            ->all();
        $CASubCategoryLists = [];
        $baseCurrencyId = Preference::getBaseCurrency();
        $currencyLists = Currency::pluck('currency_code','currency_code')->all();

        $APPaymentMethodLists = APPaymentMethod::active()
            ->pluck('payment_method_name','payment_method_code')
            ->all();

        $APPaymentTerms = APPaymentTerm::all();
        $APPaymentTermLists = APPaymentTerm::select(\DB::raw("payment_term_name AS full_description"),'payment_term_id')
            ->orderBy('payment_term_id')
            ->pluck('full_description','payment_term_id')
            ->all();
        $ouLists = HrOperatingUnit::select(\DB::raw("name AS full_description"),'organization_id')
            ->orderBy('organization_id')
            ->pluck('full_description','organization_id')
            ->all();
        $purposeLists = PurposeSetup::getPurpose(true);

        return view('ie.cash-advances.create', compact(
            'baseCurrencyId',
            'requester',
            'userLists',
            'bankLists',
            'accountLists',
            'employeeLists',
            'currencyLists',
            'CACategoryLists',
            'CASubCategoryLists',
            'pendingRequestLists',
            'supplierLists',
            'ouLists',
            'APPaymentMethodLists',
            'APPaymentTerms',
            'APPaymentTermLists',
            'defaultSupplierId',
            'defaultPaymentMethod',
            'purposeLists'
        ));
    }

    public function store(Request $request)
    {
        if(!canEnter('/ie/cash-advances')) {
            return redirect()->back()->withErrors(trans('403'));
        }

        \DB::beginTransaction();
        try {
            // CREATE CASH ADVANCE
            $cashAdvance = new CashAdvance();
            $emp = HREmployee::find($request->requester_id);
            
            // GET PENDING TRASACTION
            $pendingRequestLists = RequestRepo::getPendingOverLimitRequest($request->requester_id);

            $cashAdvance->user_id = optional($emp->user)->user_id;
            $cashAdvance->org_id = $request->org_id;
            $orgId = $cashAdvance->org_id;

            $cashAdvance->request_date = \DateTime::createFromFormat(trans('date.format'), $request->request_date)->format('Y-m-d');
            $cashAdvance->gl_date = \DateTime::createFromFormat(trans('date.format'), $request->gl_date)->format('Y-m-d');
            $cashAdvance->prepay_apply_date = $cashAdvance->gl_date;

            $cashAdvance->currency_id  = $request->currency_id;
            $cashAdvance->advance_type = $request->advance_type;
            $currencyType = $cashAdvance->advance_type == 'ในประเทศ' ? 1 : 2;
            $cashAdvance->exchange_rate = $cashAdvance->currency_id == 'THB' ? 1 : $request->exchange_rate;
            $cashAdvance->rate_date = $cashAdvance->currency_id == 'THB' ? null : ($request->rate_date ? \DateTime::createFromFormat(trans('date.format'), $request->rate_date)->format('Y-m-d') : null);
            $documentNo = CashAdvance::genDocumentNo($orgId, $currencyType, null, $cashAdvance->gl_date);
            $cashAdvance->document_no = $documentNo['CA'];
            $cashAdvance->clearing_document_no = $documentNo['CL'];
            $cashAdvance->tel = $request->tel;

            // $cashAdvance->amount = $request->amount;
            // $cashAdvance->primary_amount = $request->amount * $cashAdvance->exchange_rate;
            $cashAdvance->amount = 0;
            $cashAdvance->primary_amount = 0;

            // if($request->ca_category_id){
            //     $cashAdvance->ca_category_id = $request->ca_category_id;
            // }else{
            //     $caSubCategory = SubCategory::find($request->ca_sub_category_id);
            //     $cashAdvance->ca_category_id = $caSubCategory->category->category_id;
            // }
            // $cashAdvance->ca_sub_category_id = $request->ca_sub_category_id;
            $cashAdvance->ca_category_id = -1;
            $cashAdvance->ca_sub_category_id = -1;

            $cashAdvance->vendor_id = $request->supplier_id;
            $cashAdvance->vendor_site_id = $request->supplier_site_id;

            $supplier = Vendor::where('vendor_id', $cashAdvance->vendor_id)
            ->where('vendor_site_id', $cashAdvance->vendor_site_id)
            ->whereOrgId($orgId)
            ->first();
            if($supplier){
                $cashAdvance->vendor_bank_name = optional($supplier->bank)->short_bank_name;
                $cashAdvance->vendor_bank_account_no = optional($supplier->bank)->bank_account_num;
            }

            $cashAdvance->payment_method_id = $request->payment_method_id;
            $defaultPaymentTerm = APPaymentTerm::where('due_days', 0)->first();
            $cashAdvance->payment_term_id = $defaultPaymentTerm->payment_term_id;
            $cashAdvance->due_date = \DateTime::createFromFormat(trans('date.format'), $request->gl_date)->format('Y-m-d');
            $cashAdvance->need_by_date = \DateTime::createFromFormat(trans('date.format'), $request->need_by_date)->format('Y-m-d');
            $cashAdvance->finish_date = \DateTime::createFromFormat(trans('date.format'), $request->finish_date)->format('Y-m-d');

            $cashAdvance->requester_id = $request->requester_id;
            $cashAdvance->bank_name = $request->bank_name;
            $cashAdvance->account_no = $request->account_no;
            $cashAdvance->account_name = $request->account_name;
            $cashAdvance->position_name = $request->position_name;
            $cashAdvance->department_code = $request->department_code;
            $cashAdvance->employee_id = $request->employee_id;
            $cashAdvance->pay_to_emp = $request->pay_to_emp;

            if(count($pendingRequestLists) <= 0){
                $cashAdvance->status = "NEW_REQUEST";
            }else{ // BLOCKED IF HAS PENDING REQUEST
                $cashAdvance->status = "BLOCKED";
            }
            $cashAdvance->purpose  = trim($request->purpose);
            $cashAdvance->reason  = trim($request->reason);
            
            $cashAdvance->checked_by = $request->checked_by;
            $cashAdvance->approved_by = $request->approved_by;

            $cashAdvance->last_updated_by = \Auth::user()->user_id;
            $cashAdvance->created_by = \Auth::user()->user_id;

            ///// DFF /////
            $groupTaxCode = APReportingEntity::select(\DB::raw("entity_name AS full_description"),'entity_name')
                            ->whereOrgId($orgId)
                            ->orderBy('entity_name')
                            ->first();

            $cashAdvance->dff_type = 'cash_advance';
            $cashAdvance->dff_pay_for = $request->pay_to_emp == 'YES' ? optional($cashAdvance->user)->name : optional($supplier)->vendor_name;
            $cashAdvance->dff_group_tax_code = $groupTaxCode ? $groupTaxCode->entity_name : null;

            $cashAdvance->save();

            // INSERT CASH-ADVANCE INFORMATIONS
            // $infos = CASubCategoryInfo::where('ca_sub_category_id',$cashAdvance->ca_sub_category_id)->active()->get();
            // $infos = SubCategoryInfo::where('sub_category_id',$cashAdvance->ca_sub_category_id)->active()->get();

            // if(count($infos)>0){
            //     foreach($infos as $info){
            //         if($request->ca_sub_category_infos[$info->casub_cate_info_id]){
            //             $cashAdvaneInfo = new CashAdvanceInfo();
            //             $cashAdvaneInfo->cash_advance_id = $cashAdvance->cash_advance_id;
            //             $cashAdvaneInfo->ca_sub_category_id = $cashAdvance->ca_sub_category_id;
            //             $cashAdvaneInfo->ca_sub_category_info_id = $info->casub_cate_info_id;
            //             if($info->form_type == 'date'){
            //                 $cashAdvaneInfo->description = \DateTime::createFromFormat(trans('date.format'), $request->ca_sub_category_infos[$info->casub_cate_info_id])->format('Y-m-d');
            //             }else{
            //                 $cashAdvaneInfo->description = $request->ca_sub_category_infos[$info->casub_cate_info_id];
            //             }
            //             $cashAdvaneInfo->last_updated_by = \Auth::user()->user_id;
            //             $cashAdvaneInfo->created_by = \Auth::user()->user_id;
            //             $cashAdvaneInfo->save();
            //         }
            //     }
            // }

            // FILE ATTACHMENTS
            if($request->file('file')){
                $attachmentRepo = new AttachmentRepo;
                $attachmentRepo->create($cashAdvance, $request->file('file'));
            }

            // ACTIVITY LOG
            $activityLogRepo = new ActivityLogRepo;
            $activityLogRepo->create($cashAdvance, ActivityLogRepo::getActivityMessage('NEW_REQUEST'), 'NEW_REQUEST');

            // SUCCESS CREATE CASH ADVANCE
            \DB::commit();
            if($request->ajax()){
                $result['status'] = 'SUCCESS';
                $result['cashAdvanceId'] = $cashAdvance->cash_advance_id;
                return $result;
            }else{
                return redirect()->route('ie.cash-advances.show',['cashAdvance'=>$cashAdvance->cash_advance_id]);
            }

        } catch (\Exception $e) {
            // ERROR CREATE CASH ADVANCE
            \DB::rollBack();
            if($request->ajax()){
                $result['status'] = 'ERROR';
                $result['err_msg'] = $e->getMessage();
                return $result;
            }else{
                // throw new \Exception($e->getMessage(), 1);
                // \Log::error($e->getMessage());
                return back()->withErrors($e->getMessage());
            }
        }
    }

    public function show($cashAdvanceId)
    {
        if(!canView('/ie/cash-advances') && !canEnter('/ie/cash-advances')) {
            return redirect()->back()->withErrors(trans('403'));
        }

        // GET CA DATA
        $cashAdvance = CashAdvance::find($cashAdvanceId);
        if(!$cashAdvance){ abort(404); }
        // if(!$cashAdvance->isRelatedUser()){ abort(404); }

        $cashAdvance->amount = $cashAdvance->amount + 0;
        $cashAdvance->request_date = dateFormatDisplay($cashAdvance->request_date);
        $cashAdvance->gl_date = dateFormatDisplay($cashAdvance->gl_date);
        $cashAdvance->need_by_date = dateFormatDisplay($cashAdvance->need_by_date);
        $cashAdvance->due_date = dateFormatDisplay($cashAdvance->due_date);
        $cashAdvance->rate_date = dateFormatDisplay($cashAdvance->rate_date);
        $parentCurrencyId = $cashAdvance->currency_id;

        $orgId = $cashAdvance->org_id;

        $requester = $cashAdvance->requester->user;

        // CASH-ADVANCE INFOMATIONS
        // $CASubCategoryInfos = CASubCategoryInfo::where('ca_sub_category_id',$cashAdvance->ca_sub_category_id)
        //     ->active()
        //     ->get();
        $CASubCategoryInfos = SubCategoryInfo::where('sub_category_id',$cashAdvance->ca_sub_category_id)
            ->active()
            ->get();
        $cashAdvanceInfos = CashAdvanceInfo::where('cash_advance_id',$cashAdvance->cash_advance_id)->get();
        $cashAdvanceInfoLists = CashAdvanceInfo::where('cash_advance_id',$cashAdvance->cash_advance_id)
                                                ->pluck('description','ca_sub_category_info_id')
                                                ->all();

        // GET ACTIVITY LOG
        $activityLogs = $cashAdvance->activityLogs;

        // GET PENDING TRASACTION
        $pendingRequestLists = RequestRepo::getPendingOverLimitRequest($cashAdvance->requester_id);
        
        $parent = $cashAdvance;
        $receiptType = 'CASH-ADVANCE';
        $receipts = $cashAdvance->receipts()->processType($receiptType)->get();
        $receiptParentId = $cashAdvanceId;

        $defaultAPPaymentMethodId = $cashAdvance->payment_method_id;
        $APPaymentMethodLists = APPaymentMethod::active()
            ->pluck('payment_method_name','payment_method_code')
            ->all();

        $defaultAPPaymentTermId = $cashAdvance->payment_term_id;
        $APPaymentTerms = APPaymentTerm::all();
        $APPaymentTermLists = APPaymentTerm::select(\DB::raw("payment_term_id || ' : ' || payment_term_name AS full_description"),'payment_term_id')
            ->orderBy('payment_term_id')
            ->pluck('full_description','payment_term_id')
            ->all();

        $ouLists = HrOperatingUnit::select(\DB::raw("name AS full_description"),'organization_id')
            ->orderBy('organization_id')
            ->pluck('full_description','organization_id')
            ->all();
        
        return view('ie.cash-advances.show', compact(
            'cashAdvance',
            'requester',
            'cashAdvanceInfos',
            'parentCurrencyId',
            'activityLogs',
            
            'receipts',
            'receiptParentId',
            'receiptType',
            'parent',
            
            'ouLists',
            'CASubCategoryInfos',
            // 'cashAdvanceInfos',
            // 'cashAdvanceInfoLists',
            'pendingRequestLists',
            'defaultAPPaymentMethodId',
            'APPaymentMethodLists',
            'defaultAPPaymentTermId',
            'APPaymentTermLists',
            'APPaymentTerms',
        ));
    }

    public function formEdit(Request $request, $cashAdvanceId)
    {
        if(!canEnter('/ie/cash-advances')) {
            return redirect()->back()->withErrors(trans('403'));
        }

        // GET CA DATA
        $cashAdvance = CashAdvance::find($cashAdvanceId);
        if(!$cashAdvance){ abort(404); }

        $receiptType = $request->receipt_type;

        $cashAdvance->amount = $cashAdvance->amount + 0;
        $cashAdvance->request_date = dateFormatDisplay($cashAdvance->request_date);
        $cashAdvance->gl_date = dateFormatDisplay($cashAdvance->gl_date);
        $cashAdvance->clearing_request_date = dateFormatDisplay($cashAdvance->clearing_request_date);
        $cashAdvance->clearing_gl_date = dateFormatDisplay($cashAdvance->clearing_gl_date);
        $cashAdvance->need_by_date = dateFormatDisplay($cashAdvance->need_by_date);
        $cashAdvance->due_date = dateFormatDisplay($cashAdvance->due_date);
        $cashAdvance->finish_date = dateFormatDisplay($cashAdvance->finish_date);
        $cashAdvance->rate_date = dateFormatDisplay($cashAdvance->rate_date);
        $parentCurrencyId = $cashAdvance->currency_id;

        $requester = $cashAdvance->user;
        $orgId = $cashAdvance->org_id;

        $employeeLists = HREmployee::select(\DB::raw("first_name || ' ' || last_name AS description"),'username')
            ->orderBy('username')
            ->pluck('description','username')
            ->all();

        $userLists = User::select('name', 'user_id')
            ->has('hrEmp')
            ->orderBy('username')
            ->pluck('name','user_id')
            ->all();

        $bankLists = $requester->userAccounts()
            ->select(\DB::raw("bank_name AS full_description"),'bank_name')
            ->orderBy('bank_name')
            ->pluck('full_description','bank_name')
            ->all();
        
        $defaultBank = $cashAdvance->bank_name;
        $accountLists = $requester->userAccounts;
        $defaultAccountNo = $cashAdvance->account_no;
        $ouLists = HrOperatingUnit::select(\DB::raw("name AS full_description"),'organization_id')
            ->orderBy('organization_id')
            ->pluck('full_description','organization_id')
            ->all();

        $currencyLists = Currency::pluck('currency_code','currency_code')->all();

        $supplierLists = Vendor::select(\DB::raw("vendor_no || ' : ' || vendor_name AS full_description"),'vendor_id')
            ->whereOrgId($orgId)
            ->orderBy('vendor_id')
            ->pluck('full_description','vendor_id')
            ->all();

        $defaultSupplierId = $cashAdvance->vendor_id;
        $defaultSupplierSiteId = $cashAdvance->vendor_site_id;

        $APPaymentMethodLists = APPaymentMethod::active()
            ->pluck('payment_method_name','payment_method_code')
            ->all();

        $APPaymentTerms = APPaymentTerm::all();
        $APPaymentTermLists = APPaymentTerm::select(\DB::raw("payment_term_id || ' : ' || payment_term_name AS full_description"),'payment_term_id')
            ->orderBy('payment_term_id')
            ->pluck('full_description','payment_term_id')
            ->all();

        $purposeLists = PurposeSetup::getPurpose(true);

        return view('ie.cash-advances._form_edit', compact(
            'cashAdvance',
            'receiptType',
            'requester',
            'bankLists',
            'defaultBank',
            'accountLists',
            'defaultAccountNo',
            'currencyLists',
            'ouLists',
            'defaultSupplierId',
            'defaultSupplierSiteId',
            'userLists',
            'employeeLists',
            'supplierLists',
            'APPaymentMethodLists',
            'APPaymentTerms',
            'APPaymentTermLists',
            'purposeLists'
        ));
    }

    public function update(Request $request, $cashAdvanceId)
    {
        if(!canEnter('/ie/cash-advances')) {
            return redirect()->back()->withErrors(trans('403'));
        }

        \DB::beginTransaction();
        try {

            $cashAdvance = CashAdvance::find($cashAdvanceId);
            $emp = HREmployee::find($request->requester_id);
            $cashAdvance->user_id =  optional($emp->user)->user_id;
            // if(!$cashAdvance->receipts->count()){
                $cashAdvance->org_id = $request->org_id;
                if($request->process_type == 'CASH-ADVANCE'){

                    $cashAdvance->request_date = \DateTime::createFromFormat(trans('date.format'), $request->request_date)->format('Y-m-d');
                    $cashAdvance->gl_date = \DateTime::createFromFormat(trans('date.format'), $request->gl_date)->format('Y-m-d');
                    $cashAdvance->prepay_apply_date = $cashAdvance->gl_date;
                }else {

                    $cashAdvance->clearing_request_date = \DateTime::createFromFormat(trans('date.format'), $request->clearing_request_date)->format('Y-m-d');
                    $cashAdvance->clearing_gl_date = \DateTime::createFromFormat(trans('date.format'), $request->clearing_gl_date)->format('Y-m-d');
                    $cashAdvance->prepay_apply_date = $cashAdvance->clearing_gl_date;
                }
            // }
            $orgId = $cashAdvance->org_id;

            $cashAdvance->currency_id  = $request->currency_id;
            $cashAdvance->exchange_rate = $cashAdvance->currency_id == 'THB' ? 1 : $request->exchange_rate;
            $cashAdvance->rate_date = $cashAdvance->currency_id == 'THB' ? null : ($request->rate_date ? \DateTime::createFromFormat(trans('date.format'), $request->rate_date)->format('Y-m-d') : null);

            // $cashAdvance->amount = $request->amount;
            // $cashAdvance->primary_amount = $request->amount * $cashAdvance->exchange_rate;

            $checkChangeDFF = ($cashAdvance->requester_id != $request->requester_id) 
                || ($cashAdvance->pay_to_emp != $request->pay_to_emp) 
                || ($cashAdvance->vendor_id != $request->supplier_id)
                || ($cashAdvance->vendor_site_id != $request->supplier_site_id);
            $cashAdvance->vendor_id = $request->supplier_id;
            $cashAdvance->vendor_site_id = $request->supplier_site_id;

            $supplier = Vendor::where('vendor_id', $cashAdvance->vendor_id)
            ->where('vendor_site_id', $cashAdvance->vendor_site_id)
            ->whereOrgId($orgId)
            ->first();
            if($supplier){
                $cashAdvance->vendor_bank_name = optional($supplier->bank)->short_bank_name;
                $cashAdvance->vendor_bank_account_no = optional($supplier->bank)->bank_account_num;
            }

            $cashAdvance->payment_method_id = $request->payment_method_id;
            // $cashAdvance->payment_term_id = $request->payment_term_id;
            $cashAdvance->due_date = $cashAdvance->gl_date;
            $cashAdvance->need_by_date = \DateTime::createFromFormat(trans('date.format'), $request->need_by_date)->format('Y-m-d');
            $cashAdvance->finish_date = \DateTime::createFromFormat(trans('date.format'), $request->finish_date)->format('Y-m-d');
            $cashAdvance->tel = $request->tel;

            $cashAdvance->requester_id = $request->requester_id;
            $cashAdvance->bank_name = $request->bank_name;
            $cashAdvance->account_no = $request->account_no;
            $cashAdvance->account_name = $request->account_name;
            $cashAdvance->position_name = $request->position_name;
            $cashAdvance->department_code = $request->department_code;
            $cashAdvance->employee_id = $request->employee_id;
            $cashAdvance->pay_to_emp = $request->pay_to_emp;
            // $cashAdvance->advance_type = $request->advance_type;

            $cashAdvance->purpose  = trim($request->purpose);
            $cashAdvance->reason  = trim($request->reason);
            
            $cashAdvance->checked_by = $request->checked_by;
            $cashAdvance->approved_by = $request->approved_by;

            $cashAdvance->last_updated_by = \Auth::user()->user_id;

            // $budgetYear = getBudgetYear($cashAdvance->gl_date ?? $cashAdvance->request_date);

            ///// DFF /////
            if($checkChangeDFF){
                $groupTaxCode = APReportingEntity::select(\DB::raw("entity_name AS full_description"),'entity_name')
                ->whereOrgId($orgId)
                ->orderBy('entity_name')
                ->first();

                if($request->process_type == 'CASH-ADVANCE'){
                    $cashAdvance->dff_type = 'cash_advance';
                    $cashAdvance->dff_pay_for = $request->pay_to_emp == 'YES' ? optional($cashAdvance->user)->name : optional($supplier)->vendor_name;
                    $cashAdvance->dff_group_tax_code = $groupTaxCode ? $groupTaxCode->entity_name : null;
                }
            }

            $cashAdvance->save();


            ////// UPDATE RECEIPT //////
            // $requester = $cashAdvance->user;
            // $orgId = $cashAdvance->org_id;

            // $empCode = optional(optional($requester)->PersonalDeptLocation)->dept_cd_f02 ?? null;
            // $findEmp = Employee::where('employee_number', 'like', '%'.$empCode.'%')->first() ?? null;

            // if(!$findEmp){
            //     \DB::rollBack();
            //     return redirect()->route('ie.cash-advances.show',['cashAdvance'=>$cashAdvance->cash_advance_id])->withErrors('ไม่พบข้อมูล expense_account'); 
            // }

            // foreach ($cashAdvance->receipts()->where('process_type', $request->process_type)->get() as $receipt) {
            //     $receipt->employee_id = $findEmp->employee_id;
            //     $receipt->save();

            //     $emp = $receipt->employee;
            //     $emp->org_id = $orgId;

            //     foreach ($receipt->lines as $receiptLine) {
            //         $lineSubCategory = SubCategory::find($receiptLine->sub_category_id);
            //         $useAllCOAFlag = $lineSubCategory->use_all_segments;

            //         if($useAllCOAFlag){
            //             $lineSegments = InterfaceRepo::composeGLCodeCombinationSegmentsBySubCategory($lineSubCategory);
            //         }else {
            //             $lineSegments = InterfaceRepo::composeGLCodeCombinationSegments(
            //                 null, // company
            //                 null, // evm
            //                 null, // department
            //                 null, // cost center
            //                 $budgetYear, // budget year
            //                 $lineSubCategory->budget_type_code, // budget type
            //                 $lineSubCategory->budget_detail_code, // budget detail
            //                 $lineSubCategory->budget_reason_code, // budget reason
            //                 null, // account
            //                 $lineSubCategory->sub_account_code, // sub account 
            //                 $lineSubCategory->reserve1_code, // reserve1
            //                 $lineSubCategory->reserve2_code // reserve2
            //             );
            //         }

            //         $glCodeCombination = InterfaceRepo::getGLCodeCombinationOfEmpBySegments($emp,$lineSegments);

            //         $receiptLine->code_combination_id = $glCodeCombination['code_combination_id'];
            //         $receiptLine->concatenated_segments = $glCodeCombination['concatenated_segments'];

            //         $receiptLine->last_updated_by = \Auth::user()->user_id;
            //         $receiptLine->save();
            //     }
            // }

            // UPDATE CASH-ADVANCE INFORMATIONS
            // $infos = CASubCategoryInfo::where('ca_sub_category_id',$cashAdvance->ca_sub_category_id)
            //             ->active()->get();
            // $infos = SubCategoryInfo::where('sub_category_id',$cashAdvance->ca_sub_category_id)
            //             ->active()->get();

            // if(count($infos)>0){
            //     foreach($infos as $info){
            //         if($request->ca_sub_category_infos[$info->casub_cate_info_id]){
            //             $cashAdvaneInfo = CashAdvanceInfo::where('cash_advance_id',$cashAdvanceId)
            //                             ->where('sub_category_id',$cashAdvance->ca_sub_category_id)
            //                             ->where('sub_category_info_id',$info->casub_cate_info_id)
            //                             ->first();
            //             if($info->form_type == 'date'){
            //                 $cashAdvaneInfo->description = \DateTime::createFromFormat(trans('date.format'), $request->ca_sub_category_infos[$info->ca_sub_category_info_id])->format('Y-m-d');
            //             }else{
            //                 $cashAdvaneInfo->description = $request->ca_sub_category_infos[$info->casub_cate_info_id];
            //             }
            //             $cashAdvaneInfo->last_updated_by = \Auth::user()->user_id;
            //             $cashAdvaneInfo->save();
            //         }
            //     }
            // }

        } catch (\Exception $e) {
            \DB::rollBack();

            if($request->process_type == 'CLEARING'){
                return redirect()->route('ie.cash-advances.clear',['cashAdvance'=>$cashAdvance->cash_advance_id])->withErrors($e->getMessage()); 
            }else {
                return redirect()->route('ie.cash-advances.show',['cashAdvance'=>$cashAdvance->cash_advance_id])->withErrors($e->getMessage());
            }
            // \Log::error($e->getMessage());
        }
        \DB::commit();

        if($request->process_type == 'CLEARING'){
            return redirect()->route('ie.cash-advances.clear',['cashAdvance'=>$cashAdvance->cash_advance_id]);
        }else {
            return redirect()->route('ie.cash-advances.show',['cashAdvance'=>$cashAdvance->cash_advance_id]);
        }
    }

    public function formEditCL(Request $request, $cashAdvanceId)
    {
        if(!canEnter('/ie/cash-advances')) {
            return redirect()->back()->withErrors(trans('403'));
        }

        // GET CA DATA
        $cashAdvance = CashAdvance::find($cashAdvanceId);
        $cashAdvance->clearing_request_date = dateFormatDisplay($cashAdvance->clearing_request_date);
        $cashAdvance->clearing_gl_date = dateFormatDisplay($cashAdvance->clearing_gl_date);
        if(!$cashAdvance){ abort(404); }

        return view('ie.cash-advances.clear._form_edit',
                    compact('cashAdvance',));

    }

    public function updateCL(Request $request, $cashAdvanceId)
    {
        if(!canEnter('/ie/cash-advances')) {
            return redirect()->back()->withErrors(trans('403'));
        }

        \DB::beginTransaction();
        try {

            $cashAdvance = CashAdvance::find($cashAdvanceId);
            $cashAdvance->clearing_pay_to_emp = $request->pay_to_emp;
            $cashAdvance->clearing_request_date = \DateTime::createFromFormat(trans('date.format'), $request->clearing_request_date)->format('Y-m-d');
            $cashAdvance->clearing_gl_date = \DateTime::createFromFormat(trans('date.format'), $request->clearing_gl_date)->format('Y-m-d');
            $cashAdvance->prepay_apply_date = $cashAdvance->clearing_gl_date;

            $cashAdvance->save();

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error($e->getMessage());
        }
        \DB::commit();

        return redirect()->route('ie.cash-advances.clear',['cashAdvance'=>$cashAdvance->cash_advance_id]);
    }

    public function clearRequest($cashAdvanceId)
    {
        if(!canEnter('/ie/cash-advances')) {
            return redirect()->back()->withErrors(trans('403'));
        }

        \DB::beginTransaction();
        try {

            $cashAdvance = CashAdvance::find($cashAdvanceId);
            if($cashAdvance->status != 'APPROVED' || !$cashAdvance->isRequester()){ abort(403); }
            $cashAdvance->status = 'CLEARING_REQUEST';
            $cashAdvance->clearing_request_date = \Carbon\Carbon::now()->format('Y-m-d');
            $cashAdvance->clearing_gl_date = \Carbon\Carbon::now()->format('Y-m-d');
            $cashAdvance->clearing_pay_to_emp = $cashAdvance->pay_to_emp;
            $cashAdvance->last_updated_by = \Auth::user()->user_id;

            $orgId = $cashAdvance->org_id;

            $apply = $cashAdvance->apply;

            ///// DFF /////
            $cashAdvance->clearing_dff_type = $apply ? $apply->clearing_dff_type : $cashAdvance->dff_type;
            $cashAdvance->clearing_dff_pay_for = $apply ? $apply->clearing_dff_pay_for : $cashAdvance->dff_pay_for;
            $cashAdvance->clearing_dff_group_tax_code = $apply ? $apply->clearing_dff_group_tax_code : $cashAdvance->dff_group_tax_code;

            $cashAdvance->save();

            $receipts = $apply ? $apply->receipts()->processType('CLEARING')->orderBy('receipt_id')->get() : $cashAdvance->receipts()->processType('CASH-ADVANCE')->orderBy('receipt_id')->get();
            foreach ($receipts as $key => $receipt) {

                $newReceipt = $receipt->replicate();
                $newReceipt->receiptable_id = $cashAdvance->cash_advance_id;
                $newReceipt->process_type = 'CLEARING';
                $newReceipt->last_updated_by = \Auth::user()->user_id;
                $newReceipt->created_by = \Auth::user()->user_id;
                // SAVE RECEIPT DATA
                $newReceipt->save();

                /////////////////////////////////
                // DUPLICATE RECEIPT LINES DATA
                $receiptLines = $receipt->lines;
                foreach($receiptLines as $receiptLine){

                    // DUPLICATE RECEIPT LINE DATA
                    $newReceiptLine = $receiptLine->replicate();
                    $newReceiptLine->receipt_id = $newReceipt->receipt_id;
                    $newReceiptLine->budget_status = null;
                    $newReceiptLine->budget_status_msg = null;
                    $newReceiptLine->last_updated_by = \Auth::user()->user_id;
                    $newReceiptLine->created_by = \Auth::user()->user_id;

                    if(!$apply){
                        ///// DFF //////
                        $groupTaxCode = APReportingEntity::select(\DB::raw("entity_name AS full_description"),'entity_name')
                                    ->whereOrgId($orgId)
                                    ->orderBy('entity_name')
                                    ->first();

                        $newReceiptLine->dff_type = 'tax_invoice';
                        $newReceiptLine->dff_pay_for = $receipt->vendor_name ?? ($receipt->vendor_id != 'other' ? optional($receipt->vendor)->vendor_name : null);
                        $newReceiptLine->dff_group_tax_code = $groupTaxCode ? $groupTaxCode->entity_name : null;

                        $newReceiptLine->dff_tax_invoice_number = $receipt->receipt_number;
                        $newReceiptLine->dff_tax_invoice_date = $receipt->receipt_date;
                        $newReceiptLine->dff_product_value = $receiptLine->total_amount;

                        $newReceiptLine->dff_address = $receipt->vendor_tax_address ?? ($receipt->vendor_id != 'other' ? optional($receipt->vendor)->getTaxAddress() : null);
                        $newReceiptLine->dff_branch_number = $receipt->vendor_branch_name ?? ($receipt->vendor_id != 'other' ? optional($receipt->vendor)->getBranchNumber() : null);
                        $newReceiptLine->dff_tax_id = $receipt->vendor_tax_id ?? ($receipt->vendor_id != 'other' ? optional($receipt->vendor)->getTaxID() : null);
                    }

                    $newReceiptLine->save();

                    // DUPLICATE RECEIPT LINE INFORMATIONS
                    $infos = SubCategoryInfo::where('sub_category_id', $newReceiptLine->sub_category_id)
                                ->active()
                                ->get();

                    if(count($infos)>0){

                        $subCategoryInfos = $receiptLine->infos->pluck('description','sub_category_info_id')->all();

                        foreach($infos as $info){
                            if(array_key_exists($info->sub_category_info_id, $subCategoryInfos)){
                                $newReceiptLineInfo = new ReceiptLineInfo();
                                $newReceiptLineInfo->receipt_id = $newReceipt->receipt_id;
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

                }
            }

            // ACTIVITY LOG
            $activityLogRepo = new ActivityLogRepo;
            $activityLogRepo->create($cashAdvance, ActivityLogRepo::getActivityMessage('CLEARING_CREATE_REQUEST'), 'CLEARING_CREATE_REQUEST');

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error($e->getMessage());
        }
        \DB::commit();

        return redirect()->route('ie.cash-advances.clear',['cashAdvance'=>$cashAdvanceId]);

    }

    public function clear($cashAdvanceId)
    {
        if(!canEnter('/ie/cash-advances')) {
            return redirect()->back()->withErrors(trans('403'));
        }

        // GET CA DATA
        $cashAdvance = CashAdvance::find($cashAdvanceId);
        if(!$cashAdvance){ abort(404); }
        if(!$cashAdvance->onClearing()){ abort(404); }
        // if(!$cashAdvance->isRelatedUser()){ abort(404); }
        $parent = $cashAdvance;
        $orgId = $cashAdvance->org_id;

        $cashAdvance->request_date = dateFormatDisplay($cashAdvance->request_date);
        $cashAdvance->gl_date = dateFormatDisplay($cashAdvance->gl_date);
        $cashAdvance->clearing_request_date = dateFormatDisplay($cashAdvance->clearing_request_date);
        $cashAdvance->clearing_gl_date = dateFormatDisplay($cashAdvance->clearing_gl_date);
        $cashAdvance->need_by_date = dateFormatDisplay($cashAdvance->need_by_date);
        $cashAdvance->due_date = dateFormatDisplay($cashAdvance->due_date);
        // GET ACTIVITY LOG
        $activityLogs = $cashAdvance->activityLogs;

        // GET LIST DATA (CHANGE WHEN CONNECT ORACLE)
        $currencyLists = Currency::pluck('currency_code','currency_code')->all();
        $CACategoryLists = Category::active()
            ->where(function ($query) {
                return $query->whereHas('subCategories', function($q){
                    $q->where('use_in_ca', true);
                });
            })
            ->pluck('name','category_id')
            ->all();

        $requester = $cashAdvance->requester->user;

        $bankLists = $requester->userAccounts()
            ->select(\DB::raw("bank_name AS full_description"),'bank_name')
            ->orderBy('bank_name')
            ->pluck('full_description','bank_name')
            ->all();
        
        $defaultBank = $cashAdvance->bank_name;
        $accountLists = $requester->userAccounts;
        $defaultAccountNo = $cashAdvance->account_no;

        $oracleUserName = $requester->fndUser ? $requester->fndUser->user_name : null;
        $hrDepartmant = $requester->hrEmp ? $requester->hrEmp->dept_code_account : null;
        $webDepartmentCode = $requester->department_code;

        // GET PENDING TRASACTION
        $pendingRequestLists = RequestRepo::getPendingOverLimitRequest($cashAdvance->requester_id);

        // CASH-ADVANCE INFOMATIONS
        $cashAdvanceInfos = CashAdvanceInfo::where('cash_advance_id',$cashAdvance->cash_advance_id)->get();

        // DATA FOR RECEIPT
        $receiptType = 'CLEARING';
        $receipts = $cashAdvance->receipts()->processType($receiptType)->get();
        $receiptParentId = $cashAdvanceId;
        $categoryLists = Category::active()->pluck('name','category_id')->all();
        $parentCurrencyId = $cashAdvance->currency_id;
        // change in production when set location establishment

        $ouLists = HrOperatingUnit::select(\DB::raw("name AS full_description"),'organization_id')
            ->orderBy('organization_id')
            ->pluck('full_description','organization_id')
            ->all();

        // DIFF
        $diffCAAndClearingData = self::calDiffCAAndClearing($cashAdvance);
        $defaultSupplierId = $cashAdvance->vendor_id;
        $defaultSupplierSiteId = $cashAdvance->vendor_site_id;
        $APPaymentTerms = APPaymentTerm::all();

        return view('ie.cash-advances.clear', compact(
            'cashAdvance',
            // 'currency',
            'parent',
            'requester',
            'accountLists',
            'defaultAccountNo',
            'currencyLists',
            'CACategoryLists',
            'cashAdvanceInfos',
            'categoryLists',
            'parentCurrencyId',
            'activityLogs',
            'receipts',
            'receiptParentId',
            'receiptType',
            'ouLists',
            'diffCAAndClearingData',
            'defaultSupplierId',
            'defaultSupplierSiteId',
            'pendingRequestLists',
            'APPaymentTerms'
        ));
    }

    public function getSubCategories(Request $request)
    {
        $caCategoryId = $request->ca_category_id;
        if($caCategoryId){
            $CASubCategoryLists = SubCategory::where('category_id', $caCategoryId)
                ->active()
                ->where('use_in_ca', true)
                ->onDateActive()
                ->pluck('name','sub_category_id')
                ->all();
        }else{
            $CASubCategoryLists = [];
        }

        return view('ie.cash-advances._ddl_sub_categories',compact('CASubCategoryLists'));
    }

    public function getInputFormInformations(Request $request, $caSubCategoryId)
    {
        // $CASubCategoryInfos = CASubCategoryInfo::where('ca_sub_category_id',$caSubCategoryId)
        //     ->active()
        //     ->get();
        $CASubCategoryInfos = SubCategoryInfo::where('sub_category_id',$caSubCategoryId)
            ->active()
            ->get();

        return view('ie.cash-advances._form_informations',compact('CASubCategoryInfos'));
    }

    public function setStatus(Request $request, $cashAdvanceId)
    {
        set_time_limit(0);

        if(!canEnter('/ie/cash-advances')) {
            return redirect()->back()->withErrors(trans('403'));
        }

        // PARAMETER FOR SET STATUS
        $type = $request->type; // CASH-ADVANCE, CLEARING
        $activity = $request->activity;
        $reason = ''; // REASON WILL SHOW IN ACIVITY LOG DESCTIPRION
        $msg = null;
        if($request->reason){
            $reason = $request->reason;
        }

        // Get CA Header Data
        $cashAdvance = CashAdvance::find($cashAdvanceId);
        
        if($request->prepay_apply_date){
            $prepay_apply_date = \DateTime::createFromFormat(trans('date.format'), $request->prepay_apply_date)->format('Y-m-d');
            $clearing_gl_date = Carbon::parse($cashAdvance->clearing_gl_date)->format('Y-m-d');
            if($prepay_apply_date < $clearing_gl_date){
                return redirect()->back()->withErrors('วันที่ Apply Date น้อยกว่าวันที่ GL Date');
            }
        }

        $cashAdvance->last_updated_by = \Auth::user()->user_id;
        $orgId = $cashAdvance->org_id;

        // FILE ATTACHMENTS
        if($request->file('file')){
            $attachmentRepo = new AttachmentRepo;
            $attachmentRepo->create($cashAdvance, $request->file('file'));
        }

        // Check Permission for Approve
        if(!self::hasPermissionSetStatus($cashAdvance,$activity)){ abort(403); }

        \DB::beginTransaction();
        try {
            // Set STATUS (approve,reject,sendback)
            switch ($activity) {

                // #### CA REQUEST ####
                case "UNBLOCK":
                    $msg = 'Unblock Success';
                    $cashAdvance->status = 'NEW_REQUEST';
                    $cashAdvance->save();
                    break;
                case "SEND_REQUEST":
                    // SET OVER BUDGET & EXCEED POLICY
                    $msg = 'Send Request Success';
                    $resultOverBudget = RequestRepo::validateIsNotOverBudget($cashAdvance, 'CASH-ADVANCE');
                    $resultExceedPolicy = RequestRepo::validateIsNotExceedPolicy($cashAdvance);
                    $cashAdvance->over_budget = !$resultOverBudget['valid'];
                    $cashAdvance->exceed_policy = !$resultExceedPolicy['valid'];
                    $cashAdvance->save();
                    if($request->setRecordNum){
                        foreach($request->setRecordNum as $caId => $data){
                            $ca = CashAdvance::find($caId);
                            $ca->record_number = $data;
                            $ca->save();
                        }
                    }
                    // INTERFACE ENCUMBRANCE 
                    if( $cashAdvance->encumbrance_flag != 'Y'){
                        $batchNo = InterfaceRepo::encumbrance($cashAdvance, 'CASH-ADVANCE', 'reserve');
                        $result = InterfaceRepo::submitEncumbrance($batchNo);
                        if($result['status'] == 'C'){
                            $cashAdvance->encumbrance_flag = 'Y';
                        }else {
                            \DB::rollBack();
                            $error_msg = optional(InterfaceEncumbrance::where('interface_status', 'E')
                                ->where('batch_no', $batchNo)
                                ->first())->interface_message ?? ($result['message'] ?? 'Encumbrance Error !');
                            return redirect()->back()->withErrors($error_msg);
                        }
                    }
                    // CHECK FOUND APPROVER OR NOT ?
                    $cashAdvance->hierarchy_name_id = $request->hierarchy_name_id;
                    $nextApprover = ApprovalRepo::getNextApprover($cashAdvance,'CASH-ADVANCE');
                    if($nextApprover){ // IF FOUND NEXT APPROVER SET STATUS = 'APPROVER_DECISION'
                        $cashAdvance->status = 'APPROVER_DECISION';
                        $cashAdvance->next_approver_id = $nextApprover['user_id'];
                        $cashAdvance->hierarchy_name_position_id = $nextApprover['hierarchy_name_position_id'];
                    }else{
                        \DB::rollBack();
                        return redirect()->back()->withErrors('ไม่พบสายอนุมัติ');
                        // $cashAdvance->invoice_no = $cashAdvance->invoice_no ?? CashAdvance::genInvoiceNo($orgId, $cashAdvance->vendor_id, $cashAdvance->advance_type, 'CASH-ADVANCE', null, $cashAdvance->gl_date);
                        // // INTERFACE TO ORACLE AP PRE-PAYMENT
                        // $interfaceHeaderId = InterfaceRepo::prePayment($cashAdvance,'CASH-ADVANCE');
                        // $result = InterfaceRepo::submitInterface($interfaceHeaderId);
                        // if($result['status'] == 'C'){
                        //     $cashAdvance->status = 'APPROVED';
                        //     $msg = 'Approve Success';
                        // }else {
                        //     \DB::rollBack();
                        //     $error_msg = optional(InterfaceAPHeader::where('interface_status', 'E')
                        //         ->where('interface_ap_header_id', $interfaceHeaderId)
                        //         ->first())->interface_message ?? $result['message'];
                        //     return redirect()->back()->withErrors($error_msg);
                        // }
                        // $cashAdvance->next_approver_id = null;
                        // $cashAdvance->hierarchy_name_position_id = null;
                        // $cashAdvance->hierarchy_name_id = null;
                    }
                    $cashAdvance->save();
                    break;
                case "APPROVER_APPROVE":
                    // DO APPROVE PROCESS
                    $msg = 'Approve Success';
                    $approvalRepo = new ApprovalRepo;
                    $approvalRepo->approve($cashAdvance,'CASH-ADVANCE','APPROVER');
                    // CHECK FOUND NEXT APPROVER OR NOT ?
                    $nextApprover = ApprovalRepo::getNextApprover($cashAdvance,'CASH-ADVANCE');
                    if($nextApprover){ // IF FOUND NEXT APPROVER SET NEXT APPROVER
                        $cashAdvance->next_approver_id = $nextApprover['user_id'];
                        $cashAdvance->hierarchy_name_position_id = $nextApprover['hierarchy_name_position_id'];
                    }else{
                        $cashAdvance->invoice_no = $cashAdvance->invoice_no ?? CashAdvance::genInvoiceNo($orgId, $cashAdvance->vendor_id, $cashAdvance->advance_type, 'CASH-ADVANCE', null, $cashAdvance->gl_date);
                        // INTERFACE TO ORACLE AP PRE-PAYMENT
                        $interfaceHeaderId = InterfaceRepo::prePayment($cashAdvance,'CASH-ADVANCE');
                        $result = InterfaceRepo::submitInterface($interfaceHeaderId);
                        if($result['status'] == 'C'){
                            $cashAdvance->status = 'APPROVED';
                        }else {
                            \DB::rollBack();
                            $error_msg = optional(InterfaceAPHeader::where('interface_status', 'E')
                                ->where('interface_ap_header_id', $interfaceHeaderId)
                                ->first())->interface_message ?? $result['message'];
                            return redirect()->back()->withErrors($error_msg);
                        }
                        $cashAdvance->next_approver_id = null;
                        $cashAdvance->hierarchy_name_position_id = null;
                        $cashAdvance->hierarchy_name_id = null;
                    }
                    $cashAdvance->save();
                    break;
                case "APPROVER_SENDBACK":
                    $msg = 'Send Back Success';
                    if( $cashAdvance->encumbrance_flag == 'Y'){
                        $batchNo = InterfaceRepo::encumbrance($cashAdvance, 'CASH-ADVANCE', 'return');
                        $result = InterfaceRepo::submitEncumbrance($batchNo);
                        if($result['status'] == 'C'){
                            $cashAdvance->encumbrance_flag = 'N';
                        }else {
                            \DB::rollBack();
                            $error_msg = optional(InterfaceEncumbrance::where('interface_status', 'E')
                                ->where('batch_no', $batchNo)
                                ->first())->interface_message ?? ($result['message'] ?? 'Encumbrance Error !');
                            return redirect()->back()->withErrors($error_msg);
                        }
                    }
                    // SET STATUS BACK TO 'NEW_REQUEST'
                    $cashAdvance->status = 'NEW_REQUEST';
                    $cashAdvance->next_approver_id = null;
                    $cashAdvance->hierarchy_name_position_id = null;
                    $cashAdvance->hierarchy_name_id = null;
                    $cashAdvance->save();
                    break;
                case "APPROVER_REJECT":
                    $msg = 'Reject Success';
                    if( $cashAdvance->encumbrance_flag == 'Y'){
                        $batchNo = InterfaceRepo::encumbrance($cashAdvance, 'CASH-ADVANCE', 'return');
                        $result = InterfaceRepo::submitEncumbrance($batchNo);
                        if($result['status'] == 'C'){
                            $cashAdvance->encumbrance_flag = 'N';
                        }else {
                            \DB::rollBack();
                            $error_msg = optional(InterfaceEncumbrance::where('interface_status', 'E')
                                ->where('batch_no', $batchNo)
                                ->first())->interface_message ?? ($result['message'] ?? 'Encumbrance Error !');
                            return redirect()->back()->withErrors($error_msg);
                        }
                    }
                    $cashAdvance->status = 'APPROVER_REJECTED';
                    $cashAdvance->next_approver_id = null;
                    $cashAdvance->hierarchy_name_position_id = null;
                    $cashAdvance->hierarchy_name_id = null;
                    $cashAdvance->save();
                    break;
                case "FINANCE_APPROVE":
                    // SET STATUS TO 'APPROVED'
                    $msg = 'Approve Success';
                    $cashAdvance->invoice_no = $cashAdvance->invoice_no ?? CashAdvance::genInvoiceNo($orgId, $cashAdvance->vendor_id, $cashAdvance->advance_type, 'CASH-ADVANCE', null, $cashAdvance->gl_date);
                    // INTERFACE TO ORACLE AP PRE-PAYMENT
                    // $interfaceResult = InterfaceRepo::prePayment($cashAdvance,'CASH-ADVANCE');
                    $interfaceHeaderId = InterfaceRepo::prePayment($cashAdvance,'CASH-ADVANCE'); // it's ok
                    $result = InterfaceRepo::submitInterface($interfaceHeaderId);
                    if($result['status'] == 'C'){
                        // DO FINANCE APPROVE PROCESS
                        $approvalRepo = new ApprovalRepo;
                        $approvalRepo->approve($cashAdvance,'CASH-ADVANCE','FINANCE');
                    }else {
                        \DB::rollBack();
                        $error_msg = optional(InterfaceAPHeader::where('interface_status', 'E')
                            ->where('interface_ap_header_id', $interfaceHeaderId)
                            ->first())->interface_message ?? $result['message'];
                        return redirect()->back()->withErrors($error_msg);
                    }
                    $cashAdvance->status = 'APPROVED';
                    $cashAdvance->save();
                    break;
                case "FINANCE_SENDBACK":
                    $msg = 'Send Back Success';
                    // SET STATUS BACK TO 'NEW_REQUEST'
                    if( $cashAdvance->encumbrance_flag == 'Y'){
                        $batchNo = InterfaceRepo::encumbrance($cashAdvance, 'CASH-ADVANCE', 'return');
                        $result = InterfaceRepo::submitEncumbrance($batchNo);
                        if($result['status'] == 'C'){
                            $cashAdvance->encumbrance_flag = 'N';
                        }else {
                            \DB::rollBack();
                            $error_msg = optional(InterfaceEncumbrance::where('interface_status', 'E')
                                ->where('batch_no', $batchNo)
                                ->first())->interface_message ?? ($result['message'] ?? 'Encumbrance Error !');
                            return redirect()->back()->withErrors($error_msg);
                        }
                    }
                    $cashAdvance->status = 'NEW_REQUEST';
                    $cashAdvance->next_approver_id = null;
                    $cashAdvance->finance_approver_id = null;
                    $cashAdvance->save();
                    break;
                case "FINANCE_REJECT":
                    $msg = 'Reject Success';
                    if( $cashAdvance->encumbrance_flag == 'Y'){
                        $batchNo = InterfaceRepo::encumbrance($cashAdvance, 'CASH-ADVANCE', 'return');
                        $result = InterfaceRepo::submitEncumbrance($batchNo);
                        if($result['status'] == 'C'){
                            $cashAdvance->encumbrance_flag = 'N';
                        }else {
                            \DB::rollBack();
                            $error_msg = optional(InterfaceEncumbrance::where('interface_status', 'E')
                                ->where('batch_no', $batchNo)
                                ->first())->interface_message ?? ($result['message'] ?? 'Encumbrance Error !');
                            return redirect()->back()->withErrors($error_msg);
                        }
                    }
                    $cashAdvance->status = 'FINANCE_REJECTED';
                    $cashAdvance->save();
                    break;
                case "CLEARING_SEND_REQUEST":
                    $msg = 'Send Request Success';
                    // SET OVER BUDGET & EXCEED POLICY
                    $resultOverBudget = RequestRepo::validateIsNotOverBudget($cashAdvance, 'CLEARING');
                    $resultExceedPolicy = RequestRepo::validateIsNotExceedPolicy($cashAdvance);
                    $cashAdvance->over_budget = !$resultOverBudget['valid'];
                    $cashAdvance->exceed_policy = !$resultExceedPolicy['valid'];
                    $cashAdvance->save();

                    if($request->setRecordNum){
                        foreach($request->setRecordNum as $caId => $data){
                            $ca = CashAdvance::find($caId);
                            $ca->record_number = $data;
                            $ca->save();
                        }
                    }

                    // CHECK CL OVER CA
                    // $cashAdvancePrimaryAmount = (float)$cashAdvance->primary_amount;
                    // $clearingPrimaryAmount = (float)$cashAdvance->total_receipt_primary_amount;
                    // $diffAmount = (float)$cashAdvancePrimaryAmount - (float)$clearingPrimaryAmount;
                    // if( (float)$cashAdvancePrimaryAmount > (float)$clearingPrimaryAmount ){
                        // INTERFACE TO ORACLE AP INVOICE
                        if( $cashAdvance->encumbrance_flag == 'Y'){
                            $batchNo = InterfaceRepo::encumbrance($cashAdvance, 'CASH-ADVANCE', 'return');
                            $result = InterfaceRepo::submitEncumbrance($batchNo);
                            if($result['status'] == 'C'){
                                $cashAdvance->encumbrance_flag = 'N';
                                $cashAdvance->save();
                                \DB::commit();
                            }else {
                                \DB::rollBack();
                                $error_msg = optional(InterfaceEncumbrance::where('interface_status', 'E')
                                    ->where('batch_no', $batchNo)
                                    ->first())->interface_message ?? ($result['message'] ?? 'Encumbrance Error !');
                                return redirect()->back()->withErrors($error_msg);
                            }
                        }
                        if( $cashAdvance->encumbrance_flag != 'Y'){
                            $batchNo = InterfaceRepo::encumbrance($cashAdvance, 'CLEARING', 'reserve');
                            $result = InterfaceRepo::submitEncumbrance($batchNo);
                            if($result['status'] == 'C'){
                                $cashAdvance->encumbrance_flag = 'Y';
                                $cashAdvance->save();
                                \DB::commit();
                            }else {
                                \DB::rollBack();
                                $error_msg = optional(InterfaceEncumbrance::where('interface_status', 'E')
                                    ->where('batch_no', $batchNo)
                                    ->first())->interface_message ?? ($result['message'] ?? 'Encumbrance Error !');
                                return redirect()->back()->withErrors($error_msg);
                            }
                        }
                    // }

                    // CHECK FOUND NEXT APPROVER OR NOT ?
                    $cashAdvance->hierarchy_name_id = $request->hierarchy_name_id;
                    $nextApprover = ApprovalRepo::getNextApprover($cashAdvance,'CLEARING');
                    if($nextApprover){ // IF FOUND NEXT APPROVER SET STATUS = 'CLEARING_APPROVER_DECISION'
                        $cashAdvance->status = 'CLEARING_APPROVER_DECISION';
                        $cashAdvance->next_clearing_approver_id = $nextApprover['user_id'];
                        $cashAdvance->hierarchy_name_position_id = $nextApprover['hierarchy_name_position_id'];
                    }else{
                        \DB::rollBack();
                        return redirect()->back()->withErrors('ไม่พบสายอนุมัติ');
                        // if( $cashAdvance->encumbrance_flag == 'Y'){
                        //     $batchNo = InterfaceRepo::encumbrance($cashAdvance, 'CLEARING', 'return');
                        //     $result = InterfaceRepo::submitEncumbrance($batchNo);
                        //     if($result['status'] == 'C'){
                        //         $cashAdvance->encumbrance_flag = 'N';
                        //         $cashAdvance->save();
                        //         \DB::commit();
                        //     }else {
                        //         \DB::rollBack();
                        //         $error_msg = optional(InterfaceEncumbrance::where('interface_status', 'E')
                        //             ->where('batch_no', $batchNo)
                        //             ->first())->interface_message ?? $result['message'];
                        //         return redirect()->back()->withErrors($error_msg);
                        //     }
                        // }
                        // $cashAdvance->clearing_invoice_no = $cashAdvance->clearing_invoice_no ?? ($cashAdvance->apply ? CashAdvance::genInvoiceNo($orgId, $cashAdvance->vendor_id, $cashAdvance->advance_type, 'CLEARING', $cashAdvance->last_apply, $cashAdvance->gl_date) : 'C'.$cashAdvance->invoice_no);
                        // // INTERFACE TO ORACLE AP INVOICE
                        // $interfaceHeaderId = InterfaceRepo::invoice($cashAdvance, 'CLEARING');
                        // $result = InterfaceRepo::submitInterface($interfaceHeaderId);
                        // if($result['status'] == 'C'){
                        //     $cashAdvance->status = 'CLEARED';
                        // }else {
                        //     \DB::rollBack();
                        //     $error_msg = optional(InterfaceAPHeader::where('interface_status', 'E')
                        //         ->where('interface_ap_header_id', $interfaceHeaderId)
                        //         ->first())->interface_message ?? $result['message'];
                        //     return redirect()->back()->withErrors($error_msg);
                        // }
                        // $cashAdvance->next_clearing_approver_id = null;
                        // $cashAdvance->hierarchy_name_position_id = null;
                        // $cashAdvance->hierarchy_name_id = null;
                    }
                    $cashAdvance->save();
                    break;
                case "CLEARING_APPROVER_APPROVE":
                    $msg = 'Approve Success';
                    // DO APPROVE PROCESS
                    $approvalRepo = new ApprovalRepo;
                    $approvalRepo->approve($cashAdvance,'CLEARING','APPROVER');
                    // CHECK FOUND NEXT APPROVER OR NOT ?
                    $nextApprover = ApprovalRepo::getNextApprover($cashAdvance,'CLEARING');
                    if($nextApprover){ // IF FOUND NEXT APPROVER SET NEXT APPROVER
                        $cashAdvance->next_clearing_approver_id = $nextApprover['user_id'];
                        $cashAdvance->hierarchy_name_position_id = $nextApprover['hierarchy_name_position_id'];
                    }else{

                        /// Set Apply Date
                        $cashAdvance->prepay_apply_date = $prepay_apply_date ?? Carbon::parse($cashAdvance->clearing_gl_date)->format('Y-m-d');

                        if( $cashAdvance->encumbrance_flag == 'Y'){
                            $batchNo = InterfaceRepo::encumbrance($cashAdvance, 'CLEARING', 'return');
                            $result = InterfaceRepo::submitEncumbrance($batchNo);
                            if($result['status'] == 'C'){
                                $cashAdvance->encumbrance_flag = 'N';
                                $cashAdvance->save();
                                \DB::commit();
                            }else {
                                \DB::rollBack();
                                $error_msg = optional(InterfaceEncumbrance::where('interface_status', 'E')
                                    ->where('batch_no', $batchNo)
                                    ->first())->interface_message ?? ($result['message'] ?? 'Encumbrance Error !');
                                return redirect()->back()->withErrors($error_msg);
                            }
                        }
                        $cashAdvance->clearing_invoice_no = $cashAdvance->clearing_invoice_no ?? ($cashAdvance->apply ? CashAdvance::genInvoiceNo($orgId, $cashAdvance->vendor_id, $cashAdvance->advance_type, 'CLEARING', $cashAdvance->last_apply, $cashAdvance->gl_date) : 'C'.$cashAdvance->invoice_no);
                        // INTERFACE TO ORACLE AP INVOICE
                        $interfaceHeaderId = InterfaceRepo::invoice($cashAdvance, 'CLEARING');
                        $result = InterfaceRepo::submitInterface($interfaceHeaderId);
                        if($result['status'] == 'C'){
                            $cashAdvance->status = 'CLEARED';
                        }else {
                            \DB::rollBack();
                            $error_msg = optional(InterfaceAPHeader::where('interface_status', 'E')
                                ->where('interface_ap_header_id', $interfaceHeaderId)
                                ->first())->interface_message ?? $result['message'];
                            return redirect()->back()->withErrors($error_msg);
                        }
                        $cashAdvance->next_clearing_approver_id = null;
                        $cashAdvance->hierarchy_name_position_id = null;
                        $cashAdvance->hierarchy_name_id = null;
                    }
                    $cashAdvance->save();
                    break;
                case "CLEARING_APPROVER_SENDBACK":
                    $msg = 'Send Back Success';
                    // SET STATUS BACK TO 'CLEARING_REQUEST'
                    if( $cashAdvance->encumbrance_flag == 'Y'){
                        $batchNo = InterfaceRepo::encumbrance($cashAdvance, 'CLEARING', 'return');
                        $result = InterfaceRepo::submitEncumbrance($batchNo);
                        if($result['status'] == 'C'){
                            $cashAdvance->encumbrance_flag = 'N';
                            $cashAdvance->save();
                            \DB::commit();
                        }else {
                            \DB::rollBack();
                            $error_msg = optional(InterfaceEncumbrance::where('interface_status', 'E')
                                ->where('batch_no', $batchNo)
                                ->first())->interface_message ?? ($result['message'] ?? 'Encumbrance Error !');
                            return redirect()->back()->withErrors($error_msg);
                        }
                    }
                    if( $cashAdvance->encumbrance_flag != 'Y'){
                        $batchNo = InterfaceRepo::encumbrance($cashAdvance, 'CASH-ADVANCE', 'reserve');
                        $result = InterfaceRepo::submitEncumbrance($batchNo);
                        if($result['status'] == 'C'){
                            $cashAdvance->encumbrance_flag = 'Y';
                        }else {
                            \DB::rollBack();
                            $error_msg = optional(InterfaceEncumbrance::where('interface_status', 'E')
                                ->where('batch_no', $batchNo)
                                ->first())->interface_message ?? ($result['message'] ?? 'Encumbrance Error !');
                            return redirect()->back()->withErrors($error_msg);
                        }
                    }
                    $cashAdvance->status = 'CLEARING_REQUEST';
                    $cashAdvance->next_clearing_approver_id = null;
                    $cashAdvance->hierarchy_name_position_id = null;
                    $cashAdvance->hierarchy_name_id = null;
                    $cashAdvance->over_budget = null;
                    $cashAdvance->exceed_policy = null;
                    $cashAdvance->save();
                    break;
                case "CLEARING_FINANCE_APPROVE":
                    $msg = 'Approve Success';
                    if( $cashAdvance->encumbrance_flag == 'Y'){
                        $batchNo = InterfaceRepo::encumbrance($cashAdvance, 'CLEARING', 'return');
                        $result = InterfaceRepo::submitEncumbrance($batchNo);
                        if($result['status'] == 'C'){
                            $cashAdvance->encumbrance_flag = 'N';
                            $cashAdvance->save();
                            \DB::commit();
                        }else {
                            \DB::rollBack();
                            $error_msg = optional(InterfaceEncumbrance::where('interface_status', 'E')
                                ->where('batch_no', $batchNo)
                                ->first())->interface_message ?? ($result['message'] ?? 'Encumbrance Error !');
                            return redirect()->back()->withErrors($error_msg);
                        }
                    }
                    $cashAdvance->clearing_invoice_no = $cashAdvance->clearing_invoice_no ?? ($cashAdvance->apply ? CashAdvance::genInvoiceNo($orgId, $cashAdvance->vendor_id, $cashAdvance->advance_type, 'CLEARING', $cashAdvance->last_apply, $cashAdvance->gl_date) : 'C'.$cashAdvance->invoice_no);
                    // INTERFACE TO ORACLE AP INVOICE
                    $interfaceHeaderId = InterfaceRepo::invoice($cashAdvance, 'CLEARING');
                    $result = InterfaceRepo::submitInterface($interfaceHeaderId);
                    if($result['status'] == 'C'){
                        // DO CLEARING FINANCE APPROVE PROCESS
                        $approvalRepo = new ApprovalRepo;
                        $approvalRepo->approve($cashAdvance,'CLEARING','FINANCE');
                        // SET STATUS TO 'CLEARED'
                        $cashAdvance->status = 'CLEARED';
                    }else {
                        \DB::rollBack();
                        $error_msg = optional(InterfaceAPHeader::where('interface_status', 'E')
                            ->where('interface_ap_header_id', $interfaceHeaderId)
                            ->first())->interface_message ?? $result['message'];
                        return redirect()->back()->withErrors($error_msg);
                    }
                    $cashAdvance->save();
                    break;
                case "CLEARING_FINANCE_SENDBACK":
                    $msg = 'Send Back Success';
                    // SET STATUS BACK TO 'CLEARING_REQUEST'
                    if( $cashAdvance->encumbrance_flag == 'Y'){
                        $batchNo = InterfaceRepo::encumbrance($cashAdvance, 'CLEARING', 'return');
                        $result = InterfaceRepo::submitEncumbrance($batchNo);
                        if($result['status'] == 'C'){
                            $cashAdvance->encumbrance_flag = 'N';
                            $cashAdvance->save();
                            \DB::commit();
                        }else {
                            \DB::rollBack();
                            $error_msg = optional(InterfaceEncumbrance::where('interface_status', 'E')
                                ->where('batch_no', $batchNo)
                                ->first())->interface_message ?? ($result['message'] ?? 'Encumbrance Error !');
                            return redirect()->back()->withErrors($error_msg);
                        }
                    }
                    if( $cashAdvance->encumbrance_flag != 'Y'){
                        $batchNo = InterfaceRepo::encumbrance($cashAdvance, 'CASH-ADVANCE', 'reserve');
                        $result = InterfaceRepo::submitEncumbrance($batchNo);
                        if($result['status'] == 'C'){
                            $cashAdvance->encumbrance_flag = 'Y';
                        }else {
                            \DB::rollBack();
                            $error_msg = optional(InterfaceEncumbrance::where('interface_status', 'E')
                                ->where('batch_no', $batchNo)
                                ->first())->interface_message ?? ($result['message'] ?? 'Encumbrance Error !');
                            return redirect()->back()->withErrors($error_msg);
                        }
                    }
                    $cashAdvance->status = 'CLEARING_REQUEST';
                    $cashAdvance->next_clearing_approver_id = null;
                    $cashAdvance->clearing_finance_approver_id = null;
                    $cashAdvance->over_budget = null;
                    $cashAdvance->exceed_policy = null;
                    $cashAdvance->save();
                    break;
                case "CANCEL_REQUEST":
                    $msg = 'Cancel Success';
                    // SET STATUS TO 'CANCELLED'
                    $cashAdvance->status = 'CANCELLED';
                    $cashAdvance->save();
                    break;
            }

            // SEND EMAIL
            // self::sendEmailByActivity($activity,$cashAdvance,$reason);

            // RESET APPROVAL (ACTIVITY SENDBACK ONLY)
            self::resetApproval($activity,$cashAdvance);

            // ACTIVITY LOG
            $activity_msg = ActivityLogRepo::getActivityMessage($activity,$cashAdvance) . ($request->prepay_apply_date ? ' Apply Date '.\DateTime::createFromFormat(trans('date.format'), $request->prepay_apply_date)->format('d-m-Y') : '');
            $activityLogRepo = new ActivityLogRepo;
            $activityLogRepo->create($cashAdvance, $activity_msg, $activity, $reason);

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error($e->getMessage());

            if($type == 'CASH-ADVANCE'){
                return redirect()->route('ie.cash-advances.show',['cashAdvance'=>$cashAdvanceId])->withErrors([$e->getMessage()]);;
            }else{ // CLEARING
                return redirect()->route('ie.cash-advances.clear',['cashAdvance'=>$cashAdvanceId])->withErrors([$e->getMessage()]);;
            }
        }
        \DB::commit();

        // REDIRECT AFTER SET STATUS
        if($type == 'CASH-ADVANCE'){
            return redirect()->route('ie.cash-advances.show',['cashAdvance'=>$cashAdvanceId])->with('success', $msg);
        }else{ // CLEARING
            return redirect()->route('ie.cash-advances.clear',['cashAdvance'=>$cashAdvanceId])->with('success', $msg);
        }
    }

    ////////////////////////////
    //// SET DUE DATE
    public function setDueDate(SetDueDateRequest $request, $cashAdvanceId)
    {
        if(!canEnter('/ie/cash-advances')) {
            return redirect()->back()->withErrors(trans('403'));
        }

        $cashAdvance = CashAdvance::find($cashAdvanceId);

        \DB::beginTransaction();
        try {
            // SET DUE DATE
            if($request->due_date){

                $cashAdvance->due_date = \DateTime::createFromFormat(trans('date.format'), $request->due_date)->format('Y-m-d');
                $cashAdvance->payment_method_id = $request->payment_method_id;
                $cashAdvance->payment_term_id = $request->payment_term_id;

            }else{
                $cashAdvance->due_date = null;
            }
            $cashAdvance->last_updated_by = \Auth::user()->user_id;
            $cashAdvance->save();

             // ACTIVITY LOG
            $activityLogRepo = new ActivityLogRepo;
            $activityLogRepo->create($cashAdvance, ActivityLogRepo::getActivityMessage('SET_DUE_DATE'), 'SET_DUE_DATE');

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error($e->getMessage());
        }
        \DB::commit();

        return redirect()->route('ie.cash-advances.show',['cashAdvance'=>$cashAdvanceId]);
    }

    ///////////////////////////
    ///// ADD ATTACHMENT
    public function addAttachment(Request $request, $cashAdvanceId)
    {
        if(!canEnter('/ie/cash-advances')) {
            return redirect()->back()->withErrors(trans('403'));
        }

        $cashAdvance = CashAdvance::find($cashAdvanceId);

        \DB::beginTransaction();
        try {
            // ADD FILE ATTACHMENT
            if($request->file('file')){
                $attachmentRepo = new AttachmentRepo;
                $attachmentRepo->create($cashAdvance, $request->file('file'));
            }

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error($e->getMessage());
        }
        \DB::commit();

        return redirect()->back();
    }

    //////////////////////////
    //// CHECK CA ATTACHMENT
    public function checkCAAttachment(Request $request, $cashAdvanceId)
    {
        $valid = false;
        $cashAdvance = CashAdvance::find($cashAdvanceId);
        if($cashAdvance){
            // IF NOT REQUIRED ATTACHMENT
            if(!$cashAdvance->subCategory->required_attachment){
                $valid = true;
            }else{
                // IF ALREADY ATTACH FILE
                if(count($cashAdvance->attachments) > 0){
                    $valid = true;
                }
            }
        }
        if($request->ajax()){
            return \Response::json(['valid'=>$valid], 200);
        }else{
            return $valid;
        }
    }

    //////////////////////////
    //// CHECK CA MIN AMOUNT
    public function checkCAMinAmount(Request $request, $cashAdvanceId)
    {
        $valid = false;
        $cashAdvance = CashAdvance::find($cashAdvanceId);
        if($cashAdvance){
            // IF NOT CHECK MIN AMOUNT
            if(!$cashAdvance->subCategory->check_ca_min){
                $valid = true;
            }else{
                // IF CHECK AND AMOUNT > MIN AMOUNT
                if((float)$cashAdvance->amount >= (float)$cashAdvance->subCategory->ca_min_amount) {
                    $valid = true;
                }
            }
        }
        if($request->ajax()){
            return \Response::json(['valid'=>$valid,'ca_min_amount'=>$cashAdvance->subCategory->ca_min_amount], 200);
        }else{
            return $valid;
        }
    }

    //////////////////////////
    //// CHECK CA MAX AMOUNT
    public function checkCAMaxAmount(Request $request, $cashAdvanceId)
    {
        $valid = false;
        $cashAdvance = CashAdvance::find($cashAdvanceId);
        if($cashAdvance){
            // IF NOT CHECK MAX AMOUNT
            if(!$cashAdvance->subCategory->check_ca_max){
                $valid = true;
            }else{
                // IF CHECK AND AMOUNT > MAX AMOUNT
                if((float)$cashAdvance->amount <= (float)$cashAdvance->subCategory->ca_max_amount) {
                    $valid = true;
                }
            }
        }
        if($request->ajax()){
            return \Response::json(['valid'=>$valid,'ca_max_amount'=>$cashAdvance->subCategory->ca_max_amount], 200);
        }else{
            return $valid;
        }
    }

    //////////////////////////
    //// GET TOTAL AMOUNT
    public function getTotalAmount(Request $request, $cashAdvanceId)
    {
        $cashAdvance = CashAdvance::find($cashAdvanceId);
        if(!$cashAdvance){ throw new Exception("Error Processing Request", 1); }
        if($request->receipt_type == 'CASH-ADVANCE'){
            $cashAdvance->amount = $cashAdvance->ca_total_receipt_amount;
            $cashAdvance->primary_amount = $cashAdvance->amount * $cashAdvance->exchange_rate;
            $cashAdvance->save();
        }
        $cashAdvanceTotalAmount = $request->receipt_type == 'CASH-ADVANCE' ? $cashAdvance->amount + 0 : $cashAdvance->total_receipt_amount + 0;
        return numberFormatDisplay($cashAdvanceTotalAmount);
    }

    /////////////////////////////////////
    //// GET DIFF CA AND CLEARING AMOUNT
    public function getDiffCAAndClearingAmount(Request $request, $cashAdvanceId)
    {
        $cashAdvance = CashAdvance::onStatusClearing()
            ->where('cash_advance_id',$cashAdvanceId)
            ->first();
        if(!$cashAdvance){ throw new Exception("Error Processing Request", 1); }
        $diffCAAndClearingData = self::calDiffCAAndClearing($cashAdvance);
        if(!$diffCAAndClearingData){ throw new Exception("Error Processing Request", 1); }
        return view('ie.cash-advances.clear._diff_ca_and_clearing_amount',compact('cashAdvance','diffCAAndClearingData'));
    }

    /////////////////////////////////////
    //// GET DIFF CA AND CLEARING DATA
    public function getDiffCAAndClearingData(Request $request, $cashAdvanceId)
    {
        $cashAdvance = CashAdvance::onStatusClearing()
            ->where('cash_advance_id',$cashAdvanceId)
            ->first();
        if(!$cashAdvance){ throw new Exception("Error Processing Request", 1); }
        $result = self::calDiffCAAndClearing($cashAdvance);
        if(!$result){ throw new Exception("Error Processing Request", 1); }
        $result['amount'] = number_format($result['amount'],2);

        if($request->ajax()){
            return \Response::json($result, 200);
        }else{
            return redirect()->back();
        }
    }

    ////////////////////////////////////////
    // CALCULATE DIFF CA & CLEARING AMOUNT
    private static function calDiffCAAndClearing($cashAdvance)
    {
        $result = [];
        if($cashAdvance->total_receipt_amount){
            if(round((float)$cashAdvance->amount, 2) > round((float)$cashAdvance->total_receipt_amount, 2)){
                $result['type'] = 'paybacktocompany';
                $result['amount'] = round((float)$cashAdvance->amount, 2) - round((float)$cashAdvance->total_receipt_amount, 2);
            }elseif(round((float)$cashAdvance->amount, 2) < round((float)$cashAdvance->total_receipt_amount, 2)){
                $result['type'] = 'paybacktorequester';
                $result['amount'] = round((float)$cashAdvance->total_receipt_amount, 2) - round((float)$cashAdvance->amount, 2);
            }else{ // CASHADVANCE == CLEARING
                $result['type'] = 'normal';
                $result['amount'] = 0;
            }
        }else{
            $result['type'] = 'paybacktocompany';
            $result['amount'] = $cashAdvance->amount;
        }
        return $result;
    }

    //////////////////////////////////
    //// COMBINE GL CODE COMBINATION
    public function combineReceiptGLCodeCombination(Request $request, $cashAdvanceId)
    {
        try {

            $cashAdvance = CashAdvance::find($cashAdvanceId);
            if(!$cashAdvance){
                throw new \Exception("Not found cash advance data.", 1);
            }
            // $result = RequestRepo::combineReceiptGLCodeCombination($cashAdvance);
            $result = ['status'=>'success','err_msg'=>'','err_receipt_line_id'=>null];

        } catch (\Exception $e) {
            if($request->ajax()){
                return \Response::json([
                    'status'                =>  'error',
                    'err_msg'               =>  $e->getMessage(),
                    'err_receipt_line_id'   =>  null], 200);
            }else{
                throw new \Exception($e->getMessage(), 1);
            }
        }

        if($request->ajax()){
            return \Response::json($result, 200);
        }else{
            return redirect()->back();
        }
    }

    //////////////////////////
    //// CHECK OVER BUDGET
    public function checkOverBudget(Request $request, $cashAdvanceId)
    {
        $valid = false;
        $cashAdvance = CashAdvance::find($cashAdvanceId);
        if(!$cashAdvance){
            throw new \Exception("Not found cash advance data.", 1);
        }
        $valid = RequestRepo::validateIsNotOverBudget($cashAdvance, $request->type);

        if($request->ajax()){
            return \Response::json($valid, 200);
        }else{
            return $valid;
        }
    }

    //////////////////////////
    //// CHECK EXCEED POLICY
    public function checkExceedPolicy(Request $request, $cashAdvanceId)
    {
        $cashAdvance = CashAdvance::find($cashAdvanceId);
        if(!$cashAdvance){
            throw new \Exception("Not found cash advance data.", 1);
        }
        $result = RequestRepo::validateIsNotExceedPolicy($cashAdvance);

        if($request->ajax()){
            return \Response::json($result, 200);
        }else{
            return $result;
        }
    }

    //////////////////////////////
    //// validateReceipt
    public function validateReceipt(Request $request, $cashAdvanceId)
    {
        $cashAdvance = CashAdvance::find($cashAdvanceId);
        if(!$cashAdvance){
            throw new \Exception("Not found cash advance data.", 1);
        }
        $result = RequestRepo::validateReceipt($cashAdvance, $request->request_type);

        if($request->ajax()){
            return \Response::json($result, 200);
        }else{
            return $result;
        }
    }

    public function formSendRequestWithReason(Request $request, $cashAdvanceId)
    {
        $title = ''; $headingText = ''; $text = '';
        $cashAdvance = CashAdvance::find($cashAdvanceId);
        if(!$cashAdvance){ return ; }

        $resultOverBudget = RequestRepo::validateIsNotOverBudget($cashAdvance, 'CLEARING');
        $resultExceedPolicy = RequestRepo::validateIsNotExceedPolicy($cashAdvance);
        $notOverBudget = $resultOverBudget['valid'];
        $notExceedPolicy = $resultExceedPolicy['valid'];
        if(!$notOverBudget && !$notExceedPolicy){
            $title = 'Request Over Budget & Exceed Policy !';
            $text = 'please enter reason for request over budget and exceed policy, please contact HR for approval and <strong><u>send the original receipt and supporting document to Finance Dept. (กรุณาส่งเอกสารให้แผนกการเงินเพื่อดำเนินการ)</u></strong>.';
        }elseif(!$notOverBudget){
            $title = 'Request Over Budget !';
            $text = 'please enter reason for request over budget, please contact HR for approval and <strong><u>send the original receipt and supporting document to Finance Dept. (กรุณาส่งเอกสารให้แผนกการเงินเพื่อดำเนินการ)</u></strong>.';
        }elseif(!$notExceedPolicy){
            $title = 'Request Exceed Policy !';
            $text = 'please enter reason for request exceed policy please contact HR for approval and <strong><u>send the original receipt and supporting document to Finance Dept. (กรุณาส่งเอกสารให้แผนกการเงินเพื่อดำเนินการ)</u></strong>.';
        }

        if($cashAdvance->onClearing()){
            $diffCAAndClearingData = self::calDiffCAAndClearing($cashAdvance);
            if($diffCAAndClearingData['type'] == 'paybacktocompany'){
                $headingText = 'Payback to company (ชำระเงินคืนบริษัท) : '.number_format($diffCAAndClearingData['amount'],2).' '.$cashAdvance->currency_id;
            }
        }

        return view('ie.cash-advances.clear._form_send_request_with_reason', compact(
            'cashAdvance',
            'title',
            'headingText',
            'text'
        ));

    }

    private static function hasPermissionSetStatus($cashAdvance,$activity)
    {
        $permit = false;
        switch ($activity) {

            case "UNBLOCK":
                if($cashAdvance->status == 'BLOCKED'
                    && \Auth::user()->isUnblocker()){
                    $permit = true;
                }
                break;
            case "SEND_REQUEST":
                if($cashAdvance->status == 'NEW_REQUEST'){
                    $permit = true;
                }
                break;
            case "APPROVER_APPROVE":
                if($cashAdvance->status == 'APPROVER_DECISION'
                    && $cashAdvance->isNextApprover()){
                    $permit = true;
                }
                break;
            case "APPROVER_SENDBACK":
                if($cashAdvance->status == 'APPROVER_DECISION'
                    && $cashAdvance->isNextApprover()){
                    $permit = true;
                }
                break;
            case "APPROVER_REJECT":
                if($cashAdvance->status == 'APPROVER_DECISION'
                    && $cashAdvance->isNextApprover()){
                    $permit = true;
                }
                break;
            case "FINANCE_APPROVE":
                if($cashAdvance->status == 'FINANCE_PROCESS'
                    && \Auth::user()->isFinance()){
                    $permit = true;
                }
                break;
            case "FINANCE_SENDBACK":
                if($cashAdvance->status == 'FINANCE_PROCESS'
                    && \Auth::user()->isFinance()){
                    $permit = true;
                }
                break;
            case "FINANCE_REJECT":
                if($cashAdvance->status == 'FINANCE_PROCESS'
                    && \Auth::user()->isFinance()){
                    $permit = true;
                }
                break;

            // #### CLEARING REQUEST ####

            case "CLEARING_SEND_REQUEST":
                if($cashAdvance->status == 'CLEARING_REQUEST'){
                    $permit = true;
                }
                break;
            case "CLEARING_APPROVER_APPROVE":
                if($cashAdvance->status == 'CLEARING_APPROVER_DECISION'
                    && $cashAdvance->isNextClearingApprover()){
                    $permit = true;
                }
                break;
            case "CLEARING_APPROVER_SENDBACK":
                if($cashAdvance->status == 'CLEARING_APPROVER_DECISION'
                    && $cashAdvance->isNextClearingApprover()){
                    $permit = true;
                }
                break;
            case "CLEARING_FINANCE_APPROVE":
                if($cashAdvance->status == 'CLEARING_FINANCE_PROCESS'
                    && \Auth::user()->isFinance()){
                    $permit = true;
                }
                break;
            case "CLEARING_FINANCE_SENDBACK":
                if($cashAdvance->status == 'CLEARING_FINANCE_PROCESS'
                    && \Auth::user()->isFinance()){
                    $permit = true;
                }
                break;
            case "CANCEL_REQUEST":
                if(($cashAdvance->status == 'NEW_REQUEST' || $cashAdvance->status == 'BLOCKED')){
                    $permit = true;
                }
                break;

        }
        return $permit;
    }

    private static function resetApproval($activity,$cashAdvance)
    {
        switch ($activity) {
            case "APPROVER_SENDBACK":
                // RESET RECENT APPROVAL PROCESS
                $approvalRepo = new ApprovalRepo;
                $approvalRepo->reset($cashAdvance,'CASH-ADVANCE');
                break;
            case "FINANCE_SENDBACK":
                // RESET RECENT APPROVAL PROCESS
                $approvalRepo = new ApprovalRepo;
                $approvalRepo->reset($cashAdvance,'CASH-ADVANCE');
                break;
            case "CLEARING_APPROVER_SENDBACK":
                // RESET RECENT CLEARING APPROVAL PROCESS
                $approvalRepo = new ApprovalRepo;
                $approvalRepo->reset($cashAdvance,'CLEARING');
                break;
            case "CLEARING_FINANCE_SENDBACK":
                // RESET RECENT CLEARING APPROVAL PROCESS
                $approvalRepo = new ApprovalRepo;
                $approvalRepo->reset($cashAdvance,'CLEARING');
                break;
        }
    }

    private static function sendEmailByActivity($activity,$cashAdvance,$reason)
    {
        $financeUsers = User::active()->isFinance()->get(); // FINANCE
        $composedFinanceUsers = MailRepo::composeReceivers($financeUsers);

        switch ($activity) {

            ///////////////////////
            // #### CA REQUEST ####
            case "UNBLOCK":

                $receivers = MailRepo::composeReceivers($cashAdvance->user); // REQUESTER
                $ccReceivers = MailRepo::composeReceivers($financeUsers); // FINANCE

                MailRepo::unblock('CASH-ADVANCE',$cashAdvance,$receivers,$ccReceivers,$reason);

                break;

            case "SEND_REQUEST":

                $ccReceivers = MailRepo::composeReceivers(\Auth::user()); // REQUESTER
                if($cashAdvance->approver){
                    // IF HAVE APPROVER
                    $receivers = MailRepo::composeReceivers($cashAdvance->approver); // NEXT APPROVER
                    if(count($composedFinanceUsers) > 0){
                        foreach ($composedFinanceUsers as $composedFinanceUser) {
                            array_push($ccReceivers, $composedFinanceUser);
                        }
                    }
                    MailRepo::sendRequest('CASH-ADVANCE',$cashAdvance,$receivers,$ccReceivers,$reason);
                }else{
                    // IF NOT HAVE APPROVER
                    $receivers = MailRepo::composeReceivers($financeUsers);
                    MailRepo::sendRequest('CASH-ADVANCE',$cashAdvance,$receivers,$ccReceivers,$reason,'TO-FINANCE-DEPT');
                }

                break;

            case "APPROVER_APPROVE":

                $ccReceivers = MailRepo::composeReceivers($cashAdvance->user); // REQUESTER
                $relatedApprovers = ApprovalRepo::getRelatedApprovers($cashAdvance,'CASH-ADVANCE','APPROVER'); // RELATED APPROVERS
                $relatedApproverCCReceivers = MailRepo::composeReceivers($relatedApprovers);
                if(count($relatedApproverCCReceivers) > 0){
                    foreach ($relatedApproverCCReceivers as $relatedApproverCCReceiver) {
                        array_push($ccReceivers, $relatedApproverCCReceiver);
                    }
                }

                // IF FOUND NEXT APPROVER
                if($cashAdvance->next_approver_id){
                    $receivers = MailRepo::composeReceivers($cashAdvance->approver); // NEXT APPROVER
                    if(count($composedFinanceUsers) > 0){
                        foreach ($composedFinanceUsers as $composedFinanceUser) {
                            array_push($ccReceivers, $composedFinanceUser);
                        }
                    }
                    MailRepo::approverProcess('CASH-ADVANCE',$cashAdvance,'APPROVE',$receivers,$ccReceivers,$reason);

                // IF APPROVER APPROVE COMPLETED
                }else{
                    $receivers = MailRepo::composeReceivers($financeUsers); // FINANCE;
                    MailRepo::approverProcess('CASH-ADVANCE',$cashAdvance,'APPROVE',$receivers,$ccReceivers,$reason,'TO-FINANCE-DEPT');
                }

                break;

            case "APPROVER_SENDBACK":

                $receivers = MailRepo::composeReceivers($cashAdvance->user); // REQUESTER;
                $relatedApprovers = ApprovalRepo::getRelatedApprovers($cashAdvance,'CASH-ADVANCE','APPROVER'); // RELATED APPROVERS
                $ccReceivers = MailRepo::composeReceivers($relatedApprovers);
                if(count($composedFinanceUsers) > 0){
                    foreach ($composedFinanceUsers as $composedFinanceUser) {
                        array_push($ccReceivers, $composedFinanceUser);
                    }
                }

                MailRepo::approverProcess('CASH-ADVANCE',$cashAdvance,'SENDBACK',$receivers,$ccReceivers,$reason);

                break;

            case "APPROVER_REJECT":

                $receivers = MailRepo::composeReceivers($cashAdvance->user); // REQUESTER;
                $relatedApprovers = ApprovalRepo::getRelatedApprovers($cashAdvance,'CASH-ADVANCE','APPROVER'); // RELATED APPROVERS
                $ccReceivers = MailRepo::composeReceivers($relatedApprovers);
                if(count($composedFinanceUsers) > 0){
                    foreach ($composedFinanceUsers as $composedFinanceUser) {
                        array_push($ccReceivers, $composedFinanceUser);
                    }
                }

                MailRepo::approverProcess('CASH-ADVANCE',$cashAdvance,'REJECT',$receivers,$ccReceivers,$reason);

                break;

            case "FINANCE_APPROVE":

                $receivers = MailRepo::composeReceivers($cashAdvance->user); // REQUESTER;
                $ccReceivers = MailRepo::composeReceivers($financeUsers); // FINANCE
                $relatedApprovers = ApprovalRepo::getRelatedApprovers($cashAdvance,'CASH-ADVANCE','APPROVER'); // RELATED APPROVERS
                $relatedApproverCCReceivers = MailRepo::composeReceivers($relatedApprovers);
                if(count($relatedApproverCCReceivers) > 0){
                    foreach ($relatedApproverCCReceivers as $relatedApproverCCReceiver) {
                        array_push($ccReceivers, $relatedApproverCCReceiver);
                    }
                }

                MailRepo::financeProcess('CASH-ADVANCE',$cashAdvance,'APPROVE',$receivers,$ccReceivers);

                break;

            case "FINANCE_SENDBACK":

                $receivers = MailRepo::composeReceivers($cashAdvance->user); // REQUESTER;
                $ccReceivers = MailRepo::composeReceivers($financeUsers); // FINANCE
                $relatedApprovers = ApprovalRepo::getRelatedApprovers($cashAdvance,'CASH-ADVANCE','APPROVER'); // RELATED APPROVERS
                $relatedApproverCCReceivers = MailRepo::composeReceivers($relatedApprovers);
                if(count($relatedApproverCCReceivers) > 0){
                    foreach ($relatedApproverCCReceivers as $relatedApproverCCReceiver) {
                        array_push($ccReceivers, $relatedApproverCCReceiver);
                    }
                }

                MailRepo::financeProcess('CASH-ADVANCE',$cashAdvance,'SENDBACK',$receivers,$ccReceivers,$reason);

                break;

            case "FINANCE_REJECT":

                $receivers = MailRepo::composeReceivers($cashAdvance->user); // REQUESTER;
                $ccReceivers = MailRepo::composeReceivers($financeUsers); // FINANCE
                $relatedApprovers = ApprovalRepo::getRelatedApprovers($cashAdvance,'CASH-ADVANCE','APPROVER'); // RELATED APPROVERS
                $relatedApproverCCReceivers = MailRepo::composeReceivers($relatedApprovers);
                if(count($relatedApproverCCReceivers) > 0){
                    foreach ($relatedApproverCCReceivers as $relatedApproverCCReceiver) {
                        array_push($ccReceivers, $relatedApproverCCReceiver);
                    }
                }

                MailRepo::financeProcess('CASH-ADVANCE',$cashAdvance,'REJECT',$receivers,$ccReceivers,$reason);

                break;

            /////////////////////////////
            // #### CLEARING REQUEST ####

            case "CLEARING_SEND_REQUEST":

                $ccReceivers = MailRepo::composeReceivers(\Auth::user()); // REQUESTER
                if($cashAdvance->clearApprover){
                    $receivers = MailRepo::composeReceivers($cashAdvance->clearApprover); // NEXT APPROVER
                    if(count($composedFinanceUsers) > 0){
                        foreach ($composedFinanceUsers as $composedFinanceUser) {
                            array_push($ccReceivers, $composedFinanceUser);
                        }
                    }
                    MailRepo::sendRequest('CLEARING',$cashAdvance,$receivers,$ccReceivers,$reason);

                }else{
                    // IF NOT HAVE APPROVER
                    $receivers = MailRepo::composeReceivers($financeUsers);
                    MailRepo::sendRequest('CLEARING',$cashAdvance,$receivers,$ccReceivers,$reason,'TO-FINANCE-DEPT');
                }
                break;

            case "CLEARING_APPROVER_APPROVE":

                $ccReceivers = MailRepo::composeReceivers($cashAdvance->user); // REQUESTER
                $relatedApprovers = ApprovalRepo::getRelatedApprovers($cashAdvance,'CLEARING','APPROVER'); // RELATED APPROVERS
                $relatedApproverCCReceivers = MailRepo::composeReceivers($relatedApprovers);
                if(count($relatedApproverCCReceivers) > 0){
                    foreach ($relatedApproverCCReceivers as $relatedApproverCCReceiver) {
                        array_push($ccReceivers, $relatedApproverCCReceiver);
                    }
                }
                // IF FOUND NEXT CLEARING APPROVER
                if($cashAdvance->next_clearing_approver_id){
                    $receivers = MailRepo::composeReceivers($cashAdvance->clearApprover); // NEXT APPROVER
                    if(count($composedFinanceUsers) > 0){
                        foreach ($composedFinanceUsers as $composedFinanceUser) {
                            array_push($ccReceivers, $composedFinanceUser);
                        }
                    }
                    MailRepo::approverProcess('CLEARING',$cashAdvance,'APPROVE',$receivers,$ccReceivers,$reason);

                // IF CLEARING APPROVER APPROVE COMPLETED
                }else{
                    $receivers = MailRepo::composeReceivers($financeUsers); // FINANCE;
                    MailRepo::approverProcess('CLEARING',$cashAdvance,'APPROVE',$receivers,$ccReceivers,$reason,'TO-FINANCE-DEPT');
                }

                break;

            case "CLEARING_APPROVER_SENDBACK":

                $receivers = MailRepo::composeReceivers($cashAdvance->user); // REQUESTER;
                $relatedApprovers = ApprovalRepo::getRelatedApprovers($cashAdvance,'CLEARING','APPROVER'); // RELATED APPROVERS
                $ccReceivers = MailRepo::composeReceivers($relatedApprovers);
                if(count($composedFinanceUsers) > 0){
                    foreach ($composedFinanceUsers as $composedFinanceUser) {
                        array_push($ccReceivers, $composedFinanceUser);
                    }
                }

                MailRepo::approverProcess('CLEARING',$cashAdvance,'SENDBACK',$receivers,$ccReceivers,$reason);

                break;

            case "CLEARING_FINANCE_APPROVE":

                $receivers = MailRepo::composeReceivers($cashAdvance->user); // REQUESTER;
                $ccReceivers = MailRepo::composeReceivers($financeUsers); // FINANCE
                $relatedApprovers = ApprovalRepo::getRelatedApprovers($cashAdvance,'CLEARING','APPROVER'); // RELATED APPROVERS
                $relatedApproverCCReceivers = MailRepo::composeReceivers($relatedApprovers);
                if(count($relatedApproverCCReceivers) > 0){
                    foreach ($relatedApproverCCReceivers as $relatedApproverCCReceiver) {
                        array_push($ccReceivers, $relatedApproverCCReceiver);
                    }
                }

                MailRepo::financeProcess('CLEARING',$cashAdvance,'APPROVE',$receivers,$ccReceivers);

                break;

            case "CLEARING_FINANCE_SENDBACK":

                $receivers = MailRepo::composeReceivers($cashAdvance->user); // REQUESTER;
                $ccReceivers = MailRepo::composeReceivers($financeUsers); // FINANCE
                $relatedApprovers = ApprovalRepo::getRelatedApprovers($cashAdvance,'CLEARING','APPROVER'); // RELATED APPROVERS
                $relatedApproverCCReceivers = MailRepo::composeReceivers($relatedApprovers);
                if(count($relatedApproverCCReceivers) > 0){
                    foreach ($relatedApproverCCReceivers as $relatedApproverCCReceiver) {
                        array_push($ccReceivers, $relatedApproverCCReceiver);
                    }
                }

                MailRepo::financeProcess('CLEARING',$cashAdvance,'SENDBACK',$receivers,$ccReceivers,$reason);

                break;

        }
    }

    // public function export(Request $request)
    // {
    //     $yearShowing = $request->year_showing;
    //     $exportType = $request->type;
    //     $search = [
    //         'document_no'=>$request->document_no,
    //         'status'=>$request->status
    //     ];
    //     $search_date = [
    //         'date_from'=>$request->date_from,
    //         'date_to'=>$request->date_to
    //     ];
    //     $cashAdvances = CashAdvance::orderBy('creation_date','desc')
    //                     ->whereOrgId($this->orgId)
    //                     ->byRelatedUser()
    //                     ->byYearShowing($yearShowing)
    //                     ->with('user')
    //                     ->search($search,$search_date)
    //                     ->get();
    //     // if(!$cashAdvances){ abort(403); }

    //     if($exportType == 'CASH-ADVANCE'){

    //         \Excel::create('CA_'.Carbon::now(), function($excel) use ($cashAdvances) {

    //             $excel->sheet('Report', function($sheet) use ($cashAdvances) {

    //                 $sheet->loadView('ie.cash-advances.export._template', compact('cashAdvances'));

    //             });

    //         })->export('xlsx');

    //     }elseif($exportType == 'CLEARING'){

    //         // $defaultEstablishmentId = $cashAdvance->user->employee->establishment_id;
    //         $establishmentLists = Establishment::whereOrgId($this->orgId)->pluck('establishment_name','establishment_id')->all();
    //         $vendorLists = Vendor::select(\DB::raw("vendor_no || ' : ' || vendor_name AS vendor_name"),'vendor_id')->whereOrgId($this->orgId)->pluck('vendor_name','vendor_id')->all();
    //         // $projectLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->project()->orderBy('flex_value')->pluck('full_description','flex_value')->all();
    //         // $rechargeLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->interCompany()->orderBy('flex_value')->pluck('full_description','flex_value')->all();

    //         $branchLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->EVM($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
    //         $departmentLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->department($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();

    //         \Excel::create('CC_'.Carbon::now(), function($excel) use ($cashAdvances,$establishmentLists,$vendorLists,$branchLists,$departmentLists) {

    //             $excel->sheet('Report', function($sheet) use ($cashAdvances,$establishmentLists,$vendorLists,$branchLists,$departmentLists) {

    //                 $sheet->loadView('ie.cash-advances.export._template_clearing', compact('cashAdvances','establishmentLists','vendorLists','projectLists','rechargeLists','branchLists','departmentLists'));

    //             });

    //         })->export('xlsx');

    //     }
    // }

    public function reapply(Request $request, $cashAdvanceId)
    {
        \DB::beginTransaction();
        try {
            // SELECTED CASH ADVANCE FOR DUPLICATE
            $cashAdvance = CashAdvance::find($cashAdvanceId);
            if(!$cashAdvance->statusClearCancel){
                return abort('403');
            }
            // NEW CASH-ADVANCE
            $newCashAdvance = $cashAdvance->replicate();
            $newCashAdvance->currency_id  = $cashAdvance->currency_id;

            $orgId = $cashAdvance->org_id;
            $currencyType = $cashAdvance->advance_type == 'ในประเทศ' ? 1 : 2;

            $documentNo = CashAdvance::genDocumentNo($orgId, $currencyType, $cashAdvance->last_apply ?? $cashAdvance, $cashAdvance->gl_date);
            // $newCashAdvance->document_no = $documentNo['CA'];
            $newCashAdvance->clearing_document_no = $documentNo['CL'];

            $newCashAdvance->status = "APPROVED";
            $newCashAdvance->encumbrance_flag = 'N';
            $newCashAdvance->clearing_invoice_no = null;
            $newCashAdvance->last_updated_by = \Auth::user()->user_id;
            $newCashAdvance->created_by = \Auth::user()->user_id;
            $newCashAdvance->last_update_date = Carbon::now();
            $newCashAdvance->save();

            // $cashAdvance->encumbrance_flag = 'N';
            $cashAdvance->apply_to = $newCashAdvance->cash_advance_id;
            $cashAdvance->save();

            // DUPLICATE ACTIVITY LOG
            $activityLogs = $cashAdvance->activityLogs;
            foreach($activityLogs as $log){
                $newLog = $log->replicate();
                $newLog->activity_logable_id = $newCashAdvance->cash_advance_id;
                $newLog->save();
            }
            $activityLogRepo = new ActivityLogRepo;
            $activityLogRepo->create($newCashAdvance, ActivityLogRepo::getActivityMessage('RE_APPLY'), 'RE_APPLY');

            //  DUPLICATE APPROVAL 
            $approvals = $cashAdvance->approvals->where('process_type','CASH-ADVANCE')->where('approver_type','APPROVER');
            foreach($approvals as $approval){
                $newApproval = $approval->replicate();
                $newApproval->approvalable_id = $newCashAdvance->cash_advance_id;
                $newApproval->save();
            }

            ////////////////////////////
            // DUPLICATE RECEIPT DATA
            $receipts = $cashAdvance->receipts()->processType('CASH-ADVANCE')->orderBy('receipt_id')->get();
            foreach ($receipts as $key => $receipt) {

                $newReceipt = $receipt->replicate();
                $newReceipt->receiptable_id = $newCashAdvance->cash_advance_id;
                $newReceipt->last_updated_by = \Auth::user()->user_id;
                $newReceipt->created_by = \Auth::user()->user_id;
                // $newReceipt->creation_date = Carbon::now();
                // $newReceipt->last_update_date = Carbon::now();
                // SAVE RECEIPT DATA
                $newCashAdvance->receipts()->save($newReceipt);

                /////////////////////////////////
                // DUPLICATE RECEIPT LINES DATA
                $receiptLines = $receipt->lines;
                foreach($receiptLines as $receiptLine){

                    // DUPLICATE RECEIPT LINE DATA
                    $newReceiptLine = $receiptLine->replicate();
                    $newReceiptLine->receipt_id = $newReceipt->receipt_id;
                    $newReceiptLine->last_updated_by = \Auth::user()->user_id;
                    $newReceiptLine->created_by = \Auth::user()->user_id;
                    // $newReceiptLine->creation_date = Carbon::now();
                    // $newReceiptLine->last_update_date = Carbon::now();
                    $newReceiptLine->save();

                    // DUPLICATE RECEIPT LINE INFORMATIONS
                    $infos = SubCategoryInfo::where('sub_category_id', $newReceiptLine->sub_category_id)
                                ->active()
                                ->get();

                    if(count($infos)>0){

                        $subCategoryInfos = $receiptLine->infos->pluck('description','sub_category_info_id')->all();

                        foreach($infos as $info){
                            if(array_key_exists($info->sub_category_info_id, $subCategoryInfos)){
                                $newReceiptLineInfo = new ReceiptLineInfo();
                                $newReceiptLineInfo->receipt_id = $newReceipt->receipt_id;
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

                }
            }

            // SUCCESS CREATE CASH ADVANCE
            \DB::commit();

            // INTERFACE ENCUMBRANCE 
            if( $newCashAdvance->encumbrance_flag != 'Y'){
                $batchNo = InterfaceRepo::encumbrance($newCashAdvance, 'CASH-ADVANCE', 'reserve');
                $result = InterfaceRepo::submitEncumbrance($batchNo);
                if($result['status'] == 'C'){
                    $newCashAdvance->encumbrance_flag = 'Y';
                    $newCashAdvance->save();
                }else {
                    \DB::rollBack();
                    $error_msg = optional(InterfaceEncumbrance::where('interface_status', 'E')
                        ->where('batch_no', $batchNo)
                        ->first())->interface_message ?? ($result['message'] ?? 'Encumbrance Error !');
                    return redirect()->back()->withErrors($error_msg);
                }
            }

            if($request->ajax()){
                $result['status'] = 'SUCCESS';
                $result['cashAdvanceId'] = $newCashAdvance->cash_advance_id;
                return $result;
            }else{
                return redirect()->route('ie.cash-advances.show',['cashAdvance'=>$newCashAdvance->cash_advance_id]);
            }

        } catch (\Exception $e) {
            // ERROR CREATE CASH ADVANCE
            \DB::rollBack();
            if($request->ajax()){
                $result['status'] = 'ERROR';
                $result['err_msg'] = $e->getMessage();
                return $result;
            }else{
                // throw new \Exception($e->getMessage(), 1);
                \Log::error($e->getMessage());
                return abort('403');
            }
        }
    }

    public function duplicate(Request $request, $cashAdvanceId)
    {
        \DB::beginTransaction();
        try {
            // SELECTED CASH ADVANCE FOR DUPLICATE
            $cashAdvance = CashAdvance::find($cashAdvanceId);

            // GET PENDING TRASACTION
            $pendingRequestLists = RequestRepo::getPendingOverLimitRequest($cashAdvance->requester_id);

            $orgId = $cashAdvance->org_id;
            // NEW CASH-ADVANCE
            $newCashAdvance = $cashAdvance->replicate();

            $newCashAdvance->currency_id  = $cashAdvance->currency_id;
            $currencyType = $cashAdvance->advance_type == 'ในประเทศ' ? 1 : 2;
            $documentNo = CashAdvance::genDocumentNo($orgId, $currencyType, null, $cashAdvance->gl_date);
            $newCashAdvance->document_no = $documentNo['CA'];
            $newCashAdvance->clearing_document_no = $documentNo['CL'];

            if(count($pendingRequestLists) <= 0){
                $newCashAdvance->status = "NEW_REQUEST";
            }else{ // BLOCKED IF HAS PENDING REQUEST
                $newCashAdvance->status = "BLOCKED";
            }
            $newCashAdvance->encumbrance_flag = 'N';
            $newCashAdvance->apply_to = null;
            $newCashAdvance->invoice_no = null;
            $newCashAdvance->clearing_invoice_no = null;
            $newCashAdvance->hierarchy_name_id = null;
            $newCashAdvance->hierarchy_name_position_id = null;
            $newCashAdvance->last_updated_by = \Auth::user()->user_id;
            $newCashAdvance->created_by = \Auth::user()->user_id;
            $newCashAdvance->creation_date = Carbon::now();
            $newCashAdvance->last_update_date = Carbon::now();
            $newCashAdvance->save();

            // ACTIVITY LOG
            $activityLogRepo = new ActivityLogRepo;
            $activityLogRepo->create($newCashAdvance, ActivityLogRepo::getActivityMessage('NEW_REQUEST'), 'NEW_REQUEST');

            ////////////////////////////
            // DUPLICATE RECEIPT DATA
            $receipts = $cashAdvance->receipts()->processType('CASH-ADVANCE')->orderBy('receipt_id')->get();
            foreach ($receipts as $key => $receipt) {

                $newReceipt = $receipt->replicate();
                $newReceipt->receiptable_id = $newCashAdvance->cash_advance_id;
                $newReceipt->last_updated_by = \Auth::user()->user_id;
                $newReceipt->created_by = \Auth::user()->user_id;
                // $newReceipt->creation_date = Carbon::now();
                // $newReceipt->last_update_date = Carbon::now();
                // SAVE RECEIPT DATA
                $newCashAdvance->receipts()->save($newReceipt);

                /////////////////////////////////
                // DUPLICATE RECEIPT LINES DATA
                $receiptLines = $receipt->lines;
                foreach($receiptLines as $receiptLine){

                    // DUPLICATE RECEIPT LINE DATA
                    $newReceiptLine = $receiptLine->replicate();
                    $newReceiptLine->receipt_id = $newReceipt->receipt_id;
                    $newReceiptLine->last_updated_by = \Auth::user()->user_id;
                    $newReceiptLine->created_by = \Auth::user()->user_id;
                    // $newReceiptLine->creation_date = Carbon::now();
                    // $newReceiptLine->last_update_date = Carbon::now();
                    $newReceiptLine->save();

                    // DUPLICATE RECEIPT LINE INFORMATIONS
                    $infos = SubCategoryInfo::where('sub_category_id', $newReceiptLine->sub_category_id)
                                ->active()
                                ->get();

                    if(count($infos)>0){

                        $subCategoryInfos = $receiptLine->infos->pluck('description','sub_category_info_id')->all();

                        foreach($infos as $info){
                            if(array_key_exists($info->sub_category_info_id, $subCategoryInfos)){
                                $newReceiptLineInfo = new ReceiptLineInfo();
                                $newReceiptLineInfo->receipt_id = $newReceipt->receipt_id;
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

                }
            }

            // SUCCESS CREATE CASH ADVANCE
            \DB::commit();
            if($request->ajax()){
                $result['status'] = 'SUCCESS';
                $result['cashAdvanceId'] = $newCashAdvance->cash_advance_id;
                return $result;
            }else{
                return redirect()->route('ie.cash-advances.show',['cashAdvance'=>$newCashAdvance->cash_advance_id]);
            }

        } catch (\Exception $e) {
            // ERROR CREATE CASH ADVANCE
            \DB::rollBack();
            if($request->ajax()){
                $result['status'] = 'ERROR';
                $result['err_msg'] = $e->getMessage();
                return $result;
            }else{
                // throw new \Exception($e->getMessage(), 1);
                \Log::error($e->getMessage());
                return abort('403');
            }
        }

    }

    public function changeApprover(Request $request, $cashAdvanceId)
    {

        \DB::beginTransaction();
        try {

            $cashAdvance = CashAdvance::find($cashAdvanceId);
            if( in_array($cashAdvance->status, ['APPROVER_DECISION', 'FINANCE_PROCESS']) ){

                $cashAdvance->next_approver_id = $request->select_approver;
    
            }elseif( in_array($cashAdvance->status, ['CLEARING_APPROVER_DECISION', 'CLEARING_FINANCE_PROCESS'])){
    
                $cashAdvance->next_clearing_approver_id = $request->select_approver;
    
            }
            $cashAdvance->save();

            // $next_approver = User::where('user_id', $request->select_approver)->first();
            // $reason = 'เปลี่ยนผู้อนุมัติเป็น ' . optional($next_approver)->name;
            // $activityLogRepo = new ActivityLogRepo;
            // $activityLogRepo->create($cashAdvance, ActivityLogRepo::getActivityMessage('CHANGE_APPROVER'), 'CHANGE_APPROVER', $reason);

            \DB::commit();

            return back()->with('success', 'Change approver success.');
        } catch (\Exception $e) {
            // ERROR CREATE REIMBURSEMENT
            \DB::rollBack();
            if($request->ajax()){
                $result['status'] = 'ERROR';
                $result['err_msg'] = $e->getMessage();
                return $result;
            }else{
                // throw new \Exception($e->getMessage(), 1);
                \Log::error($e->getMessage());
                return back()->withErrors('Change approver fail.');
            }
        }
    }

    

    public function getSuppliers(Request $request)
    {
        $orgId = $request->org_id;
        if($orgId){
            $supplierLists = Vendor::select(\DB::raw("vendor_no || ' : ' || vendor_name AS full_description"),'vendor_id')
                                    ->whereOrgId($orgId)
                                    ->orderBy('vendor_id')
                                    ->pluck('full_description','vendor_id')
                                    ->all();

            $defaultSupplier = Vendor::whereOrgId($orgId)
                                    ->where('vendor_name', 'like', '%ลูกหนี้เงินทดรอง%')
                                    ->orderBy('vendor_id')
                                    ->first();
            $defaultSupplierId = $defaultSupplier ? $defaultSupplier->vendor_id : null;
        }else{
            $supplierLists = [];
        }

        return view('ie.reimbursements._ddl_suppliers',compact('supplierLists', 'defaultSupplierId'));
    }

    public function getSupplierSites(Request $request)
    {
        $supplierId = $request->supplier_id;
        $orgId = $request->org_id;
        if($supplierId){
            $supplierSiteLists = Vendor::select(\DB::raw("vendor_site_code AS full_description"), 'vendor_site_id')
                                    ->where('vendor_id', $supplierId)
                                    ->whereOrgId($orgId)
                                    ->orderBy('vendor_site_id')
                                    ->pluck('full_description','vendor_site_id')
                                    ->all();
        }else{
            $supplierSiteLists = [];
        }

        return view('ie.reimbursements._ddl_supplier_sites',compact('supplierSiteLists'));
    }

    public function getSupplierBankDetail(Request $request)
    {
        $supplierId = $request->supplier_id;
        $supplierSiteId = $request->supplier_site_id;
        $orgId = $request->org_id;

        $supplier = Vendor::where('vendor_id', $supplierId)
        ->where('vendor_site_id', $supplierSiteId)
        ->whereOrgId($orgId)
        ->first();

        return view('ie.reimbursements._detail_supplier_bank',compact('supplier'));
    }

    public function getRequesterData(Request $request)
    {
        $emp = HREmployee::find($request->requester_id);

        $requester = $emp->user()->with('PersonalDeptLocation.department', 'pnMaster', 'userAccounts')->first();

        $employeeLists = [];

        // GET PENDING TRASACTION
        $pendingRequestLists = RequestRepo::getPendingOverLimitRequest($request->requester_id);

        $empCode = optional(optional($requester)->PersonalDeptLocation)->dept_cd_f02 ?? null;
        if($empCode){
            $employeeLists = Employee::select(\DB::raw("employee_number || ' : ' || last_name || ' - ' || first_name AS full_description"), 'employee_id')
                // ->where('employee_number', 'like', '%'.$empCode.'%')
                ->HasExpenseAccount()
                ->orderBy('employee_number')
                ->pluck('full_description', 'employee_id')
                ->all();
        }

        $data = [
            'requester' => $requester,
            'employees' => view('ie.reimbursements._ddl_employees', compact('employeeLists'))->render(),
            'pendingRequestLists' => view('ie.commons._unclear_alert_message', compact('pendingRequestLists'))->render(),
            'status' => 's'
        ];

        return response()->json($data);
    }

    public function updateDFF(Request $request, $cashAdvanceId)
    {
        \DB::beginTransaction();
        try {

            $cashAdvance = CashAdvance::find($cashAdvanceId);
            if($request->request_type == 'CLEARING'){
                $cashAdvance->clearing_dff_type = $request->dff_type;
                $cashAdvance->clearing_dff_pay_for = $request->pay_for;
                $cashAdvance->clearing_dff_group_tax_code = $request->group_tax_code;
            }else {
                $cashAdvance->dff_type = $request->dff_type;
                $cashAdvance->dff_pay_for = $request->pay_for;
                $cashAdvance->dff_group_tax_code = $request->group_tax_code;
            }
            $cashAdvance->save();

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

    public function listCancelApply(Request $request, $cashAdvanceId)
    {
        $cashAdvance = CashAdvance::with('apply')->find($cashAdvanceId);

        return view('ie.cash-advances._list_cancel_apply', compact(
            'cashAdvance'
        ));
    }

    public function returnEncumbrance()
    {
        set_time_limit(0);

        $cancelAPCA = CashAdvance::join('oaie.ptie_ap_inv_cancelled_v', 'ptie_ap_inv_cancelled_v.invoice_num', '=', 'ptw_cash_advances.invoice_no')
        ->whereIn('status', ['APPROVED', 'CLEARING_REQUEST'])
        ->whereNotIn('status', ['CANCELLED'])
        ->whereNull('apply_to')
        ->get();

        foreach ($cancelAPCA as $cancel) {
            if( $cancel->encumbrance_flag == 'Y'){
                $batchNo = InterfaceRepo::encumbrance($cancel, 'CASH-ADVANCE', 'return');
                $result = InterfaceRepo::submitEncumbrance($batchNo);
                if($result['status'] == 'C'){
                    $cancel->status = 'CANCELLED';
                    $cancel->encumbrance_flag = 'N';
                    $cancel->save();
                }
            }else {
                $cancel->status = 'CANCELLED';
            }
            $cancel->save();
        }

        $cancelAPCL = CashAdvance::join('oaie.ptie_ap_inv_cancelled_v', 'ptie_ap_inv_cancelled_v.invoice_num', '=', 'ptw_cash_advances.invoice_no')
        ->whereIn('status', ['CLEARING_APPROVER_DECISION', 'CLEARED'])
        ->whereNull('apply_to')
        ->get();

        foreach ($cancelAPCL as $cancel) {
            if( $cancel->encumbrance_flag == 'Y'){
                $batchNo = InterfaceRepo::encumbrance($cancel, 'CLEARING', 'return');
                $result = InterfaceRepo::submitEncumbrance($batchNo);
                if($result['status'] == 'C'){
                    $cancel->status = 'CANCELLED';
                    $cancel->encumbrance_flag = 'N';
                    $cancel->save();
                }
            }else {
                $cancel->status = 'CANCELLED';
            }
            $cancel->save();
        }

        return back()->with('success', 'Return Encumbrances Success.');
    }

    public function formSendRequest(Request $request, $cashAdvanceId)
    {
        $approveCode = $request->receipt_type == 'CASH-ADVANCE' ? 'CASH' : 'REIM';

        $cashAdvance = CashAdvance::find($cashAdvanceId);

        // GET PENDING TRASACTION
        $pendingRequestLists = RequestRepo::getPendingOverLimitRequest($cashAdvance->requester_id);

        $hierarchyTypeLists = HierarchyType::orderBy('name')->get();

        $defaultType = $hierarchyTypeLists->where('department_flag', true)->first();

        $setupLists = $defaultType ? HierarchySetup::whereHas('topic', function($q) use($approveCode){
            return $q->where('code', $approveCode);
        })
        ->where('hierarchy_type_id', $defaultType->hierarchy_type_id)
        ->whereHas('department', function($q) use($cashAdvance){
            return $q->where(function($p) use($cashAdvance){
                return $p->where('child_flex_value_low', '<=', $cashAdvance->department_code)
                    ->where('child_flex_value_high', '>=', $cashAdvance->department_code);
            })
            ->orWhere('value_code', $cashAdvance->department_code);
        })
        ->with('department')
        ->get() : collect();

        return view('ie.cash-advances.show._form_send_request', compact(
            'approveCode',
            'pendingRequestLists',
            'cashAdvance',
            'hierarchyTypeLists',
            'defaultType',
            'setupLists'
        ));
    }

    public function getHierarchies(Request $request, $cashAdvanceId)
    {
        $approveCode = $request->approve_code;

        $cashAdvance = CashAdvance::find($cashAdvanceId);

        $typeId = $request->type_id;

        $hierarchyType = HierarchyType::find($typeId);

        $setupLists = HierarchySetup::whereHas('topic', function($q) use($approveCode){
            return $q->where('code', $approveCode);
        })
        ->where('hierarchy_type_id', $typeId)
        ->when($hierarchyType->department_flag, function($q) use($cashAdvance) {
            return $q->whereHas('department', function($p) use($cashAdvance){
                return $p->where(function($r) use($cashAdvance){
                    return $r->where('child_flex_value_low', '<=', $cashAdvance->department_code)
                        ->where('child_flex_value_high', '>=', $cashAdvance->department_code);
                })
                ->orWhere('value_code', $cashAdvance->department_code);
            });
        })
        ->with('department')
        ->get();

        return view('ie.cash-advances.show._ddl_hierarchies', compact(
            'cashAdvance',
            'setupLists'
        ));
    }

    public function getHierarchyUserLists(Request $request, $cashAdvanceId)
    {
        $cashAdvance = CashAdvance::find($cashAdvanceId);

        $nameId = $request->name_id;

        $hierarchy = HierarchyName::find($nameId);

        return view('ie.cash-advances.show._hierarchy_user_list', compact(
            'cashAdvance',
            'hierarchy'
        ));
    }

    public function checkGLPeriod(Request $request)
    {
        $orgId = $request->org_id;
        $date = \DateTime::createFromFormat(trans('date.format'), $request->date)->format('Y-m-d');

        try {

            InterfaceRepo::validatePeriodIsOpen($orgId, $date);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 'E',
                'msg' => $e->getMessage()
            ]);

        }

        return response()->json([
            'status' => 'S',
            'msg' => ''
        ]);
    }

}
