<?php

namespace App\Http\Controllers\IE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\IE\AttachmentRepo;

use App\Models\IE\Receipt;
use App\Models\IE\ReceiptLine;
use App\Models\IE\ReceiptLineInfo;
use App\Models\IE\CashAdvance;
use App\Models\IE\Reimbursement;
use App\Models\IE\Invoice;
use App\Models\IE\Category;
use App\Models\IE\SubCategory;
use App\Models\IE\SubCategoryInfo;
use App\Models\IE\Currency;
use App\Models\IE\Location;
use App\Models\IE\Establishment;
use App\Models\IE\Vendor;
use App\Models\IE\FNDListOfValues;
use App\Models\IE\Employee;
use App\Models\IE\APReportingEntity;

use Carbon\Carbon;
use App\Repositories\IE\InterfaceRepo;

class ReceiptController extends Controller
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

    public function show($receiptId)
    {
        // GET RECEIPT DATA
        $receipt = Receipt::find($receiptId);
        $receipt->receipt_date = dateFormatDisplay($receipt->receipt_date);
        $receiptParentId = $receipt->receiptable_id;
        $receiptType = $receipt->receipt_type;
        $parent = $receipt->parent;
        $receiptLines = $receipt->lines;
        $orgId = $parent->org_id;

        // GET LIST DATA (CHANGE WHEN CONNECT ORACLE)
        $categoryLists = Category::active()
                                ->pluck('name','category_id')
                                ->all();
        $currencyLists = Currency::pluck('currency_code','currency_code')->all();
        $parentCurrencyId = $parent->currency_id;
        
        $branchLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->EVM()->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $departmentLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->department()->enabled()->orderBy('flex_value')->pluck('full_description','flex_value')->all();

        return view('ie.commons.receipts.show',
                        compact('receipt',
                                'parent',
                                'receiptParentId',
                                'receiptType',
                                'categoryLists',
                                'currencyLists',
                                'parentCurrencyId',
                                'receiptLines',
                                'branchLists',
                                'departmentLists',
                            ));
    }

    public function formCreate(Request $request)
    {
        // GET RECEIPT DATA
        $receiptParentId = $request->receipt_parent_id;
        $receiptType = $request->receipt_type;
        if( in_array($receiptType, ['CASH-ADVANCE', 'CLEARING']) ){
            $parent = CashAdvance::find($receiptParentId);
        }elseif($receiptType == 'REIMBURSEMENT'){
            $parent = Reimbursement::find($receiptParentId);
        }
        $parentCurrencyId = $parent->currency_id;

        $orgId = $parent->org_id;

        $requester = $parent->user;

        // GET LIST DATA (CHANGE WHEN CONNECT ORACLE)
        $employeeLists = [];

        $bankLists = $requester->userAccounts()
                    ->select(\DB::raw("bank_name AS full_description"),'bank_name')
                    ->orderBy('bank_name')
                    ->pluck('full_description','bank_name')
                    ->all();

        $empCode = optional(optional($requester)->PersonalDeptLocation)->dept_cd_f02 ?? null;
        if($empCode){
            $employeeLists = Employee::select(\DB::raw("employee_number || ' : ' || last_name || ' - ' || first_name AS full_description"), 'employee_id')
                                    // ->where('employee_number', 'like', '%'.$empCode.'%')
                                    ->HasExpenseAccount()
                                    ->orderBy('employee_number')
                                    ->pluck('full_description', 'employee_id')
                                    ->all();
        }
        $defaultEmpCode = Employee::where('employee_number', 'like', '%'.$empCode.'%')->first()->employee_id ?? null;

        $currencyLists = Currency::pluck('currency_code','currency_code')->all();
        // change in production when set location establishment
        $defaultEstablishmentId = -1;
        $establishmentLists = Establishment::whereOrgId($orgId)->pluck('establishment_name','establishment_id')->all();

        $exceptVendor = Vendor::whereOrgId($orgId)
            ->where('vendor_name', 'like', '%เจ้าหนี้-เบ็ดเตล็ด%')
            ->orderBy('vendor_id')
            ->first();

        $defaultVendorId = in_array($receiptType, ['REIMBURSEMENT']) ? ($exceptVendor->vendor_id != $parent->vendor_id ? $parent->vendor_id : null) : null;
        $vendorLists = Vendor::select(\DB::raw("vendor_no || ' : ' || vendor_name AS vendor_name"),'vendor_id')->pluck('vendor_name','vendor_id')->all();
        $vendorSite = Vendor::where('vendor_id', $defaultVendorId)->where('vendor_site_id', $parent->vendor_site_id)->first();
        $defaultVendorSiteCode = in_array($receiptType, ['REIMBURSEMENT']) ? ($vendorSite ? $vendorSite->vendor_site_code : null) : null;
        if(in_array($receiptType, ['REIMBURSEMENT'])){
            $vendorSiteLists = Vendor::notEmp()->select(\DB::raw("vendor_site_code AS full_description"),'vendor_site_code')
                            ->where('vendor_id', $defaultVendorId)->orderBy('vendor_site_code')
                            ->pluck('full_description','vendor_site_code')->all();
        }else {
            $vendorSiteLists = [];
        }

        return view('ie.commons.receipts._form_create',
        compact(
            'parent',
            'receiptParentId',
            'receiptType',
            // 'baseCurrencyId',
            'employeeLists',
            'parentCurrencyId',
            'currencyLists',
            'establishmentLists',
            'defaultVendorId',
            'defaultVendorSiteCode',
            'defaultEstablishmentId',
            'defaultEmpCode',
            'vendorLists',
            'vendorSiteLists'
        ));
    }

    public function store(Request $request)
    {
        \DB::beginTransaction();
        try {

            // PREPARE PARENT DATA
            $receiptParentId = $request->receipt_parent_id;
            $receiptType = $request->receipt_type;
            
            if( in_array($receiptType, ['CASH-ADVANCE', 'CLEARING']) ){
                $parent = CashAdvance::find($receiptParentId);
            }elseif($receiptType == 'REIMBURSEMENT'){
                $parent = Reimbursement::find($receiptParentId);
            }
            if(!$parent->isPendingReceipt()){
                throw new \Exception("Request enable to add receipt now.", 1);
            }
            $parentCurrencyId = $parent->currency_id;
            $orgId = $parent->org_id;

            // CREATE RECEIPT DATA
            $receipt = new Receipt();
            $receipt->process_type = $request->receipt_type;
            $receipt->receipt_number = $request->receipt_number ? $request->receipt_number : null;
            $receipt->receipt_date = $request->receipt_date ? \DateTime::createFromFormat(trans('date.format'), $request->receipt_date)->format('Y-m-d') : null;
            $receipt->location_id = -1; //$request->location_id;
            $receipt->currency_id = $request->currency_id ?? $parentCurrencyId;
            if($request->currency_id != $parentCurrencyId){
                $receipt->exchange_rate = $request->exchange_rate;
            }
            if($request->establishment_id){
                $establishment = Establishment::whereOrgId($orgId)->where('establishment_id',$request->establishment_id)->first();
                $receipt->establishment_id = $establishment->establishment_id;
                $receipt->establishment_name = $establishment->establishment_name;
            }

            $receipt->vendor_id = $request->vendor_id ? $request->vendor_id : null;
            $receipt->vendor_site_code = $request->vendor_site_code ? $request->vendor_site_code : null;
            $receipt->vendor_name = $request->vendor_name ? $request->vendor_name : null;
            $receipt->vendor_tax_id = $request->vendor_tax_id ? $request->vendor_tax_id : null;
            $receipt->vendor_branch_name = $request->vendor_branch_name ? $request->vendor_branch_name : null;
            $receipt->vendor_tax_address = $request->vendor_tax_address ? $request->vendor_tax_address : null;

            $receipt->jusification = trim($request->jusification);
            $receipt->project = null; // $request->project;
            $receipt->job = $request->job;
            $receipt->recharge = null; // $request->recharge;
            $receipt->employee_id = $request->employee_id;
            $receipt->last_updated_by = \Auth::user()->user_id;
            $receipt->created_by = \Auth::user()->user_id;

            // SAVE RECEIPT DATA
            $parent->receipts()->save($receipt);

            // FILE ATTACHMENTS
            if($request->file('file')){
                $attachmentRepo = new AttachmentRepo;
                $attachmentRepo->create($receipt, $request->file('file'));
            }

            // SUCCESS CREATE CASH ADVANCE
            \DB::commit();

        } catch (\Exception $e) {
            // ERROR CREATE CASH ADVANCE
            \DB::rollBack();
            \Log::error($e->getMessage());
            if($request->ajax()){
                $result['status'] = 'ERROR';
                $result['err_msg'] = $e->getMessage();
                return $result;
            }else{
                return abort('403');
            }
        }

        if($request->ajax()){
            $result['status'] = 'SUCCESS';
            $result['receiptId'] = $receipt->receipt_id;
            return $result;
        }else{
            if( in_array($receiptType, ['CASH-ADVANCE', 'CLEARING']) ){
                return redirect()->route('cash-advances.clear',
                                            ['cashAdvanceId'=>$receiptParentId]);
            }elseif($receiptType == 'REIMBURSEMENT'){
                return redirect()->route('reimbursements.show',
                                            ['reimId'=>$receiptParentId]);
            }
        }
    }

    public function formEdit(Request $request, $receiptId)
    {
        // GET RECEIPT DATA
        $receipt = Receipt::find($receiptId);
        $receipt->receipt_date = dateFormatDisplay($receipt->receipt_date);
        $receiptParentId = $receipt->receiptable_id;
        $receiptType = $receipt->receipt_type;

        $parent = $receipt->parent;
        $requester = $parent->user;
        $orgId = $parent->org_id;

        // GET LIST DATA (CHANGE WHEN CONNECT ORACLE)
        $bankLists = $requester->userAccounts()
                    ->select(\DB::raw("bank_name AS full_description"),'bank_name')
                    ->orderBy('bank_name')
                    ->pluck('full_description','bank_name')
                    ->all();

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

        // $currencyLists = Currency::pluck('currency_code','currency_code')->all();

        $defaultEstablishmentId = $receipt->establishment_id;
        $establishmentLists = Establishment::whereOrgId($orgId)->pluck('establishment_name','establishment_id')->all();
        $vendorLists = Vendor::select(\DB::raw("vendor_no || ' : ' || vendor_name AS vendor_name"),'vendor_id')->pluck('vendor_name','vendor_id')->all();
        if($receipt->vendor_id != 'other'){
            $vendorSiteLists = Vendor::notEmp()->select(\DB::raw("vendor_site_code AS full_description"),'vendor_site_code')
                            ->where('vendor_id',$receipt->vendor_id)->orderBy('vendor_site_code')
                            ->pluck('full_description','vendor_site_code')->all();
        }else {
            $vendorSiteLists = [];
        }

        return view('ie.commons.receipts._form_edit',
            compact(
                'parent',
                'receipt',
                'receiptParentId',
                'receiptType',
                'employeeLists',
                // 'baseCurrencyId',
                // 'currencyLists',
                'defaultEstablishmentId',
                'establishmentLists',
                'vendorLists',
                'vendorSiteLists',
            ));
    }

    public function update(Request $request, $receiptId)
    {
        // PREPARE PARENT DATA
        $receipt = Receipt::find($receiptId);
        $receiptParentId = $receipt->receiptable_id;
        $receiptType = $receipt->receipt_type;
        $parent = $receipt->parent;
        $orgId = $parent->org_id;

        \DB::beginTransaction();
        try {
            // UPDATE RECEIPT
            $checkReceiptNumberUpdate = $receipt->receipt_number != $request->receipt_number;
            $receipt->receipt_number = $request->receipt_number ? $request->receipt_number : null;
            $checkReceiptDateUpdate = dateFormatDisplay($receipt->receipt_date) != $request->receipt_date;
            $receipt->receipt_date = $request->receipt_date ? \DateTime::createFromFormat(trans('date.format'), $request->receipt_date)->format('Y-m-d') : null;
            if($request->establishment_id){
                $establishment = Establishment::whereOrgId($orgId)->where('establishment_id',$request->establishment_id)->first();
                $receipt->establishment_id = $establishment->establishment_id;
                $receipt->establishment_name = $establishment->establishment_name;
            }

            $checkVendorIdUpdate = $receipt->vendor_id != $request->vendor_id;
            $receipt->vendor_id = $request->vendor_id;
            $checkVendorCodeUpdate = $receipt->vendor_site_code != $request->vendor_site_code;
            $receipt->vendor_site_code = $request->vendor_site_code ? $request->vendor_site_code : null;
            $checkVendorNameUpdate = $receipt->vendor_name != $request->vendor_name;
            $receipt->vendor_name = $request->vendor_name ? $request->vendor_name : null;
            $checkVendorTaxIdUpdate = $receipt->vendor_tax_id != $request->vendor_tax_id;
            $receipt->vendor_tax_id = $request->vendor_tax_id ? $request->vendor_tax_id : null;
            $checkVendorBranchUpdate = $receipt->vendor_branch_name != $request->vendor_branch_name;
            $receipt->vendor_branch_name = $request->vendor_branch_name ? $request->vendor_branch_name : null;
            $checkVendorTaxAddressUpdate = $receipt->vendor_tax_address != $request->vendor_tax_address;
            $receipt->vendor_tax_address = $request->vendor_tax_address ? $request->vendor_tax_address : null;

            $receipt->jusification = trim($request->jusification);
            $receipt->project = $request->project;
            $receipt->job = $request->job;
            $receipt->recharge = $request->recharge;
            $receipt->employee_id = $request->employee_id;
            // $receipt->save();
            $parent->receipts()->save($receipt);

            $budgetYear = getBudgetYear($parent->gl_date ?? $parent->request_date);

            // UPDATE RECEIPT LINE

            $emp = $receipt->employee;
            $emp->org_id = $orgId;
            foreach ($receipt->lines as $key => $receiptLine) {
                $lineSubCategory = SubCategory::find($receiptLine->sub_category_id);
                $useAllCOAFlag = $lineSubCategory->use_all_segments;
 
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
                $glCodeCombination = InterfaceRepo::getGLCodeCombinationOfEmpBySegments($emp,$lineSegments);

                $receiptLine->code_combination_id = $glCodeCombination['code_combination_id'];
                $receiptLine->concatenated_segments = $glCodeCombination['concatenated_segments'];

                ///// DFF //////
                if(in_array($receiptType, ['CLEARING', 'REIMBURSEMENT'])){

                    $checkUpdatePayfor = $checkVendorIdUpdate || $checkVendorCodeUpdate || $checkVendorNameUpdate;
                    $checkUpdateAddress = $checkVendorIdUpdate || $checkVendorCodeUpdate || $checkVendorTaxAddressUpdate;
                    $checkUpdateBranchName = $checkVendorIdUpdate || $checkVendorCodeUpdate || $checkVendorBranchUpdate;
                    $checkUpdateTaxId = $checkVendorIdUpdate || $checkVendorCodeUpdate || $checkVendorTaxIdUpdate;
                    
                    $receiptLine->dff_pay_for = $checkUpdatePayfor ? ($receipt->vendor_name ?? ($receipt->vendor_id != 'other' ? optional($receipt->vendor)->vendor_name : null)) : $receiptLine->dff_pay_for;
                    $receiptLine->dff_tax_invoice_number = $checkReceiptNumberUpdate ? $receipt->receipt_number : $receiptLine->dff_tax_invoice_number;
                    $receiptLine->dff_tax_invoice_date = $checkReceiptDateUpdate ? $receipt->receipt_date : $receiptLine->dff_tax_invoice_date;
                    $receiptLine->dff_address = $checkUpdateAddress ? ($receipt->vendor_tax_address ?? ($receipt->vendor_id != 'other' ? optional($receipt->vendor)->getTaxAddress() : null)) : $receiptLine->dff_address;
                    $receiptLine->dff_branch_number = $checkUpdateBranchName ? ($receipt->vendor_branch_name ?? ($receipt->vendor_id != 'other' ? optional($receipt->vendor)->getBranchNumber() : null)) : $receiptLine->dff_branch_number;
                    $receiptLine->dff_tax_id = $checkUpdateTaxId ? ($receipt->vendor_tax_id ?? ($receipt->vendor_id != 'other' ? optional($receipt->vendor)->getTaxID() : null)) : $receiptLine->dff_tax_id;
                }

                $receiptLine->save();
            }

            // SUCCESS UPDATE
            \DB::commit();
            if($request->ajax()){
                $result['status'] = 'SUCCESS';
                $result['receiptId'] = $receipt->receipt_id;
                return $result;
            }else{
                if( in_array($receiptType, ['CASH-ADVANCE', 'CLEARING']) ){
                    return redirect()->route('cash-advances.clear',
                                                ['cashAdvanceId'=>$receiptParentId]);
                }elseif($receiptType == 'REIMBURSEMENT'){
                    return redirect()->route('reimbursements.show',
                                                ['reimId'=>$receiptParentId]);
                }
            }

        } catch (\Exception $e) {
            \DB::rollBack();
            if($request->ajax()){
                $result['status'] = 'ERROR';
                $result['err_msg'] = $e->getMessage();
                return $result;
            }else{
                \Log::error($e->getMessage());
                return abort('403');
            }
        }
    }

    public function getRows(Request $request)
    {
        // GET RECEIPT DATA
        $receiptParentId = $request->receipt_parent_id;
        $receiptType = $request->receipt_type;
        if( in_array($receiptType, ['CASH-ADVANCE', 'CLEARING']) ){
            $editable = canEnter('/ie/cash-advances');
            $parent = CashAdvance::find($receiptParentId);
        }elseif($receiptType == 'REIMBURSEMENT'){
            $editable = canEnter('/ie/reimbursements');
            $parent = Reimbursement::find($receiptParentId);
        }
        $orgId = $parent->org_id;
        $receipts = $parent->receipts()->processType($receiptType)->get();

        // GET LIST DATA (CHANGE WHEN CONNECT ORACLE)
        $currencyLists = Currency::pluck('currency_code','currency_code')->all();
        $parentCurrencyId = $parent->currency_id;

        // $projectLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->project()->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        // $rechargeLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->interCompany()->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $branchLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->EVM()->orderBy('flex_value')->pluck('full_description','flex_value')->all();
        $departmentLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')->department()->orderBy('flex_value')->pluck('full_description','flex_value')->all();

        return view('ie.commons.receipts._table_rows',
            compact(
                'parent',
                'receipts',
                'receiptType',
                'currencyLists',
                'parentCurrencyId',
                'editable',
                // 'projectLists',
                // 'rechargeLists',
                'branchLists',
                'departmentLists'
            ));
    }

    public function getTableTotalRows(Request $request)
    {
        // GET RECEIPT DATA
        $receiptParentId = $request->receipt_parent_id;
        $receiptType = $request->receipt_type;
        if( in_array($receiptType, ['CASH-ADVANCE', 'CLEARING']) ){
            $parent = CashAdvance::find($receiptParentId);
        }elseif($receiptType == 'REIMBURSEMENT'){
            $parent = Reimbursement::find($receiptParentId);
        }
        $parentCurrencyId = $parent->currency_id;

        return view('ie.commons.receipts._table_total_rows',
            compact(
                'parent',
                'parentCurrencyId',
                'receiptType'
            ));
    }

    public function getVendorSites(Request $request, $vendorId)
    {
        if($vendorId != 'other'){
            $vendorSiteLists = Vendor::notEmp()->select(\DB::raw("vendor_site_code AS full_description"),'vendor_site_code')
                            ->where('vendor_id',$vendorId)->orderBy('vendor_site_code')
                            ->pluck('full_description','vendor_site_code')->all();
        }else {
            $vendorSiteLists = [];
        }

        return view('ie.commons.receipts._vendor_sites',
                        compact('vendorSiteLists', 'vendorId'));
    }

    public function getVendorDetail(Request $request, $vendorId, $vendorSiteCode)
    {
        $vendor = null;
        $vendor = Vendor::notEmp()
                        ->where('vendor_id',$vendorId)
                        ->where('vendor_site_code',$vendorSiteCode)
                        ->first();
        $taxAddress = $vendor ? $vendor->getTaxAddress() : null;
        $branchNumber = $vendor ? $vendor->getBranchNumber() : null;
        $taxId = $vendor ? $vendor->getTaxID() : null;

        $data = [
            'taxAddress' => $taxAddress,
            'branchNumber' => $branchNumber,
            'taxId' => $taxId
        ];

        return response()->json($data);

        // return view('ie.commons.receipts._vendor_detail',
        //                 compact('vendor'));
    }

    public function addAttachment(Request $request, $receiptId)
    {
        $receipt = Receipt::find($receiptId);
        \DB::beginTransaction();
        try {
            // ADD FILE ATTACHMENT
            if($request->file('file')){
                $attachmentRepo = new AttachmentRepo;
                $attachmentRepo->create($receipt, $request->file('file'));
            }
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error($e->getMessage());
        }
        \DB::commit();

        if($request->ajax()){
            return \Response::json("success", 200);
        }else{
            return redirect()->back()->withInput();
        }
    }

    public function duplicate(Request $request, $receiptId)
    {
        \DB::beginTransaction();
        try {

            // PREPARE PARENT DATA
            $receiptParentId = $request->receipt_parent_id;
            $receiptType = $request->receipt_type;
            if( in_array($receiptType, ['CASH-ADVANCE', 'CLEARING']) ){
                $parent = CashAdvance::find($receiptParentId);
            }elseif($receiptType == 'REIMBURSEMENT'){
                $parent = Reimbursement::find($receiptParentId);
            }
            if(!$parent->isPendingReceipt()){
                throw new \Exception("Request enable to add receipt now.", 1);
            }
            $parentCurrencyId = $parent->currency_id;

            $receipt = Receipt::find($receiptId);

            ////////////////////////////
            // DUPLICATE RECEIPT DATA
            $newReceipt = $receipt->replicate();
            $newReceipt->last_updated_by = \Auth::user()->user_id;
            $newReceipt->created_by = \Auth::user()->user_id;
            $newReceipt->creation_date = Carbon::now();
            $newReceipt->last_update_date = Carbon::now();
            // SAVE RECEIPT DATA
            $parent->receipts()->save($newReceipt);

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
                $infos = SubCategoryInfo::where('sub_category_id',$newReceiptLine->sub_category_id)
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
                            $newReceiptLineInfo->save();
                        }
                    }
                }

            }

            \DB::commit();

        } catch (\Exception $e) {
            // ERROR CREATE CASH ADVANCE
            \DB::rollBack();
            \Log::error($e->getMessage());
            if($request->ajax()){
                return \Response::json("error", 200);
            }else{
                return abort('403');
            }
        }

        if($request->ajax()){
            return \Response::json("success", 200);
        }else{
            return redirect()->back();
        }
    }

    public function remove(Request $request, $receiptId)
    {
        $receipt = Receipt::find($receiptId);
        \DB::beginTransaction();
        try {
            // DELETE RECEIPT
            $receipt->delete();

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error($e->getMessage());
        }
        \DB::commit();

        if($request->ajax()){
            return \Response::json("success", 200);
        }else{
            return redirect()->back()->withInput();
        }
    }
}
