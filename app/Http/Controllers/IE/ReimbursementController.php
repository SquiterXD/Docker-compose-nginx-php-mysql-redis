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

use App\Models\IE\Reimbursement;
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
use App\Models\IE\Receipt;
use App\Models\IE\ReceiptLine;
use App\Models\IE\ReceiptLineInfo;
use App\Models\IE\APPaymentMethod;
use App\Models\IE\APPaymentTerm;
use App\Models\IE\HrOperatingUnit;
use App\Models\IE\APReportingEntity;
use App\Models\User;
use App\Models\IE\HierarchyType;
use App\Models\IE\HierarchyName;
use App\Models\IE\HierarchySetup;
use App\Models\HREmployee;
use App\Models\IE\InterfaceEncumbrance;
use App\Models\IE\InterfaceAPHeader;

use Carbon\Carbon;


class ReimbursementController extends Controller
{
    protected $perPage = 10;
    protected $orgId;
    protected $approveCode = 'REIM';

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
        if(!canView('/ie/reimbursements') && !canEnter('/ie/reimbursements')) {
            return redirect()->back()->withErrors(trans('403'));
        }

        $search = $request->search;
        $reims = Reimbursement::search($search)
            ->when(!\Auth::user()->isShowAll(), function($q){
                $q->whereCreatedBy(\Auth::user()->user_id)
                ->orWhere('requester_id', \Auth::user()->username);
            })
            ->with('user')
            ->orderBy('creation_date','desc')
            ->paginate($this->perPage);
        $allowDuplicate = true;
        $statusSet = [  
            'NEW_REQUEST',
            'RESERVE_ENCUMBRANCE',
            'DECISION',
            'REJECTED',
            'CANCELLED',
            'APPROVED'
        ];

        $mappings = Preference::getMappingOU();

