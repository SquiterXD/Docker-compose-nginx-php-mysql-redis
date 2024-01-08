<?php

namespace App\Models\IR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class PtirClaimApplyCompany extends Model
{
    use HasFactory;

    protected $table = "ptir_claim_apply_company";
    public $primaryKey = 'claim_apply_id';
    protected $fillable = [
        'claim_header_id',
        'claim_group_id',
        'company_id',
        'company_name',
        'claim_percent',
        'claim_amount',
        'informant_date',
        'invoice_date',
        'gl_date',
        'ar_invoice_id',
        'ar_invoice_num',
        'policy_number',
        'ar_receipt_date',
        'ar_receipt_id',
        'ar_receipt_number',
        'ar_received_amount',
        'program_code',
        'created_at',
        'created_by_id',
        'created_by',
        'last_updated_by',
        'creation_date',
        'last_update_date',
        'claim_detail_id',
        'amount_ratio'
    ]; 

    public function getArInvoiceLov($id, $keyword)
    {
        $keyword = isset($keyword) ? '%'.$keyword.'%' : '%';
        $collection = PtirClaimApplyCompany::select(DB::raw("distinct ar_invoice_num"))
                                            ->whereRaw("claim_apply_id = nvl(?, claim_apply_id)
                                                        and ar_invoice_num like ?", 
                                                        [$id, $keyword]) 
                                            ->orderBy('ar_invoice_num', 'desc')
                                            ->get();

        return $collection;
    }

    // public function getAllClaimApplyCompany($id, $groupId)
    // {
    //     $collection = DB::table('ptir_claim_apply_company a')
    //                     ->select('a.claim_apply_id', 'a.company_id', 'a.company_name', 'a.claim_percent',
    //                    'a.claim_amount', DB::raw("to_char(add_months(a.informant_date, 6516), 'dd/mm/yyyy') informant_date, to_char(add_months(a.invoice_date, 6516), 'dd/mm/yyyy') invoice_date, 
    //                    to_char(add_months(a.gl_date, 6516), 'dd/mm/yyyy') gl_date"), 
    //                    'a.ar_invoice_id', 'a.ar_invoice_num', 'a.policy_number', DB::raw("to_char(add_months(a.ar_receipt_date, 6516), 'dd/mm/yyyy') ar_receipt_date"), 
    //                    'a.ar_receipt_number', 'a.ar_received_amount') 
    //          ->where('a.claim_header_id', $id)
    //          ->where('a.claim_group_id', $groupId)
    //          ->get();

    //     return $collection;
    // }

    // public static function updateApplyCompany($data)
    // {
    //     $db = PtirClaimApplyCompany::find($data['claim_apply_id']);
    //     $db->company_id            = $data['company_id'];
    //     $db->company_name          = $data['company_name'];
    //     $db->claim_percent         = $data['claim_percent'];
    //     $db->claim_amount          = $data['claim_amount'];
    //     $db->informant_date        = $data['informant_date'];
    //     $db->invoice_date          = $data['invoice_date'];
    //     $db->gl_date               = $data['gl_date'];
    //     $db->ar_invoice_id         = $data['ar_invoice_id'];
    //     $db->ar_invoice_num        = $data['ar_invoice_num'];
    //     $db->policy_number         = $data['policy_number'];
    //     $db->ar_receipt_date       = $data['ar_receipt_date'];
    //     $db->ar_receipt_id         = $data['ar_receipt_id'];
    //     $db->ar_receipt_number     = $data['ar_receipt_number'];
    //     $db->ar_received_amount    = $data['ar_received_amount'];
    //     $db->updated_at            = $data['updated_at'];
    //     $db->last_updated_by       = $data['last_updated_by'];
    //     $db->last_update_date      = $data['last_update_date'];
    //     $db->save();
    // }

    // public static function deleteClaimApplyCompany($id, $groupId)
    // {
    //     if ($id == '') {
    //         PtirClaimApplyCompany::where('claim_group_id', $groupId)
    //                             ->delete();
    //     } else {
    //         PtirClaimApplyCompany::where("claim_apply_id", $id)
    //                             ->where('claim_group_id', $groupId)
    //                             ->delete();
    //     }
     
    // }

    public function getPolicyNumber($keyword)
    {
        $keyword = isset($keyword) ? '%'.$keyword.'%' : '%';
        $collection = PtirClaimApplyCompany::selectRaw("distinct policy_number")
                                            ->whereRaw("policy_number like ?", [$keyword])
                                            ->get();

        return $collection;
    }

    public function claimPolicyGroup()
    {
        return $this->hasOne(PtirClaimPolicyGroups::class, 'claim_group_id', 'claim_group_id');
    }

    public function details()
    {
        return $this->hasOne(PtirClaimApplyDetails::class, 'claim_detail_id', 'claim_detail_id');
    }

    public function scopeSearchExportIRP0011($q, $search)
    {
        if ($search['company_from'] && $search['company_to']) {
            $q->whereRaw("company_id between '{$search['company_from']}' and '{$search['company_to']}'");
        }elseif ($search['company_from']) {
            $q->where('company_id', $search['company_from']);
        }else{
            $q;
        }

        if ($search['invoice_from'] && $search['invoice_to']) {
            $q->whereRaw("ar_invoice_num between '{$search['invoice_from']}' and '{$search['invoice_to']}'");
        }elseif ($search['invoice_from']) {
            $q->where('ar_invoice_num', $search['invoice_from']);
        }else{
            $q;
        }

        if ($search['policy_from'] && $search['policy_to']) {
            $q->whereRaw("policy_number between '{$search['policy_from']}' and '{$search['policy_to']}'");
        }elseif ($search['policy_from']) {
            $q->where('policy_number', $search['policy_from']);
        }else{
            $q;
        }

        if ($search['receipt_from'] && $search['receipt_to']) {
            $q->whereRaw("ar_receipt_number between '{$search['receipt_from']}' and '{$search['receipt_to']}'");
        }elseif ($search['receipt_from']) {
            $q->where('ar_receipt_number', $search['receipt_from']);
        }else{
            $q;
        }

        if ($search['receipt_start_date'] || $search['receipt_end_date']) {
            $receiptStartDate = convertDateFormatToQuery($search['receipt_start_date']);
            $receiptEndDate = convertDateFormatToQuery($search['receipt_end_date']);
            $q->whereRaw("trunc(ar_receipt_date) between TO_DATE('{$receiptStartDate}','YYYY-mm-dd')
                                            and TO_DATE('{$receiptEndDate}','YYYY-mm-dd')");
        }elseif ($search['receipt_start_date']) {
            $receiptStartDate = convertDateFormatToQuery($search['receipt_start_date']);
            $q->whereRaw("trunc(ar_receipt_date) = TO_DATE('{$receiptStartDate}','YYYY-mm-dd')");
        }else{
            $q;
        }

        return $q;
    }
}
