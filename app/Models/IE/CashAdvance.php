<?php

namespace App\Models\IE;

use DB;
use PDO;
use DateTime;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class CashAdvance extends Model
{
	protected $table = 'ptw_cash_advances';
    public $primaryKey = 'cash_advance_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date', 'deleted_at'];
    protected $fillable = [
        'bank_name',
        'account_no',
    ];
    // ===========================
    // === CASH ADVANCE STATUS ===
    // ===========================
    // ['NEW_REQUEST',
    //	'BLOCKED',
    //	'APPROVER_DECISION',
    //	'APPROVER_REJECTED',
    //	'FINANCE_PROCESS',
    //	'FINANCE_REJECTED',
    //	'APPROVED',
    //	'CLEARING_REQUEST',
    //	'CLEARING_APPROVER_DECISION',
    //	'CLEARING_FINANCE_PROCESS',
    //	'CLEARED',
    //  'CANCELLED'];

    public function onRequesting()
    {
        $statusOnRequesting = ['NEW_REQUEST',
                                'BLOCKED',
                                'APPROVER_DECISION',
                                'FINANCE_PROCESS',
                                'APPROVED'];
        return in_array(strtoupper($this->status), $statusOnRequesting);
    }

    public function onClearing()
    {
        $statusOnClearings = ['CLEARING_REQUEST',
                            'CLEARING_APPROVER_DECISION',
                            'CLEARING_FINANCE_PROCESS',
                            'CLEARED'];
        return in_array(strtoupper($this->status), $statusOnClearings);
    }

    public function category()
    {
        // return $this->belongsTo('App\Models\IE\CACategory','ca_category_id');
        return $this->belongsTo('App\Models\IE\Category', 'ca_category_id', 'category_id');
    }

    public function subCategory()
    {
        // return $this->belongsTo('App\Models\IE\CASubCategory','ca_sub_category_id');
        return $this->belongsTo('App\Models\IE\SubCategory', 'ca_sub_category_id' , 'sub_category_id');
    }

    public function infos()
    {
        return $this->hasMany('App\Models\IE\CashAdvanceInfo','cash_advance_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function preparer()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'user_id');
    }

    public function requester()
    {
        return $this->belongsTo('App\Models\HREmployee', 'requester_id', 'username');
    }

    public function employee()
    {
        return $this->belongsTo('App\Models\IE\Employee', 'employee_id');
    }

    public function checkedBy()
    {
        return $this->belongsTo('App\Models\HREmployee', 'checked_by', 'username');
    }

    public function approvedBy()
    {
        return $this->belongsTo('App\Models\HREmployee', 'approved_by', 'username');
    }

    public function statusPaid()
    {
        return $this->hasOne('App\Models\IE\APInvStatusPaid', 'invoice_num', 'invoice_no')->where('vendor_id', $this->vendor_id);
    }

    public function statusCancel()
    {
        return $this->hasOne('App\Models\IE\APInvStatusCancel', 'invoice_num', 'invoice_no')->where('org_id', $this->org_id);
    }

    public function statusClearCancel()
    {
        return $this->hasOne('App\Models\IE\APInvStatusCancel', 'invoice_num', 'clearing_invoice_no')->where('org_id', $this->org_id);
    }

    public function operatingUnit()
    {
        return $this->belongsTo('App\Models\IE\HrOperatingUnit', 'org_id', 'organization_id');   
    }

    public function department()
    {
        return $this->hasOne(\App\Models\IE\FNDListOfValues::class, 'flex_value', 'department_code')->department();
    }

    public function apply()
    {
        return $this->belongsTo('App\Models\IE\CashAdvance', 'cash_advance_id', 'apply_to');
    }

    public function allApply()
    {
        return $this->apply()->with('allApply');
    }

    // Approver who was assigned
    public function approver(){
        return $this->belongsTo('App\Models\User','next_approver_id');
    }
    // Finance Approver who was assigned
    // public function financeApprover(){
    //     return $this->belongsTo('App\User','finance_approver_id');
    // }
    
    // Clearing Approver who was assigned
    public function clearApprover(){
        return $this->belongsTo('App\Models\User','next_clearing_approver_id');
    }
    // Clearing Finance Approver who was assigned
    // public function clearFinanceApprover(){
    //     return $this->belongsTo('App\Models\User','clearing_finance_approver_id');
    // }

    public function approvals()
    {
        return $this->morphMany('App\Models\IE\Approval', 'approvalable')->with('user');
    }

    public function receipts()
    {
        return $this->morphMany('App\Models\IE\Receipt', 'receiptable')->orderBy('creation_date');
    }

    public function attachments()
    {
        return $this->morphMany('App\Models\IE\Attachment', 'attachmentable');
    }

    public function activityLogs()
    {
        return $this->morphMany('App\Models\IE\ActivityLog', 'activity_logable')->orderBy('creation_date','desc')->with('user');
    }

    public function supplier()
    {
        return $this->hasOne('App\Models\IE\Vendor', 'vendor_id', 'vendor_id')->where('org_id', $this->org_id);
    }

    public function supplierSite()
    {
        return $this->hasOne('App\Models\IE\Vendor', 'vendor_id', 'vendor_id')->where('vendor_site_id', $this->vendor_site_id)->where('org_id', $this->org_id);
    }

    public function paymentMethod()
    {
        return $this->belongsTo('App\Models\IE\APPaymentMethod','payment_method_id', 'payment_method_code');
    }

    public function paymentTerm()
    {
        return $this->belongsTo('App\Models\IE\APPaymentTerm','payment_term_id', 'payment_term_id');
    }

    public function interfaces()
    {
        return $this->hasMany('App\Models\IE\InterfaceAPHeader', 'request_id', 'cash_advance_id')->whereIn('request_from', ['CLEARING', 'CASH-ADVANCE'])->success();
    }

    public function hierarchyName()
    {
        return $this->hasOne('App\Models\IE\HierarchyName', 'hierarchy_name_id', 'hierarchy_name_id');
    }

    public function hierarchyNamePosition()
    {
        return $this->hasOne('App\Models\IE\HierarchyNamePosition', 'hierarchy_name_position_id', 'hierarchy_name_position_id');
    }

    public function getCATotalReceiptAmountBeforeTaxAttribute()
    {
        $totalReceiptAmountBeforeTax = 0;
        $receipts = $this->receipts()->processType('CASH-ADVANCE')->get();
        foreach($receipts as $receipt){
            $totalReceiptAmountBeforeTax += $receipt->lines()->whereHas('subCategory', function($q){
                return $q->where('wht_flag', 0);
            })->get()->sum('total_amount');
        }
        return $totalReceiptAmountBeforeTax;
    }

    public function getTotalReceiptAmountBeforeTaxAttribute()
    {
        $totalReceiptAmountBeforeTax = 0;
        $receipts = $this->receipts()->processType('CLEARING')->get();
        foreach($receipts as $receipt){
            $totalReceiptAmountBeforeTax += $receipt->lines()->whereHas('subCategory', function($q){
                return $q->where('wht_flag', 0);
            })->get()->sum('total_amount');
        }
        return $totalReceiptAmountBeforeTax;
    }

    public function getCATotalPrimaryAmountBeforeTaxAttribute()
    {
        $totalPrimaryAmountBeforeTax = 0;
        $receipts = $this->receipts()->processType('CASH-ADVANCE')->get();
        foreach($receipts as $receipt){
            $totalPrimaryAmountBeforeTax += $receipt->lines()->whereHas('subCategory', function($q){
                return $q->where('wht_flag', 0);
            })->get()->sum('primary_amount');
        }
        return $totalPrimaryAmountBeforeTax;
    }

    public function getTotalPrimaryAmountBeforeTaxAttribute()
    {
        $totalPrimaryAmountBeforeTax = 0;
        $receipts = $this->receipts()->processType('CLEARING')->get();
        foreach($receipts as $receipt){
            $totalPrimaryAmountBeforeTax += $receipt->lines()->whereHas('subCategory', function($q){
                return $q->where('wht_flag', 0);
            })->get()->sum('primary_amount');
        }
        return $totalPrimaryAmountBeforeTax;
    }

    public function getCATotalReceiptTaxAttribute()
    {
        $totalTax = 0;
        $receipts = $this->receipts()->processType('CASH-ADVANCE')->get();
        foreach($receipts as $receipt){
            $totalTax += $receipt->lines()->whereHas('subCategory', function($q){
                return $q->where('wht_flag', 0);
            })->get()->sum('vat_amount');
        }
        return $totalTax;
    }

    public function getTotalReceiptTaxAttribute()
    {
        $totalTax = 0;
        $receipts = $this->receipts()->processType('CLEARING')->get();
        foreach($receipts as $receipt){
            $totalTax += $receipt->lines()->whereHas('subCategory', function($q){
                return $q->where('wht_flag', 0);
            })->get()->sum('vat_amount');
        }
        return $totalTax;
    }

    public function getCATotalPrimaryTaxAttribute()
    {
        $totalPrimaryTax = 0;
        $receipts = $this->receipts()->processType('CASH-ADVANCE')->get();
        foreach($receipts as $receipt){
            $totalPrimaryTax += $receipt->lines()->whereHas('subCategory', function($q){
                return $q->where('wht_flag', 0);
            })->get()->sum('primary_vat_amount');
        }
        return $totalPrimaryTax;
    }

    public function getTotalPrimaryTaxAttribute()
    {
        $totalPrimaryTax = 0;
        $receipts = $this->receipts()->processType('CLEARING')->get();
        foreach($receipts as $receipt){
            $totalPrimaryTax += $receipt->lines()->whereHas('subCategory', function($q){
                return $q->where('wht_flag', 0);
            })->get()->sum('primary_vat_amount');
        }
        return $totalPrimaryTax;
    }

    public function getCATotalReceiptAmountIncTaxAttribute()
    {
        $totalReceiptAmountIncTax = 0;
        $receipts = $this->receipts()->processType('CASH-ADVANCE')->get();
        foreach($receipts as $receipt){
            $totalReceiptAmountIncTax += $receipt->lines()->whereHas('subCategory', function($q){
                return $q->where('wht_flag', 0);
            })->get()->sum('total_amount_inc_vat');
        }
        return $totalReceiptAmountIncTax;
    }

    public function getTotalReceiptAmountIncTaxAttribute()
    {
        $totalReceiptAmountIncTax = 0;
        $receipts = $this->receipts()->processType('CLEARING')->get();
        foreach($receipts as $receipt){
            $totalReceiptAmountIncTax += $receipt->lines()->whereHas('subCategory', function($q){
                return $q->where('wht_flag', 0);
            })->get()->sum('total_amount_inc_vat');
        }
        return $totalReceiptAmountIncTax;
    }

    public function getCATotalPrimaryAmountIncTaxAttribute()
    {
        $totalPrimaryAmountBeforeTax = 0;
        $receipts = $this->receipts()->processType('CASH-ADVANCE')->get();
        foreach($receipts as $receipt){
            $totalPrimaryAmountBeforeTax += $receipt->lines()->whereHas('subCategory', function($q){
                return $q->where('wht_flag', 0);
            })->get()->sum('total_primary_amount_inc_vat');
        }
        return $totalPrimaryAmountBeforeTax;
    }

    public function getTotalPrimaryAmountIncTaxAttribute()
    {
        $totalPrimaryAmountBeforeTax = 0;
        $receipts = $this->receipts()->processType('CLEARING')->get();
        foreach($receipts as $receipt){
            $totalPrimaryAmountBeforeTax += $receipt->lines()->whereHas('subCategory', function($q){
                return $q->where('wht_flag', 0);
            })->get()->sum('total_primary_amount_inc_vat');
        }
        return $totalPrimaryAmountBeforeTax;
    }

    public function getCATotalReceiptWhtAttribute()
    {
        $totalPrimaryAmountBeforeTax = 0;
        $receipts = $this->receipts()->processType('CASH-ADVANCE')->get();
        foreach($receipts as $receipt){
            $totalPrimaryAmountBeforeTax += $receipt->lines()->whereHas('subCategory', function($q){
                return $q->where('wht_flag', 1);
            })->get()->sum('total_amount_inc_vat');
        }
        return $totalPrimaryAmountBeforeTax;
    }

    public function getTotalReceiptWhtAttribute()
    {
        $totalPrimaryAmountBeforeTax = 0;
        $receipts = $this->receipts()->processType('CLEARING')->get();
        foreach($receipts as $receipt){
            $totalPrimaryAmountBeforeTax += $receipt->lines()->whereHas('subCategory', function($q){
                return $q->where('wht_flag', 1);
            })->get()->sum('total_amount_inc_vat');
        }
        return $totalPrimaryAmountBeforeTax;
    }

    public function getCATotalPrimaryWhtAttribute()
    {
        $totalPrimaryAmountBeforeTax = 0;
        $receipts = $this->receipts()->processType('CASH-ADVANCE')->get();
        foreach($receipts as $receipt){
            $totalPrimaryAmountBeforeTax += $receipt->lines()->whereHas('subCategory', function($q){
                return $q->where('wht_flag', 1);
            })->get()->sum('total_primary_amount_inc_vat');
        }
        return $totalPrimaryAmountBeforeTax;
    }

    public function getTotalPrimaryWhtAttribute()
    {
        $totalPrimaryAmountBeforeTax = 0;
        $receipts = $this->receipts()->processType('CLEARING')->get();
        foreach($receipts as $receipt){
            $totalPrimaryAmountBeforeTax += $receipt->lines()->whereHas('subCategory', function($q){
                return $q->where('wht_flag', 1);
            })->get()->sum('total_primary_amount_inc_vat');
        }
        return $totalPrimaryAmountBeforeTax;
    }

    public function getCATotalReceiptAmountAttribute()
    {
        $totalReceiptAmount = 0;
        $receipts = $this->receipts()->processType('CASH-ADVANCE')->get();
        foreach($receipts as $receipt){
            $totalReceiptAmount += $receipt->lines->sum('total_amount_inc_vat');
        }
        return $totalReceiptAmount;
    }

    public function getTotalReceiptAmountAttribute()
    {
        $totalReceiptAmount = 0;
        $receipts = $this->receipts()->processType('CLEARING')->get();
        foreach($receipts as $receipt){
            $totalReceiptAmount += $receipt->lines->sum('total_amount_inc_vat');
        }
        return $totalReceiptAmount;
    }

    public function getCATotalPrimaryAmountAttribute()
    {
        $totalReceiptAmount = 0;
        $receipts = $this->receipts()->processType('CASH-ADVANCE')->get();
        foreach($receipts as $receipt){
            $totalReceiptAmount += $receipt->lines->sum('total_primary_amount_inc_vat');
        }
        return $totalReceiptAmount;
    }

    public function getTotalPrimaryAmountAttribute()
    {
        $totalReceiptAmount = 0;
        $receipts = $this->receipts()->processType('CLEARING')->get();
        foreach($receipts as $receipt){
            $totalReceiptAmount += $receipt->lines->sum('total_primary_amount_inc_vat');
        }
        return $totalReceiptAmount;
    }

    public function getCATotalReceiptPrimaryAmountAttribute()
    {
        $totalPrimaryReceiptAmount = 0;
        $receipts = $this->receipts()->processType('CASH-ADVANCE')->get();
        foreach($receipts as $receipt){
            $totalPrimaryReceiptAmount += $receipt->lines->sum('total_primary_amount_inc_vat');
        }
        return $totalPrimaryReceiptAmount;
    }

    public function getTotalReceiptPrimaryAmountAttribute()
    {
        $totalPrimaryReceiptAmount = 0;
        $receipts = $this->receipts()->processType('CLEARING')->get();
        foreach($receipts as $receipt){
            $totalPrimaryReceiptAmount += $receipt->lines->sum('total_primary_amount_inc_vat');
        }
        return $totalPrimaryReceiptAmount;
    }

    public function getLastApplyAttribute()
    {
        $apply = null;
        $check = $this->apply;
        do {

            $apply = $check;
            $check = $check ? $check->apply : null;

        } while(!!$check);

        return $apply ?? $this;
    }

    public static function genDocumentNo($orgId, $currencyType, $apply = null, $date = null)
    {
        $prefix = $apply ? substr($apply->document_no, 2) : $currencyType . getBudgetYear($date);

        // END DO WHILE WHEN NOT FOUND CA & CC NUMBER AS INVOICE IN ERP SYSTEM
        do {

            $runningTranId = \App\Models\IE\TransactionSequence::getTranID($orgId, 'App\CashAdvance', $prefix);
            $docNo['CA'] = $apply ? $apply->document_no. '/' . $runningTranId : 'CA' . $prefix . str_pad($runningTranId, 4, '0', STR_PAD_LEFT);
            $docNo['CL'] = $apply ? $apply->clearing_document_no. '/' . $runningTranId : 'CL' . $prefix . str_pad($runningTranId, 4, '0', STR_PAD_LEFT);

        } while(self::checkDupDocNo($orgId, $docNo));

        $result = $docNo;

        return $result;
    }

    public static function genInvoiceNo($orgId, $vendorId, $document_type, $type = null, $apply = null, $date = null)
    {
        $year = getBudgetYear($date);
        $orgType = self::getOrgType($orgId) ?? 'TOAT';
        $typeCode = $type == 'CLEARING' ? 'C' : '';
        $prefix = $apply ? $apply->clearing_invoice_no : ( $typeCode == 'C' ? $typeCode . '/' : '' ) . $year . '/' . $orgType;

        // END DO WHILE WHEN NOT FOUND CA & CC NUMBER AS INVOICE IN ERP SYSTEM
        do {

            $runningTranId = \App\Models\IE\TransactionSequence::getTranID($orgId, 'App\CashAdvance', $prefix);
            $invoiceNum = $apply ? $apply->clearing_invoice_no . '/' . $runningTranId : ($typeCode . str_pad($runningTranId, 4, '0', STR_PAD_LEFT) . '/' . $year . '/' . $orgType .'/'. $document_type);

        } while(self::checkDupInvNo($orgId, $vendorId, $invoiceNum));

        $result = $invoiceNum;

        return $result;
    }

    private static function getOrgType($orgId)
    {
        $mappings = Preference::getMappingOU();

        $orgType = $mappings[$orgId];

        return $orgType;
    }

    public static function checkDupDocNo($orgId, $docNo)
    {
        // IF FOUND THIS CA NUMBER OR CC NUMBER
        $found = self::where('org_id', $orgId)->where('document_no', $docNo)->first();
        return !!$found;
    }

    public static function checkDupInvNo($orgId, $vendorId, $invNo)
    {
        // IF FOUND THIS CA NUMBER OR CC NUMBER
        $found = APInvoicesAll::where('org_id', $orgId)->where('invoice_num', $invNo)->where('vendor_id', $vendorId)->first();
        return !!$found;
    }

    public function scopeSearch($query, $search)
    {
        $requester = null;
        $description = null;
        $document_no = null;
        $invoice_no = null;
        $date_from = null;
        $date_to = null;
        $status = null;

        if($search){
            if( array_key_exists('requester', $search) ){
                $requester = strtoupper($search['requester']);
            }
            if( array_key_exists('description', $search) ){
                $description = strtoupper($search['description']);
            }
            if( array_key_exists('document_no', $search) ){
                $document_no = strtoupper($search['document_no']);
            }
            if( array_key_exists('invoice_no', $search) ){
                $invoice_no = strtoupper($search['invoice_no']);
            }
            if( array_key_exists('req_date_from', $search) ){
                $date_from = $search['req_date_from'];
            }
            if( array_key_exists('req_date_to', $search) ){
                $date_to = $search['req_date_to'];
            }
            if( array_key_exists('status', $search) ){
                $status = $search['status'];
            }
        }

        if($document_no){
            $query->where(function($q) use($document_no) {
                $q->whereRaw("UPPER(document_no) like '%".$document_no."%'")
                    ->orWhereRaw("UPPER(clearing_document_no) like '%".$document_no."%'");
            });
        }
        if($requester){
            $user_ids = User::whereRaw("UPPER(name) like '%".$requester."%'")
                            ->pluck('user_id');
            $query->whereIn('user_id', $user_ids);
        }
        if($description){
            $query->whereRaw("UPPER(reason) like '%".$description."%'");
        }
        if($invoice_no){
            $query->where(function($q) use($invoice_no) {
                $q->whereRaw("UPPER(invoice_no) like '%".$invoice_no."%'")
                    ->orWhereRaw("UPPER(clearing_invoice_no) like '%".$invoice_no."%'");
            });
        }
        if($date_from && $date_to){
            $oneDate = $date_from == $date_to;
            if($oneDate){
                $query->whereDate('request_date', Carbon::createFromFormat('d/m/Y', $date_from));
            }else {
                $query->whereBetween('request_date', [Carbon::createFromFormat('d/m/Y', $date_from)->startOfDay(), Carbon::createFromFormat('d/m/Y', $date_to)->endOfDay()]);
            }
        }elseif($date_from){
            $query->whereDate('request_date', '>=', Carbon::createFromFormat('d/m/Y', $date_from));
        }elseif($date_to){
            $query->whereDate('request_date', '<=', Carbon::createFromFormat('d/m/Y', $date_to));
        }
        if($status){
            $query->whereRaw("UPPER(status) like '%".$status."%'");
        }
        
        return $query;
    }

    public function scopeOnPending($query)
    {
        return $query->whereNotIn('status',['BLOCKED','APPROVER_REJECTED','FINANCE_REJECTED','CLEARED','CANCELLED']);
    }

    public function scopeByKeyword($query,$keyword)
    {
        if($keyword){
            $query->where('document_no', 'like' ,'%'.$keyword.'%')
                ->orWhere('status', 'like' ,'%'.$keyword.'%')
                ->orWhere(function ($query) use ($keyword) {
                    $query->whereHas('user', function($query) use ($keyword){
                        $query->where('name', 'like' ,'%'.$keyword.'%');
                    });
                })
                ->orWhere(function ($query) use ($keyword) {
                    $query->whereHas('approver', function($query) use ($keyword){
                        $query->where('name', 'like' ,'%'.$keyword.'%');
                    });
                });
        }
        return $query;
    }

    public function scopeOnStatusRequesting($query)
    {
        return $query->whereIn('status',['NEW_REQUEST','BLOCKED','APPROVER_DECISION','FINANCE_PROCESS','APPROVED']);
    }

    public function scopeOnStatusClearing($query)
    {
        return $query->whereIn('status',['CLEARING_REQUEST','CLEARING_APPROVER_DECISION','CLEARING_FINANCE_PROCESS','CLEARED']);
    }

    public function scopeOnApprovedNotCleared($query)
    {
        return $query->whereIn('status',['APPROVED','CLEARING_REQUEST','CLEARING_APPROVER_DECISION','CLEARING_FINANCE_PROCESS']);
    }

    public function scopeByYearShowing($query,$yearShowing)
    {
        if($yearShowing){
            $from_date = $yearShowing.'-01-01 00:00:00';
            $to_date = $yearShowing.'-12-31 23:59:59';
            $query->where('creation_date', '>=' ,$from_date);
            $query->where('creation_date', '<=' ,$to_date);
        }
        return $query;
    }

    public function scopeByRelatedUser($query,$userId = null)
    {
        // GET USER DATA
        if(!$userId){
            $user = \Auth::user();
            $userId = $user->user_id;
        }else{
            $user = \App\Models\User::find($userId);
        }
        
        // ADMIN & FINANCE WILL SEE ALL CASH-ADVANCE
        if(!$user->isAdmin() && !$user->isFinance()){

            // IS REQUESTER
            $query->where('user_id', $userId);

            // // IS NEXT APPROVER
            // $query->orWhere('next_approver_id', $userId)
            //     ->orWhere('next_clearing_approver_id', $userId);
            // // IS RECENT APPROVAL
            // $query->orWhere(function ($query) use ($userId) {
            //     $query->whereHas('approvals', function($query) use ($userId){
            //         $query->where('user_id',$userId);  
            //     });
            // });

            // GET SUBORDINATE PERSON FROM PO HIERARCHY
            $subordinatePersons = \App\POHierarchy::findAllChildByParent($user->employee->person_id,$user->employee->position_id);
            // IS HIGHER LEVEL IN POSITION HIERACHY 
            if(count($subordinatePersons) > 0){
                $chunkSubordinatePersons = $subordinatePersons->chunk(500);
                $query->orWhere(function ($query) use ($chunkSubordinatePersons) {
                    $query->whereHas('user', function($query) use ($chunkSubordinatePersons){
                        foreach ($chunkSubordinatePersons as $key => $chunkSubordinatePerson) {
                            if($key == 0){
                                $query->whereIn('oracle_person_id',$chunkSubordinatePerson); 
                            }else{
                                $query->orWhere(function ($query) use ($chunkSubordinatePerson) {
                                    $query->whereIn('oracle_person_id',$chunkSubordinatePerson);
                                });
                            }
                        }
                    });
                });
            }
        }
        return $query;
    }

    public function scopeByPendingUser($query,$userId)
    {
        $user = \App\Models\User::find($userId);
        // REQUESTER
        $query->where(function ($query) use ($userId) {
            $query->whereIn('status', ['NEW_REQUEST','APPROVED', 'CLEARING_REQUEST'])
                ->where('user_id', $userId);
        });
        if($user->isUnblocker()){
            // IF IS UNBLOCKER USER SHOW ALL REIM STATUS BLOCKED
            $query->orWhere('status', 'BLOCKED');
        }else{
            // IF NOT UNBLOKER SHOW ONLY HIS BLOCKED REQUEST
            $query->where(function ($q) use ($userId) {
                $q->where('status', 'BLOCKED')
                    ->where('created_by', $userId);
            });
        }
        // APPROVER
        $query->orWhere(function ($q) use ($userId) {
            $q->where(function($p) use ($userId){
                $p->whereIn('status', ['APPROVER_DECISION'])
                    ->where('next_approver_id', $userId);
            })
            ->orWhere(function ($p) use ($userId) {
                $p->whereIn('status', ['CLEARING_APPROVER_DECISION'])
                    ->where('next_clearing_approver_id', $userId);
            });
        });
        // GROUP APPROVER
        $query->orWhere(function($q) use ($userId){
            $q->whereHas('hierarchyNamePosition', function($p) use ($userId){
                $p->whereHas('position', function($t) use ($userId){
                    $t->whereHas('positionUsers', function($r) use ($userId){
                        $r->where('user_id', $userId);
                    });
                });
            });
        });
        // FINANCE
        if($user->isFinance()){
            // ONLY USER FINANCE CAN SEE STATUS 'FINANCE_PROCESS','CLEARING_FINANCE_PROCESS'
            $query->orWhere(function ($query) {
                $query->whereIn('status', ['FINANCE_PROCESS','CLEARING_FINANCE_PROCESS']);
            });
        }

        return $query;
    }

    public function getPendingUserAttribute()
    {
        if($this->status == 'NEW_REQUEST' || 
            $this->status == 'BLOCKED' || 
            $this->status == 'APPROVED' ||
            $this->status == 'CLEARING_REQUEST'){

            $result = $this->user->name;

        }elseif($this->status == 'APPROVER_DECISION'){

            $result = $this->approver ? $this->approver->name : '-';

        }elseif($this->status == 'CLEARING_APPROVER_DECISION'){

            $result = $this->clearApprover ? $this->clearApprover->name : '-';

        }elseif($this->status == 'FINANCE_PROCESS'){

            $result = 'Finance Dept.';

        }elseif($this->status == 'CLEARING_FINANCE_PROCESS'){

            $result = 'Finance Dept.';

        }else{
            $result = '-';
        }

        return $result;
    }

    public function getNextApproverAttribute()
    {
        $result = null;
        if($this->status == 'APPROVER_DECISION'){

            $result = $this->approver ? $this->approver->name : '-';

        }elseif($this->status == 'CLEARING_APPROVER_DECISION'){

            $result = $this->clearApprover ? $this->clearApprover->name : '-';

        }elseif($this->status == 'FINANCE_PROCESS'){

            $result = 'Finance Dept.';

        }elseif($this->status == 'CLEARING_FINANCE_PROCESS'){

            $result = 'Finance Dept.';

        }
        return $result;
    }

    public function isRequester($userId = null)
    {
        if(!$userId) 
        $userId = \Auth::user()->user_id;
        $username = \Auth::user()->username;

        return $this->created_by == $userId || $this->requester_id == $username;
    }

    public function isNextApprover($userId = null)
    {
        if(!$userId)
        $userId = \Auth::user()->user_id; 

        return $this->next_approver_id == $userId;
    }

    public function isNextClearingApprover($userId = null)
    {
        if(!$userId)
        $userId = \Auth::user()->user_id;
        
        return $this->next_clearing_approver_id == $userId;
    }

    public function isRelatedUser($userId = null)
    {
        // GET USER DATA
        if(!$userId){
            $user = \Auth::user();
            $userId = $user->user_id;
        }else{
            $user = \App\Models\User::find($userId);
        }
        
        // ADMIN & FINANCE WILL SEE ALL CASH-ADVANCE
        if($user->isAdmin() || $user->isFinance()){
            $permit = true;
        }else{

            // IS REQUESTER
            $query = self::where('created_by', $userId);
            
            // // IS NEXT APPROVER
            // $query->orWhere('next_approver_id', $userId)
            //     ->orWhere('next_clearing_approver_id', $userId);
            // // IS RECENT APPROVAL
            // $query->orWhere(function ($query) use ($userId) {
            //     $query->whereHas('approvals', function($query) use ($userId){
            //         $query->where('user_id',$userId);  
            //     });
            // });

            // GET SUBORDINATE PERSON FROM PO HIERARCHY
            // $subordinatePersons = \App\Models\IE\POHierarchy::findAllChildByParent($user->employee->person_id,$user->employee->position_id);
            // // IS HIGHER LEVEL IN POSITION HIERACHY 
            // if(count($subordinatePersons) > 0){
            //     $chunkSubordinatePersons = $subordinatePersons->chunk(500);
            //     $query->orWhere(function ($query) use ($chunkSubordinatePersons) {
            //         $query->whereHas('user', function($query) use ($chunkSubordinatePersons){
            //             foreach ($chunkSubordinatePersons as $key => $chunkSubordinatePerson) {
            //                 if($key == 0){
            //                     $query->whereIn('oracle_person_id',$chunkSubordinatePerson); 
            //                 }else{
            //                     $query->orWhere(function ($query) use ($chunkSubordinatePerson) {
            //                         $query->whereIn('oracle_person_id',$chunkSubordinatePerson);
            //                     });
            //                 }
            //             }
            //         });
            //     });
            // }

            $permit = !! $query->first();
        } 
        return $permit;
    }

    public function isNotLock()
    {
        // NOT LOCK ON STATUS 'NEW_REQUEST','BLOCKED'
        return  \Auth::user()->isAccountantUser()
            || ( !in_array($this->status, ['NEW_REQUEST', 'APPROVED', 'CLEARING_REQUEST', 'CLEARED', 'BLOCKED', 'CANCELLED']) )
            || (in_array($this->status, ['NEW_REQUEST', 'CLEARING_REQUEST']) && $this->isRequester());
    }

    public function canImportantEditData()
    {
        return in_array($this->status, ['NEW_REQUEST', 'CLEARING_REQUEST']);
    }

    public function isPendingReceipt()
    {
        return in_array($this->status, ['CLEARING_REQUEST', 'NEW_REQUEST']) || \Auth::user()->isAccountantUser();
    }

    public function isPaid()
    {
        return $this->statusPaid ? $this->statusPaid->payment_status_flag == 'Y' : false;
    }

    public function isReapplyable()
    {
        return !$this->statusCancel && !!$this->statusClearCancel && $this->apply_to == null;
    }

    public function isLastApprover()
    {
        $name = $this->hierarchyName;
        $current = $this->hierarchyNamePosition;

        if(!$name || !$current) return false;

        $checkLast = $name->namePositions()->where('seq', '>', $current->seq)->first();

        return !$checkLast;
    }
}