        return view('ie.reimbursements.index', compact(
            'reims',
            'search',
            'allowDuplicate',
            'statusSet',
            'mappings'
        ));
    }

    public function indexPending(Request $request)
    {
        if(!canView('/ie/reimbursements/pending') && !canEnter('/ie/reimbursements/pending')) {
            return redirect()->back()->withErrors(trans('403'));
        }

        $search = $request->search;
        $reims = Reimbursement::search($search)
            ->ByPendingUser(\Auth::user()->user_id)
            ->with('user')
            ->orderBy('creation_date','desc')
            ->paginate($this->perPage);
        $statusSet = [  
            'NEW_REQUEST',
            'DECISION',
            'REJECTED',
            'CANCELLED',
            'APPROVED'
        ];
        $mappings = Preference::getMappingOU();

        return view('ie.reimbursements.index_pending', compact(
            'reims',
            'search',
            'statusSet',
            'mappings'
        ));
    }

    public function create()
    {
        if(!canEnter('/ie/reimbursements')) {
            return redirect()->back()->withErrors(trans('403'));
        }

        $user = auth()->user();
        $requester = $user->hrEmp ? $user : null;

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

        $APPaymentMethodLists = APPaymentMethod::active()
            ->pluck('payment_method_name','payment_method_code')
            ->all();

        $APPaymentTerms = APPaymentTerm::all();
        $APPaymentTermLists = APPaymentTerm::select(\DB::raw("payment_term_name AS full_description"),'payment_term_id')
            ->orderBy('payment_term_id')
            ->pluck('full_description','payment_term_id')
            ->all();

        $baseCurrencyId = Preference::getBaseCurrency();
        $currencyLists = Currency::pluck('currency_code','currency_code')->all();
        $ouLists = HrOperatingUnit::select(\DB::raw("name AS full_description"),'organization_id')
            ->orderBy('organization_id')
            ->pluck('full_description','organization_id')
            ->all();

        return view('ie.reimbursements.create', compact(
            // 'pendingRequestLists',
            'requester',
            'userLists',
            'bankLists',
            'accountLists',
            'employeeLists',
            'currencyLists',
            'supplierLists',
            'APPaymentMethodLists',
            'ouLists',
            'APPaymentTerms',
            'APPaymentTermLists',
            'defaultSupplierId',
            'baseCurrencyId',
            'defaultPaymentMethod'
        ));
    }

    public function store(Request $request)
    {
        if(!canEnter('/ie/reimbursements')) {
            return redirect()->back()->withErrors(trans('403'));
        }

        \DB::beginTransaction();
        try {
            // CREATE REIMBURSEMENT
            $reim = new Reimbursement();
            $reim->invoice_no = $request->invoice_no;
            $reim->org_id = $request->org_id;
            $emp = HREmployee::find($request->requester_id);
            $reim->user_id = optional($emp->user)->user_id;

            $orgId = $reim->org_id;

            $reim->request_date = \DateTime::createFromFormat(trans('date.format'), $request->request_date)->format('Y-m-d');
            $reim->gl_date = \DateTime::createFromFormat(trans('date.format'), $request->gl_date)->format('Y-m-d');
            $reim->currency_id  = $request->currency_id;
            $reim->reimbursement_type = $request->reimbursement_type;
            $currencyType = $reim->reimbursement_type == 'ในประเทศ' ? 1 : 2;
            $reim->exchange_rate = $reim->currency_id == 'THB' ? 1 : $request->exchange_rate;
            $reim->rate_date = $reim->currency_id == 'THB' ? null : ($request->rate_date ? \DateTime::createFromFormat(trans('date.format'), $request->rate_date)->format('Y-m-d') : null);
            $reim->document_no = Reimbursement::genDocumentNo($orgId, $currencyType, $reim->gl_date);
            $reim->tel = $request->tel;

            $reim->vendor_id = $request->supplier_id;
            $reim->vendor_site_id = $request->supplier_site_id;

            $supplier = Vendor::where('vendor_id', $reim->vendor_id)
            ->where('vendor_site_id', $reim->vendor_site_id)
            ->whereOrgId($orgId)
            ->first();
            if($supplier){
                $reim->vendor_bank_name = optional($supplier->bank)->short_bank_name;
                $reim->vendor_bank_account_no = optional($supplier->bank)->bank_account_num;
            }

            if(Reimbursement::checkDupInvNo($orgId, $reim->vendor_id, $reim->invoice_no)){
                return redirect()->back()->withErrors('Duplicate Invoice');
            }

            $reim->payment_method_id = $request->payment_method_id;
            $defaultPaymentTerm = APPaymentTerm::where('due_days', 0)->first();
            $reim->payment_term_id = $defaultPaymentTerm->payment_term_id;
            $reim->due_date = $reim->gl_date; //\DateTime::createFromFormat(trans('date.format'), date('d/m/Y'))->format('Y-m-d');

            $reim->requester_id = $request->requester_id;
            $reim->bank_name = $request->bank_name;
            $reim->account_no = $request->account_no;
            $reim->account_name = $request->account_name;
            $reim->position_name = $request->position_name;
            $reim->department_code = $request->department_code;
            $reim->employee_id = $request->employee_id;
            $reim->pay_to_emp = $request->pay_to_emp;

            $reim->purpose  = trim($request->purpose);
            $reim->reason  = trim($request->reason);
            
            $reim->checked_by = $request->checked_by;
            $reim->approved_by = $request->approved_by;

            $reim->status = "NEW_REQUEST";

            $reim->last_updated_by = \Auth::user()->user_id;
            $reim->created_by = \Auth::user()->user_id;

            ///// DFF /////
            $groupTaxCode = APReportingEntity::select(\DB::raw("entity_name AS full_description"),'entity_name')
                    ->whereOrgId($orgId)
                    ->orderBy('entity_name')
                    ->first();

            $reim->dff_type = 'invoice';
            $reim->dff_pay_for = $request->pay_to_emp == 'YES' ? optional($reim->user)->name : optional($supplier)->vendor_name;
            $reim->dff_group_tax_code = $groupTaxCode ? $groupTaxCode->entity_name : null;

            $reim->save();

            // FILE ATTACHMENTS
            if($request->file('file')){
                $attachmentRepo = new AttachmentRepo;
                $attachmentRepo->create($reim, $request->file('file'));
            }

            // ACTIVITY LOG
            $activityLogRepo = new ActivityLogRepo;
            $activityLogRepo->create($reim, ActivityLogRepo::getActivityMessage('NEW_REQUEST'), 'NEW_REQUEST');

            // SUCCESS CREATE REIMBURSEMENT
            \DB::commit();
            if($request->ajax()){
                $result['status'] = 'SUCCESS';
                $result['reimId'] = $reim->reimbursement_id;
                return $result;
            }else{
                return redirect()->route('ie.reimbursements.show', ['reimbursement' => $reim->reimbursement_id]);
            }

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
                return abort('403');
            }
        }
    }

    public function show($reimId)
    {
        if(!canView('/ie/reimbursements') && !canEnter('/ie/reimbursements')) {
            return redirect()->back()->withErrors(trans('403'));
        }

        // GET REIM DATA
        $reim = Reimbursement::find($reimId);
        if(!$reim){ abort(404); }
        // if(!$reim->isRelatedUser()){ abort(404); }
        $reim->due_date = dateFormatDisplay($reim->due_date);
        $reim->rate_date = dateFormatDisplay($reim->rate_date);
        $reim->invoice_date = dateFormatDisplay($reim->invoice_date);
        $reim->request_date = dateFormatDisplay($reim->request_date);
        $reim->gl_date = dateFormatDisplay($reim->gl_date);
        $reimTotalAmount = $reim->total_receipt_amount + 0;

        $orgId = $reim->org_id;

        $requester = $reim->requester->user;

        // GET ACTIVITY LOG
        $activityLogs = $reim->activityLogs;

        // DATA FOR RECEIPT
        $receipts = $reim->receipts;
        $receiptParentId = $reimId;
        $categoryLists = Category::active()
                        ->pluck('name','category_id')
                        ->all();
        $parent = $reim;
        $parentCurrencyId = $reim->currency_id;
        $receiptType = 'REIMBURSEMENT';

        $ouLists = HrOperatingUnit::select(\DB::raw("name AS full_description"),'organization_id')
            ->orderBy('organization_id')
            ->pluck('full_description','organization_id')
            ->all();

        $defaultEstablishmentId = -1;
        $establishmentLists = Establishment::whereOrgId($orgId)->pluck('establishment_name','establishment_id')->all();
        $vendorLists = Vendor::select(\DB::raw("vendor_no || ' : ' || vendor_name AS vendor_name"),'vendor_id')->pluck('vendor_name','vendor_id')->all();
        // $vendorLists = Vendor::select(\DB::raw("vendor_no || ' : ' || vendor_name AS vendor_name"),'vendor_id')->whereOrgId($orgId)->pluck('vendor_name','vendor_id')->all();

        $branchLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->EVM($orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $departmentLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->department($orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $defaultAPPaymentMethodId = $reim->payment_method_id;
        $APPaymentMethodLists = APPaymentMethod::active()
            ->pluck('payment_method_name','payment_method_code')
            ->all();

        $defaultAPPaymentTermId = $reim->payment_term_id;
        $APPaymentTerms = APPaymentTerm::all();
        $APPaymentTermLists = APPaymentTerm::select(\DB::raw("payment_term_id || ' : ' || payment_term_name AS full_description"),'payment_term_id')
            ->orderBy('payment_term_id')
            ->pluck('full_description','payment_term_id')
            ->all();

        return view('ie.reimbursements.show', compact(
            'reim',
            'reimTotalAmount',
            'activityLogs',
            'requester',
            'receipts',
            'receiptParentId',
            'categoryLists',
            'parent',
            'parentCurrencyId',
            'receiptType',
            'ouLists',
            'defaultEstablishmentId',
            'establishmentLists',
            'vendorLists',
            'branchLists',
            'departmentLists',
            'defaultAPPaymentMethodId',
            'APPaymentMethodLists',
            'defaultAPPaymentTermId',
            'APPaymentTerms',
            'APPaymentTermLists'
        ));
    }

    public function formEdit(Request $request, $reimId)
    {
        if(!canView('/ie/reimbursements') && !canEnter('/ie/reimbursements')) {
            return redirect()->back()->withErrors(trans('403'));
        }

        $reim = Reimbursement::find($reimId);
        if(!$reim){ abort(404); }

        $reim->request_date = dateFormatDisplay($reim->request_date);
        $reim->gl_date = dateFormatDisplay($reim->gl_date);
        $reim->due_date = dateFormatDisplay($reim->due_date);
        $reim->rate_date = dateFormatDisplay($reim->rate_date);
        $requester = optional($reim->requester)->user;

        $orgId = $reim->org_id;

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
        
        $defaultBank = $reim->bank_name;
        $accountLists = $requester->userAccounts;
        $defaultAccountNo = $reim->account_no;
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

        $defaultSupplierId = $reim->vendor_id;
        $defaultSupplierSiteId = $reim->vendor_site_id;

        $defaultPaymentMethod = optional(APPaymentMethod::active()->whereRaw('UPPER(payment_method_code) = ?', [strtoupper('Transfer')])->first())->payment_method_code ?? 'Transfer';

        $APPaymentMethodLists = APPaymentMethod::active()
            ->pluck('payment_method_name','payment_method_code')
            ->all();

        $APPaymentTerms = APPaymentTerm::all();
        $APPaymentTermLists = APPaymentTerm::select(\DB::raw("payment_term_id || ' : ' || payment_term_name AS full_description"),'payment_term_id')
            ->orderBy('payment_term_id')
            ->pluck('full_description','payment_term_id')
            ->all();

        return view('ie.reimbursements._form_edit', compact(
            'reim',
            'requester',
            'bankLists',
            'defaultBank',
            'accountLists',
            'defaultAccountNo',
            'currencyLists',
            'ouLists',
            'defaultSupplierId',
            'defaultSupplierSiteId',
            'employeeLists',
            'userLists',
            'supplierLists',
            'defaultPaymentMethod',
            'APPaymentMethodLists',
            'APPaymentTerms',
            'APPaymentTermLists'
        ));
    }

    public function update(Request $request, $reimId)
    {
        if(!canEnter('/ie/reimbursements')) {
            return redirect()->back()->withErrors(trans('403'));
        }

        \DB::beginTransaction();
        try {

            $reim = Reimbursement::find($reimId);
            $emp = HREmployee::find($request->requester_id);
            $reim->user_id = optional($emp->user)->user_id;
            $reim->invoice_no = $request->invoice_no;
            // if(!$reim->receipts->count()){
                $reim->org_id = $request->org_id;
                $reim->request_date = \DateTime::createFromFormat(trans('date.format'), $request->request_date)->format('Y-m-d');
                $reim->gl_date = \DateTime::createFromFormat(trans('date.format'), $request->gl_date)->format('Y-m-d');
            // }
            $orgId = $reim->org_id;

            $reim->currency_id  = $request->currency_id;
            $reim->exchange_rate = $reim->currency_id == 'THB' ? 1 : $request->exchange_rate;
            $reim->rate_date = $reim->currency_id == 'THB' ? null : ($request->rate_date ? \DateTime::createFromFormat(trans('date.format'), $request->rate_date)->format('Y-m-d') : null);

            $checkChangeDFF = ($reim->requester_id != $request->requester_id) 
                || ($reim->pay_to_emp != $request->pay_to_emp) 
                || ($reim->vendor_id != $request->supplier_id)
                || ($reim->vendor_site_id != $request->supplier_site_id);
            $reim->vendor_id = $request->supplier_id;
            $reim->vendor_site_id = $request->supplier_site_id;

            if(Reimbursement::checkDupInvNo($orgId, $reim->vendor_id, $reim->invoice_no)){
                return redirect()->back()->withErrors('Duplicate Invoice');
            }

            $supplier = Vendor::where('vendor_id', $reim->vendor_id)
            ->where('vendor_site_id', $reim->vendor_site_id)
            ->whereOrgId($orgId)
            ->first();
            if($supplier){
                $reim->vendor_bank_name = optional($supplier->bank)->short_bank_name;
                $reim->vendor_bank_account_no = optional($supplier->bank)->bank_account_num;
            }
            
            $reim->due_date = $reim->gl_date;
            // $reim->due_date = \DateTime::createFromFormat(trans('date.format'), $request->due_date)->format('Y-m-d');
            $reim->payment_method_id = $request->payment_method_id;
            // $reim->payment_term_id = $request->payment_term_id;
            $reim->tel = $request->tel;

            $reim->requester_id = $request->requester_id;
            $reim->bank_name = $request->bank_name;
            $reim->account_no = $request->account_no;
            $reim->account_name = $request->account_name;
            $reim->position_name = $request->position_name;
            $reim->department_code = $request->department_code;
            $reim->employee_id = $request->employee_id;
            $reim->pay_to_emp = $request->pay_to_emp;
            // $reim->reimbursement_type = $request->reimbursement_type;

            $reim->purpose  = trim($request->purpose);
            $reim->reason  = trim($request->reason);
            
            $reim->checked_by = $request->checked_by;
            $reim->approved_by = $request->approved_by;

            $reim->last_updated_by = \Auth::user()->user_id;

            ///// DFF /////
            if($checkChangeDFF){
                $groupTaxCode = APReportingEntity::select(\DB::raw("entity_name AS full_description"),'entity_name')
                ->whereOrgId($orgId)
                ->orderBy('entity_name')
                ->first();

                $reim->dff_type = 'invoice';
                $reim->dff_pay_for = $request->pay_to_emp == 'YES' ? optional($reim->user)->name : optional($supplier)->vendor_name;
                $reim->dff_group_tax_code = $groupTaxCode ? $groupTaxCode->entity_name : null;
            }

            $reim->save();

            // $budgetYear = getBudgetYear($reim->gl_date ?? $reim->request_date);

            // ////// UPDATE RECEIPT //////
            // $requester = $reim->user;
            // $orgId = $reim->org_id;

            // $empCode = optional(optional($requester)->PersonalDeptLocation)->dept_cd_f02 ?? null;
            // $findEmp = Employee::where('employee_number', 'like', '%'.$empCode.'%')->first() ?? null;

            // if(!$findEmp){
            //     \DB::rollBack();
            //     return redirect()->route('ie.reimbursements.show', ['reimbursement' => $reim->reimbursement_id])->withErrors('ไม่พบข้อมูล expense_account'); 
            // }

            // foreach ($reim->receipts as $receipt) {
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

        } catch (\Exception $e) {
            \DB::rollBack();

            return redirect()->route('ie.reimbursements.show', ['reimbursement' => $reim->reimbursement_id])->withErrors($e->getMessage());
            // \Log::error($e->getMessage());
        }
        \DB::commit();

        return redirect()->route('ie.reimbursements.show', ['reimbursement' => $reim->reimbursement_id]);
    }

    public function duplicate(Request $request, $reimId)
    {
        if(!canEnter('/ie/reimbursements')) {
            return redirect()->back()->withErrors(trans('403'));
        }

        \DB::beginTransaction();
        try {

            $reim = Reimbursement::find($reimId);
            $orgId = $reim->org_id;

            ////////////////////////////
            // DUPLICATE REIMBURSEMENT
            $newReim = $reim->replicate();
            $currencyType = $reim->currency_id == 'THB' ? 1 : 2 ;
            $newReim->document_no = Reimbursement::genDocumentNo($orgId, $currencyType, $reim->gl_date);
            $newReim->status = "NEW_REQUEST";
            $newReim->encumbrance_flag = 'N';
            $newReim->invoice_no = null;
            $newReim->hierarchy_name_id = null;
            $newReim->hierarchy_name_position_id = null;
            $newReim->last_updated_by = \Auth::user()->user_id;
            $newReim->created_by = \Auth::user()->user_id;
            $newReim->creation_date = Carbon::now();
            $newReim->last_update_date = Carbon::now();
            $newReim->save();

            // ACTIVITY LOG
            $activityLogRepo = new ActivityLogRepo;
            $activityLogRepo->create($newReim, ActivityLogRepo::getActivityMessage('NEW_REQUEST'), 'NEW_REQUEST');

            ////////////////////////////
            // DUPLICATE RECEIPT DATA
            $receipts = $reim->receipts;
            foreach ($receipts as $key => $receipt) {

                $newReceipt = $receipt->replicate();
                $newReceipt->receiptable_id = $newReim->reimbursement_id;
                $newReceipt->last_updated_by = \Auth::user()->user_id;
                $newReceipt->created_by = \Auth::user()->user_id;
                // $newReceipt->creation_date = Carbon::now();
                // $newReceipt->last_update_date = Carbon::now();
                // SAVE RECEIPT DATA
                $newReim->receipts()->save($newReceipt);

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

            // SUCCESS CREATE REIMBURSEMENT
            \DB::commit();
            if($request->ajax()){
                $result['status'] = 'SUCCESS';
                $result['reimId'] = $newReim->reimbursement_id;
                return $result;
            }else{
                return redirect()->route('ie.reimbursements.show', ['reimbursement' => $newReim->reimbursement_id]);
            }

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
                return abort('403');
            }
        }
    }

    public function changeApprover(Request $request, $reimId)
    {

        \DB::beginTransaction();
        try {

            $reim = Reimbursement::find($reimId);
            $reim->next_approver_id = $request->select_approver;
            $reim->save();

            // $next_approver = User::where('user_id', $request->select_approver)->first();
            // $reason = 'เปลี่ยนผู้อนุมัติเป็น ' . optional($next_approver)->name;
            // $activityLogRepo = new ActivityLogRepo;
            // $activityLogRepo->create($reim, ActivityLogRepo::getActivityMessage('CHANGE_APPROVER'), 'CHANGE_APPROVER', $reason);

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

    public function setStatus(Request $request, $reimId)
    {
        if(!canEnter('/ie/reimbursements')) {
            return redirect()->back()->withErrors(trans('403'));
        }

        $activity = $request->activity;
        $reason = '';
        $msg = null;
        if($request->reason){
            $reason = $request->reason;
        }
        // Get REIM Data
        $reim = Reimbursement::find($reimId);
        $reim->last_updated_by = \Auth::user()->user_id;
        $orgId = $reim->org_id;

        // FILE ATTACHMENTS
        if($request->file('file')){
            $attachmentRepo = new AttachmentRepo;
            $attachmentRepo->create($reim, $request->file('file'));
        }

        // Check Permission for Approve
        if(!self::hasPermissionSetStatus($reim,$activity)){  abort(403);  }

        \DB::beginTransaction();
        try {
            // Set STATUS (approve,reject,sendback)
            switch ($activity) {

                // #### REIM REQUEST ####
                case "UNBLOCK":
                    $msg = 'Unblock Success';
                    $reim->status = 'NEW_REQUEST';
                    $reim->save();
                    break;
                case "RESERVE_ENCUMBRANCE":
                    // SET OVER BUDGET & EXCEED POLICY
                    $invoice_no = $reim->invoice_no;
                    if(is_null($invoice_no)){
                        return redirect()->back()->withErrors('กรุณาระบุเลขที่ใบแจ้งหนี้');
                    }
                    $resultOverBudget = RequestRepo::validateIsNotOverBudget($reim);
                    $resultExceedPolicy = RequestRepo::validateIsNotExceedPolicy($reim);
                    $reim->over_budget = !$resultOverBudget['valid'];
                    $reim->exceed_policy = !$resultExceedPolicy['valid'];
                    $reim->save();
                    // INTERFACE ENCUMBRANCE 
                    if( $reim->encumbrance_flag != 'Y'){
                        $batchNo = InterfaceRepo::encumbrance($reim, 'REIMBURSEMENT', 'reserve');
                        $result = InterfaceRepo::submitEncumbrance($batchNo);
                        if($result['status'] == 'C'){
                            $reim->encumbrance_flag = 'Y';
                        }else {
                            \DB::rollBack();
                            $error_msg = optional(InterfaceEncumbrance::where('interface_status', 'E')
                                ->where('batch_no', $batchNo)
                                ->first())->interface_message ?? ($result['message'] ?? 'Encumbrance Error !');
                            return redirect()->back()->withErrors($error_msg);
                        }
                    }
                    $msg = 'Reserve Success';
                    $reim->status = 'RESERVE_ENCUMBRANCE';
                    $reim->save();
                    break;
                case "UNRESERVE_ENCUMBRANCE":
                    // INTERFACE ENCUMBRANCE 
                    if( $reim->encumbrance_flag == 'Y'){
                        $batchNo = InterfaceRepo::encumbrance($reim, 'REIMBURSEMENT', 'return');
                        $result = InterfaceRepo::submitEncumbrance($batchNo);
                        if($result['status'] == 'C'){
                            $reim->encumbrance_flag = 'N';
                        }else {
                            \DB::rollBack();
                            $error_msg = optional(InterfaceEncumbrance::where('interface_status', 'E')
                                ->where('batch_no', $batchNo)
                                ->first())->interface_message ?? $result['message'];
                            return redirect()->back()->withErrors($error_msg);
                        }
                    }
                    $msg = 'Unreserve Success';
                    $reim->status = 'NEW_REQUEST';
                    $reim->next_approver_id = null;
                    $reim->hierarchy_name_position_id = null;
                    $reim->hierarchy_name_id = null;
                    $reim->over_budget = null;
                    $reim->exceed_policy = null;
                    $reim->save();
                    break;
                case "SEND_REQUEST":
                    // $checkDupInv = Reimbursement::checkDupInvNo($orgId, $reim->vendor_id, $request->invoice_no);
                    // if($checkDupInv){
                    //     return redirect()->back()->withErrors('มี invoice number นี้แล้วในระบบ');
                    // }
                    // SET INVOICE DATA
                    // $reim->invoice_no = $request->invoice_no;
                    $reim->invoice_date = $request->invoice_date ? \DateTime::createFromFormat(trans('date.format'), $request->invoice_date)->format('Y-m-d') : null;
                    // CHECK FOUND APPROVER OR NOT ?
                    $reim->hierarchy_name_id = $request->hierarchy_name_id;
                    $nextApprover = ApprovalRepo::getNextApprover($reim,'REIMBURSEMENT');
                    if($nextApprover){ // IF FOUND NEXT APPROVER SET STATUS = 'APPROVER_DECISION'
                        $reim->next_approver_id = $nextApprover['user_id'];
                        $reim->hierarchy_name_position_id = $nextApprover['hierarchy_name_position_id'];
                        
                        $msg = 'Send Request Success';
                        $reim->status = 'APPROVER_DECISION';
                        $reim->save();
                    }else{ // IF NOT FOUND NEXT APPROVER AUTO SET STATUS TO APPROVED
                        \DB::rollBack();
                        return redirect()->back()->withErrors('ไม่พบสายอนุมัติ');
                        // if( $reim->encumbrance_flag == 'Y'){
                        //     $batchNo = InterfaceRepo::encumbrance($reim, 'REIMBURSEMENT', 'return');
                        //     $result = InterfaceRepo::submitEncumbrance($batchNo);
                        //     if($result['status'] == 'C'){
                        //         $reim->encumbrance_flag = 'N';
                        //         $reim->save();
                        //         \DB::commit();
                        //     }else {
                        //         \DB::rollBack();
                        //         $error_msg = optional(InterfaceEncumbrance::where('interface_status', 'E')
                        //             ->where('batch_no', $batchNo)
                        //             ->first())->interface_message ?? $result['message'];
                        //         return redirect()->back()->withErrors($error_msg);
                        //     }
                        // }
                        // $reim->invoice_no = $reim->invoice_no ?? Reimbursement::genInvoiceNo($orgId, $reim->vendor_id, $reim->reimbursement_type, $reim->gl_date);
                        // // INTERFACE TO ORACLE AP INVOICE
                        // $interfaceHeaderId = InterfaceRepo::invoice($reim,'REIMBURSEMENT');
                        // $result = InterfaceRepo::submitInterface($interfaceHeaderId);
                        // if($result['status'] == 'C'){
                        //     $reim->status = 'APPROVED';
                        // }else {
                        //     \DB::rollBack();
                        //     $error_msg = optional(InterfaceAPHeader::where('interface_status', 'E')
                        //         ->where('interface_ap_header_id', $interfaceHeaderId)
                        //         ->first())->interface_message ?? $result['message'];
                        //     return redirect()->back()->withErrors($error_msg);
                        // }
                        // $msg = 'Approve Success';
                        // $reim->next_approver_id = null;
                        // $reim->hierarchy_name_position_id = null;
                        // $reim->hierarchy_name_id = null;
                        // $reim->save();
                    }
                    break;
                case "APPROVER_APPROVE":
                    $msg = 'Approve Success';
                    // DO APPROVE PROCESS
                    $approvalRepo = new ApprovalRepo;
                    $approvalRepo->approve($reim,'REIMBURSEMENT','APPROVER');
                    // CHECK FOUND NEXT APPROVER OR NOT ?
                    $nextApprover = ApprovalRepo::getNextApprover($reim,'REIMBURSEMENT');
                    if($nextApprover){ // IF FOUND NEXT APPROVER SET STATUS = 'APPROVER_DECISION'
                        $reim->next_approver_id = $nextApprover['user_id'];
                        $reim->hierarchy_name_position_id = $nextApprover['hierarchy_name_position_id'];
                        $reim->save();
                    }else{ // IF NOT FOUND NEXT APPROVER SET STATUS = 'APPROVED'
                        // INTERFACE ENCUMBRANCE
                        if( $reim->encumbrance_flag == 'Y'){
                            $batchNo = InterfaceRepo::encumbrance($reim, 'REIMBURSEMENT', 'return');
                            $result = InterfaceRepo::submitEncumbrance($batchNo);
                            if($result['status'] == 'C'){
                                $reim->encumbrance_flag = 'N';
                                $reim->save();
                                \DB::commit();
                            }else {
                                \DB::rollBack();
                                $error_msg = optional(InterfaceEncumbrance::where('interface_status', 'E')
                                    ->where('batch_no', $batchNo)
                                    ->first())->interface_message ?? ($result['message'] ?? 'Encumbrance Error !');
                                return redirect()->back()->withErrors($error_msg);
                            }
                        }
                        $reim->invoice_no = $reim->invoice_no ?? Reimbursement::genInvoiceNo($orgId, $reim->vendor_id, $reim->reimbursement_type, $reim->gl_date);
                        // INTERFACE TO ORACLE AP INVOICE
                        $interfaceHeaderId = InterfaceRepo::invoice($reim,'REIMBURSEMENT');
                        $result = InterfaceRepo::submitInterface($interfaceHeaderId);
                        if($result['status'] == 'C'){
                            $reim->status = 'APPROVED';
                        }else {
                            \DB::rollBack();
                            $error_msg = optional(InterfaceAPHeader::where('interface_status', 'E')
                                ->where('interface_ap_header_id', $interfaceHeaderId)
                                ->first())->interface_message ?? $result['message'];
                            return redirect()->back()->withErrors($error_msg);
                        }
                        $reim->next_approver_id = null;
                        $reim->hierarchy_name_position_id = null;
                        $reim->hierarchy_name_id = null;
                        $reim->save();
                    }
                    break;
                case "APPROVER_SENDBACK":
                    $msg = 'Send Back Success';
                    // SET STATUS BACK TO 'NEW_REQUEST'
                    if( $reim->encumbrance_flag == 'Y'){
                        $batchNo = InterfaceRepo::encumbrance($reim, 'REIMBURSEMENT', 'return');
                        $result = InterfaceRepo::submitEncumbrance($batchNo);
                        if($result['status'] == 'C'){
                            $reim->encumbrance_flag = 'N';
                        }else {
                            \DB::rollBack();
                            $error_msg = optional(InterfaceEncumbrance::where('interface_status', 'E')
                                ->where('batch_no', $batchNo)
                                ->first())->interface_message ?? ($result['message'] ?? 'Encumbrance Error !');
                            return redirect()->back()->withErrors($error_msg);
                        }
                    }
                    $reim->status = 'NEW_REQUEST';
                    $reim->next_approver_id = null;
                    $reim->hierarchy_name_position_id = null;
                    $reim->hierarchy_name_id = null;
                    $reim->over_budget = null;
                    $reim->exceed_policy = null;
                    $reim->save();
                    break;
                case "APPROVER_REJECT":
                    $msg = 'Reject Success';
                    if( $reim->encumbrance_flag == 'Y'){
                        $batchNo = InterfaceRepo::encumbrance($reim, 'REIMBURSEMENT', 'return');
                        $result = InterfaceRepo::submitEncumbrance($batchNo);
                        if($result['status'] == 'C'){
                            $reim->encumbrance_flag = 'N';
                        }else {
                            \DB::rollBack();
                            $error_msg = optional(InterfaceEncumbrance::where('interface_status', 'E')
                                ->where('batch_no', $batchNo)
                                ->first())->interface_message ?? ($result['message'] ?? 'Encumbrance Error !');
                            return redirect()->back()->withErrors($error_msg);
                        }
                    }
                    $reim->status = 'APPROVER_REJECTED';
                    $reim->next_approver_id = null;
                    $reim->hierarchy_name_position_id = null;
                    $reim->hierarchy_name_id = null;
                    $reim->save();
                    break;
                case "CANCEL_REQUEST":
                    $msg = 'Cancel Success';
                    // SET STATUS TO 'CANCELLED'
                    $reim->status = 'CANCELLED';
                    $reim->save();
                    break;
            }

            // ACTIVITY LOG
            $activityLogRepo = new ActivityLogRepo;
            $activityLogRepo->create($reim, ActivityLogRepo::getActivityMessage($activity,$reim),$activity,$reason);

            // RESET APPROVAL (ACTIVITY SENDBACK ONLY)
            self::resetApproval($activity,$reim);

            // SEND EMAIL
            // self::sendEmailByActivity($activity,$reim,$reason);

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error($e->getMessage());

            return redirect()->route('ie.reimbursements.show', ['reimbursement'=> $reimId])->withErrors([$e->getMessage()]);;
        }
        \DB::commit();

        // REDIRECT AFTER SET STATUS
        return redirect()->route('ie.reimbursements.show', ['reimbursement' => $reimId])->with('success', $msg);

    }

    ////////////////////////////
    //// SET DUE DATE
    public function setDueDate(SetDueDateRequest $request, $reimId)
    {
        if(!canEnter('/ie/cash-advances')) {
            return redirect()->back()->withErrors(trans('403'));
        }

        $reim = Reimbursement::find($reimId);

        \DB::beginTransaction();
        try {
            // SET DUE DATE
            if($request->due_date){

                $reim->due_date = \DateTime::createFromFormat(trans('date.format'), $request->due_date)->format('Y-m-d');
                $reim->payment_method_id = $request->payment_method_id;
                $reim->payment_term_id = $request->payment_term_id;

            }else{
                $reim->due_date = null;
            }
            $reim->last_updated_by = \Auth::user()->user_id;
            $reim->save();

             // ACTIVITY LOG
            $activityLogRepo = new ActivityLogRepo;
            $activityLogRepo->create($reim, ActivityLogRepo::getActivityMessage('SET_DUE_DATE'), 'SET_DUE_DATE');

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error($e->getMessage());
        }
        \DB::commit();

        return redirect()->route('ie.reimbursements.show',['reimbursement'=>$reimId]);
    }

    public function addAttachment(Request $request, $reimId)
    {
        if(!canEnter('/ie/reimbursements')) {
            return redirect()->back()->withErrors(trans('403'));
        }

        $reim = Reimbursement::find($reimId);

        \DB::beginTransaction();
        try {

            if($request->file('file')){
                $attachmentRepo = new AttachmentRepo;
                $attachmentRepo->create($reim, $request->file('file'));
            }

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error($e->getMessage());
        }
        \DB::commit();

        return redirect()->route('ie.reimbursements.show', ['reimbursement' => $reim->reimbursement_id]);
        // return redirect()->back();
    }

    //////////////////////////
    //// GET TOTAL AMOUNT
    public function getTotalAmount(Request $request, $reimId)
    {
        $reim = Reimbursement::find($reimId);
        if(!$reim){ throw new Exception("Error Processing Request", 1); }
        $reimTotalAmount = $reim->total_receipt_amount + 0;
        return numberFormatDisplay($reimTotalAmount);
    }

    //////////////////////////////////
    //// COMBINE GL CODE COMBINATION
    public function combineReceiptGLCodeCombination(Request $request, $reimId)
    {
        try {

            $reim = Reimbursement::find($reimId);
            if(!$reim){
                throw new \Exception("Not found reimbursement data.", 1);
            }
            // $result = RequestRepo::combineReceiptGLCodeCombination($reim);
            $result = ['status'=>'success','err_msg'=>'','err_receipt_line_id'=>null];

        } catch (\Exception $e) {
            if($request->ajax()){
                return \Response::json(['status'                =>  'error',
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
    public function checkOverBudget(Request $request, $reimId)
    {
        $reim = Reimbursement::find($reimId);
        if(!$reim){
            throw new \Exception("Not found reimbursement data.", 1);
        }
        $result = RequestRepo::validateIsNotOverBudget($reim);

        if($request->ajax()){
            return \Response::json($result, 200);
        }else{
            return $result;
        }
    }

    //////////////////////////
    //// CHECK EXCEED POLICY
    public function checkExceedPolicy(Request $request, $reimId)
    {
        $reim = Reimbursement::find($reimId);
        if(!$reim){
            throw new \Exception("Not found reimbursement data.", 1);
        }
        $result = RequestRepo::validateIsNotExceedPolicy($reim);

        if($request->ajax()){
            return \Response::json($result, 200);
        }else{
            return $result;
        }
    }

    //////////////////////////////
    //// validateReceipt
    public function validateReceipt(Request $request, $reimId)
    {
        $reim = Reimbursement::find($reimId);
        if(!$reim){
            throw new \Exception("Not found reimbursement data.", 1);
        }
        $result = RequestRepo::validateReceipt($reim, 'REIMBURSEMENT');

        if($request->ajax()){
            return \Response::json($result, 200);
        }else{
            return $result;
        }
    }

    public function formSendRequestWithReason(Request $request, $reimId)
    {
        $title = ''; $text = '';
        $reim = Reimbursement::find($reimId);
        if(!$reim){ return ; }

        $resultOverBudget = RequestRepo::validateIsNotOverBudget($reim);
        $resultExceedPolicy = RequestRepo::validateIsNotExceedPolicy($reim);
        $notOverBudget = $resultOverBudget['valid'];
        $notExceedPolicy = $resultExceedPolicy['valid'];
        if(!$notOverBudget && !$notExceedPolicy){
            $title = 'Request Over Budget & Exceed Policy !';
            $text = 'please enter reason for request over budget and exceed policy, please contact HR for approval and <strong><u>send the original receipt and supporting document to Accounting Dept. (กรุณาส่งเอกสารให้แผนกบัญชีเพื่อดำเนินการ)</u></strong>.';
        }elseif(!$notOverBudget){
            $title = 'Request Over Budget !';
            $text = 'please enter reason for request over budget, please contact HR for approval and <strong><u>send the original receipt and supporting document to Accounting Dept. (กรุณาส่งเอกสารให้แผนกบัญชีเพื่อดำเนินการ)</u></strong>.';
        }elseif(!$notExceedPolicy){
            $title = 'Request Exceed Policy !';
            $text = 'please enter reason for request exceed policy please contact HR for approval and <strong><u>send the original receipt and supporting document to Accounting Dept. (กรุณาส่งเอกสารให้แผนกบัญชีเพื่อดำเนินการ)</u></strong>.';
        }

        return view('ie.reimbursements.show._form_send_request_with_reason',
                        compact('reim','title','text'));

    }

    private static function hasPermissionSetStatus($reim,$activity)
    {
        $permit = false;
        switch ($activity) {
            case "UNBLOCK":
                if($reim->status == 'BLOCKED'
                    && \Auth::user()->isUnblocker()){
                    $permit = true;
                }
                break;
            case "RESERVE_ENCUMBRANCE":
                if($reim->status == 'NEW_REQUEST'){
                    $permit = true;
                }
                break;
            case "UNRESERVE_ENCUMBRANCE":
                if($reim->status == 'RESERVE_ENCUMBRANCE'){
                    $permit = true;
                }
                break;
            case "SEND_REQUEST":
                if($reim->status == 'RESERVE_ENCUMBRANCE'){
                    $permit = true;
                }
                break;
            case "APPROVER_APPROVE":
                if($reim->status == 'APPROVER_DECISION'
                    && $reim->isNextApprover()){
                    $permit = true;
                }
                break;
            case "APPROVER_SENDBACK":
                if($reim->status == 'APPROVER_DECISION'
                    && $reim->isNextApprover()){
                    $permit = true;
                }
                break;
            case "APPROVER_REJECT":
                if($reim->status == 'APPROVER_DECISION'
                    && $reim->isNextApprover()){
                    $permit = true;
                }
                break;
            case "CANCEL_REQUEST":
                if(($reim->status == 'NEW_REQUEST' || $reim->status == 'BLOCKED')){
                    $permit = true;
                }
                break;
        }
        return $permit;
    }

    private static function resetApproval($activity,$reim)
    {
        switch ($activity) {
            case "APPROVER_SENDBACK":
                // RESET RECENT APPROVAL PROCESS
                $approvalRepo = new ApprovalRepo;
                $approvalRepo->reset($reim,'REIMBURSEMENT');
                break;
        }
    }

    private static function sendEmailByActivity($activity,$reim,$reason)
    {
        $financeUsers = User::active()->isFinance()->get(); // FINANCE
        $composedFinanceUsers = MailRepo::composeReceivers($financeUsers);

        switch ($activity) {

            // #### REIM REQUEST ####
            case "UNBLOCK":

                $receivers = MailRepo::composeReceivers($reim->user); // REQUESTER
                $ccReceivers = MailRepo::composeReceivers($financeUsers); // FINANCE

                MailRepo::unblock('REIMBURSEMENT',$reim,$receivers,$ccReceivers,$reason);

                break;

            case "SEND_REQUEST":

                $ccReceivers = MailRepo::composeReceivers(\Auth::user()); // REQUESTER

                if($reim->approver){
                    // IF HAVE APPROVER
                    $receivers = MailRepo::composeReceivers($reim->approver); // NEXT APPROVER
                    if(count($composedFinanceUsers) > 0){
                        foreach ($composedFinanceUsers as $composedFinanceUser) {
                            array_push($ccReceivers, $composedFinanceUser);
                        }
                    }
                    MailRepo::sendRequest('REIMBURSEMENT',$reim,$receivers,$ccReceivers,$reason);
                }else{
                    // IF NOT HAVE APPROVER
                    $receivers = MailRepo::composeReceivers($financeUsers);
                    MailRepo::sendRequest('REIMBURSEMENT',$reim,$receivers,$ccReceivers,$reason,'TO-FINANCE-DEPT');
                }

                break;

            case "APPROVER_APPROVE":

                // IF FOUND NEXT APPROVER
                if($reim->next_approver_id){
                    $receivers = MailRepo::composeReceivers($reim->approver); // NEXT APPROVER
                    $ccReceivers = MailRepo::composeReceivers($reim->user); // REQUESTER
                    $relatedApprovers = ApprovalRepo::getRelatedApprovers($reim,'REIMBURSEMENT','APPROVER'); // RELATED APPROVERS
                    $relatedApproverCCReceivers = MailRepo::composeReceivers($relatedApprovers);
                    if(count($relatedApproverCCReceivers) > 0){
                        foreach ($relatedApproverCCReceivers as $relatedApproverCCReceiver) {
                            array_push($ccReceivers, $relatedApproverCCReceiver);
                        }
                    }
                // IF APPROVER APPROVE COMPLETED
                }else{
                    $receivers = MailRepo::composeReceivers($reim->user); // REQUESTER;
                    $relatedApprovers = ApprovalRepo::getRelatedApprovers($reim,'REIMBURSEMENT','APPROVER'); // RELATED APPROVERS
                    $ccReceivers = MailRepo::composeReceivers($relatedApprovers);
                }
                if(count($composedFinanceUsers) > 0){
                    foreach ($composedFinanceUsers as $composedFinanceUser) {
                        array_push($ccReceivers, $composedFinanceUser);
                    }
                }

                MailRepo::approverProcess('REIMBURSEMENT',$reim,'APPROVE',$receivers,$ccReceivers,$reason);

                break;

            case "APPROVER_SENDBACK":

                $receivers = MailRepo::composeReceivers($reim->user); // REQUESTER;
                $relatedApprovers = ApprovalRepo::getRelatedApprovers($reim,'REIMBURSEMENT','APPROVER'); // RELATED APPROVERS
                $ccReceivers = MailRepo::composeReceivers($relatedApprovers);
                if(count($composedFinanceUsers) > 0){
                    foreach ($composedFinanceUsers as $composedFinanceUser) {
                        array_push($ccReceivers, $composedFinanceUser);
                    }
                }

                MailRepo::approverProcess('REIMBURSEMENT',$reim,'SENDBACK',$receivers,$ccReceivers,$reason);

                break;

            case "APPROVER_REJECT":

                $receivers = MailRepo::composeReceivers($reim->user); // REQUESTER;
                $relatedApprovers = ApprovalRepo::getRelatedApprovers($reim,'REIMBURSEMENT','APPROVER'); // RELATED APPROVERS
                $ccReceivers = MailRepo::composeReceivers($relatedApprovers);
                if(count($composedFinanceUsers) > 0){
                    foreach ($composedFinanceUsers as $composedFinanceUser) {
                        array_push($ccReceivers, $composedFinanceUser);
                    }
                }

                MailRepo::approverProcess('REIMBURSEMENT',$reim,'REJECT',$receivers,$ccReceivers,$reason);

                break;

        }

    }

    // public function export(Request $request)
    // {
    //     $yearShowing = $request->year_showing;
    //     $search = [
    //         'document_no'=>$request->document_no,
    //         'status'=>$request->status
    //     ];
    //     $search_date = [
    //         'date_from'=>$request->date_from,
    //         'date_to'=>$request->date_to
    //     ];
    //     $reims = Reimbursement::orderBy('creation_date','desc')
    //                     ->whereOrgId($this->orgId)
    //                     ->byRelatedUser()
    //                     ->byYearShowing($yearShowing)
    //                     ->with('user')
    //                     ->search($search,$search_date)
    //                     ->get();
    //     // if(!$reims){ abort(403); }

    //     $establishmentLists = Establishment::whereOrgId($reim->orgId)->pluck('establishment_name','establishment_id')->all();
    //     $vendorLists = Vendor::select(\DB::raw("vendor_no || ' : ' || vendor_name AS vendor_name"),'vendor_id')->whereOrgId($reim->orgId)->pluck('vendor_name','vendor_id')->all();
    //     // $projectLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->project()->orderBy('flex_value')->pluck('full_description','flex_value')->all();
    //     // $rechargeLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->interCompany()->orderBy('flex_value')->pluck('full_description','flex_value')->all();

    //     $branchLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->EVM($reim->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();
    //     $departmentLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->department($this->orgId)->orderBy('flex_value')->pluck('full_description','flex_value')->all();


    //     \Excel::create('RE_'.Carbon::now(), function($excel) use ($reims,$establishmentLists,$vendorLists,$branchLists,$departmentLists) {

    //         $excel->sheet('Report', function($sheet) use ($reims,$establishmentLists,$vendorLists,$branchLists,$departmentLists) {

    //             $sheet->loadView('ie.reimbursements.export._template', compact('reims','establishmentLists','vendorLists','projectLists','rechargeLists','branchLists','departmentLists'));

    //         });

    //     })->export('xlsx');
    // }

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
                            ->where('vendor_name', 'like', '%เจ้าหนี้-เบ็ดเตล็ด%')
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
            'status' => 's'
        ];

        return response()->json($data);
    }

    public function updateDFF(Request $request, $reimId)
    {
        \DB::beginTransaction();
        try {

            $reim = Reimbursement::find($reimId);

            $reim->dff_type = $request->dff_type;
            $reim->dff_pay_for = $request->pay_for;
            $reim->dff_group_tax_code = $request->group_tax_code;
            $reim->dff_tax_invoice_number = $request->tax_invoice_number;
            $reim->dff_tax_invoice_date = $request->tax_invoice_date ? \DateTime::createFromFormat(trans('date.format'), $request->tax_invoice_date)->format('Y-m-d') : null;
            $reim->dff_po_ref_number = $request->dff_type == 'cash_advance' ? null : $request->po_ref_number;
            $reim->dff_paid_number = $request->dff_type == 'cash_advance' ? null : $request->paid_number;
            $reim->dff_address = $request->address;
            $reim->dff_branch_number = $request->branch_number;
            $reim->dff_tax_id = $request->tax_id;

            $reim->save();

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

    public function formSendRequest(Request $request, $reimId)
    {
        $reim = Reimbursement::find($reimId);
        $reim->invoice_date = dateFormatDisplay($reim->invoice_date);

        $hierarchyTypeLists = HierarchyType::orderBy('name')->get();

        $defaultType = $hierarchyTypeLists->where('department_flag', true)->first();

        $setupLists = $defaultType ? HierarchySetup::whereHas('topic', function($q){
            return $q->where('code', $this->approveCode);
        })
        ->where('hierarchy_type_id', $defaultType->hierarchy_type_id)
        ->whereHas('department', function($q) use($reim){
            return $q->where(function($p) use($reim){
                return $p->where('child_flex_value_low', '<=', $reim->department_code)
                    ->where('child_flex_value_high', '>=', $reim->department_code);
            })
            ->orWhere('value_code', $reim->department_code);
        })
        ->with('department')
        ->get() : collect();

        return view('ie.reimbursements.show._form_send_request', compact(
            'reim',
            'hierarchyTypeLists',
            'defaultType',
            'setupLists'
        ));
    }

    public function getHierarchies(Request $request, $reimId)
    {
        $reim = Reimbursement::find($reimId);

        $typeId = $request->type_id;

        $hierarchyType = HierarchyType::find($typeId);

        $setupLists = HierarchySetup::whereHas('topic', function($q){
            return $q->where('code', $this->approveCode);
        })
        ->where('hierarchy_type_id', $typeId)
        ->when($hierarchyType->department_flag, function($q) use($reim) {
            return $q->whereHas('department', function($p) use($reim){
                return $p->where(function($r) use($reim){
                    return $r->where('child_flex_value_low', '<=', $reim->department_code)
                        ->where('child_flex_value_high', '>=', $reim->department_code);
                })
                ->orWhere('value_code', $reim->department_code);
            });
        })
        ->with('department')
        ->get();

        return view('ie.reimbursements.show._ddl_hierarchies', compact(
            'reim',
            'setupLists'
        ));
    }

    public function getHierarchyUserLists(Request $request, $reimId)
    {
        $reim = Reimbursement::find($reimId);

        $nameId = $request->name_id;

        $hierarchy = HierarchyName::find($nameId);

        return view('ie.reimbursements.show._hierarchy_user_list', compact(
            'reim',
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