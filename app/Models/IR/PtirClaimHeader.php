<?php

namespace App\Models\IR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use stdClass;
use \Carbon\Carbon;

class PtirClaimHeader extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "ptir_claim_headers";
    public $primaryKey = 'claim_header_id';
    private $limit = 50;
    protected $appends = [
        'can',
        'created_at_format',
        'updated_at_format',
        'creation_date_format',
        'last_update_date_format',
        'confirmed_at_format',
        'accident_date_format',
        'accident_time_format',
    ];

    public function details()
    {
        return $this->hasMany(\App\Models\IR\PtirClaimApplyDetails::class, 'claim_header_id', 'claim_header_id');
    }

    public function attachments()
    {
        return $this->hasMany(\App\Models\IR\PtirAttachments::class, 'document_header_id', 'claim_header_id');
    }

    public function company()
    {
        return $this->hasMany(\App\Models\IR\PtirClaimApplyCompany::class, 'claim_header_id', 'claim_header_id');
    }

    public function getCreatedAtFormatAttribute()
    {
        return parseToDateTh($this->creation_date);
    }

    public function getUpdatedAtFormatAttribute()
    {
        return parseToDateTh($this->creation_date);
    }

    public function getConfirmedAtFormatAttribute()
    {
        return parseToDateTh($this->confirmed_date);
    }

    public function getLastUpdateDateFormatAttribute()
    {
        return parseToDateTh($this->last_update_date);
    }

    public function getCreationDateFormatAttribute()
    {
        return parseToDateTh($this->creation_date);
    }

    public function getAccidentDateFormatAttribute()
    {
        return parseToDateTh($this->accident_date);
    }

    public function getAccidentTimeFormatAttribute()
    {
        return date('H:i', strtotime($this->accident_time));
    }

    public function scopeSearch($q, $search, $profile)
    {
        if ($search) {
            $startYear = $search['start_year']-543;
            $endYear = $search['end_year']-543;
            $accidentStartDate = parseFromDateTh($search['accident_start_date']);
            $accidentEndDate = parseFromDateTh($search['accident_end_date']);

            if ($search['start_year'] && $search['end_year']) {
                $q->whereRaw("trunc(year) >= '{$startYear}'");
                $q->whereRaw("trunc(year) <= '{$endYear}'");
            }else{
                $q;
            }

            if ($search['accident_start_date'] || $search['accident_end_date']) {
                $q->whereRaw("trunc(accident_date) between TO_DATE('{$accidentStartDate}','YYYY-mm-dd')
                                                and nvl(TO_DATE('{$accidentEndDate}','YYYY-mm-dd'), TO_DATE(sysdate,'YYYY-mm-dd'))");
            }else{
                $q;
            }

            if ($search['department_from'] && $search['department_to']) {
                $q->whereRaw("department_code between '{$search['department_from']}' and '{$search['department_to']}'");
            }elseif ($search['department_from']) {
                $q->where('department_code', $search['department_from']);
            }else{
                $q;
            }

            if ($search['document_from'] && $search['document_to']) {
                $q->whereRaw("document_number between '{$search['document_from']}' and '{$search['document_to']}'");
            }elseif ($search['document_from']) {
                $q->where('document_number', $search['document_from']);
            }else{
                $q;
            }

            if (isset($search['ar_invoice_num'])) {
                if ($search['ar_invoice_num']) {
                    $q->where('ar_web_batch_no', $search['ar_invoice_num']);
                }else{
                    $q;
                }
            }

            if (isset($search['policy_number'])) {
                $policyNumber = $search['policy_number'];
                $q->whereHas('company', function ($query) use ($policyNumber) {
                    return $query->whereRaw("policy_number like '%{$policyNumber}%'");
                });
            }

            if ($search['status']) {
                $q->where('status', strtoupper($search['status']));
                // if ($profile->program_code == 'IRP0010') {
                // }else{
                //     $q->where('irp0011_status', strtoupper($search['status']))
                //         ->where('status', '!=', 'CANCELLED')
                //         ->whereNotNull('cancelled_reason');
                //         ->orWhereNull('cancelled_reason');
                //     // $q->where('status', '!=', 'CANCELLED')
                //     //     ->orWhere(function($query) use ($search) {
                //     //     $query->where('irp0011_status', strtoupper($search['status']))
                //     //         ->whereNotNull('cancelled_reason');
                //     // });
                // }
            }else{
                $q;
                // if ($profile->program_code == 'IRP0011') {
                //     $q->where('status', '!=', 'CANCELLED')
                //         ->orWhere(function($query) use ($search) {
                //         $query->where('irp0011_status', 'CANCELLED')
                //             ->whereNotNull('cancelled_reason');
                //     });
                // }else{
                //     $q;
                // }
            }
        }
        // else{
        //     if ($profile->program_code == 'IRP0011') {
        //         $q->where('status', '!=', 'CANCELLED')
        //             ->orWhere(function($query) use ($search) {
        //                 $query->where('irp0011_status', 'CANCELLED')
        //                     ->whereNotNull('cancelled_reason');
        //             });
        //     }
        // }

        return $q;
    }

    // public function getClaimHeaders($id)
    // {
    //     $collection = PtirClaimHeader::select(DB::raw("claim_header_id, 
    //                                                    INITCAP(status) status,
    //                                                    document_number,
    //                                                    to_char(add_months(accident_date, 6516), 'dd/mm/yyyy') as accident_date, 
    //                                                    to_char(accident_time, 'HH24:MI') accident_time, 
    //                                                    location_code,
    //                                                    location_name, 
    //                                                    department_code,
    //                                                    department_name, 
    //                                                    requestor_id, 
    //                                                    requestor_name,
    //                                                    requestor_tel, 
    //                                                    claim_amount"))
    //                                     ->where('claim_header_id', $id)
    //                                     ->first();

    //     return $collection;
    // }

    // public function objectClaimHeader($id)
    // {
    //     $collection = $this->getClaimHeaders($id);
    //     $obj = new stdClass;
    //     $obj->claim_header_id = isset($collection->claim_header_id) ? $collection->claim_header_id : '';
    //     $obj->status          = isset($collection->status) ? $collection->status : '';
    //     $obj->document_number = isset($collection->document_number) ? $collection->document_number : '';
    //     $obj->accident_date   = isset($collection->accident_date) ? $collection->accident_date : '';
    //     $obj->accident_time   = isset($collection->accident_time) ? $collection->accident_time : '';
    //     $obj->location_code   = isset($collection->location_code) ? $collection->location_code : '';
    //     $obj->location_name   = isset($collection->location_name) ? $collection->location_name : '';
    //     $obj->department_code = isset($collection->department_code) ? $collection->department_code : '';
    //     $obj->department_name = isset($collection->department_name) ? $collection->department_name : '';
    //     $obj->requestor_id    = isset($collection->requestor_id) ? $collection->requestor_id : '';
    //     $obj->requestor_name  = isset($collection->requestor_name) ? $collection->requestor_name : '';
    //     $obj->requestor_tel   = isset($collection->requestor_tel) ? $collection->requestor_tel : '';
    //     $obj->claim_amount    = isset($collection->claim_amount) ? $collection->claim_amount : '';

    //     return $obj;
    // }

    public function getDocumentNumber($keyword)
    {
        $keyword = isset($keyword) ? '%'.$keyword.'%' : '%';
        $collection = PtirClaimHeader::selectRaw('distinct claim_header_id, document_number, status, irp0011_status')
                                    ->where('document_number', 'like', $keyword)
                                    ->take($this->limit)
                                    ->orderBy('document_number', 'desc')
                                    ->get();
        return $collection;
    }

    public function getIRPDocumentNumber($keyword)
    {
        $keyword = isset($keyword) ? '%'.$keyword.'%' : '%';
        $collection = PtirClaimHeader::selectRaw('distinct document_number')
                                    ->where('document_number', 'like', $keyword)
                                    ->take($this->limit)
                                    ->orderBy('document_number', 'desc')
                                    ->get();
        return $collection;
    }

    public function getARDocumentNumber($keyword)
    {
        $keyword = isset($keyword) ? '%'.$keyword.'%' : '%';
        $collection = PtirClaimHeader::selectRaw('distinct claim_header_id, document_number, status, irp0011_status')
                                    ->where('document_number', 'like', $keyword)
                                    ->whereIn('irp0011_status', ['CONFIRMED', 'INTERFACE'])
                                    ->orderBy('document_number', 'desc')
                                    ->take($this->limit)
                                    ->get();
        return $collection;
    }

    public function getCanAttribute()
    {
        $can = (object)[];
        $status = trim($this->approved_status);
        switch (strtoupper($status)) {
            case 'NEW':
                $can->edit = false;
                $can->comfirm = false;
                break;
            case 'PENDING':
                $can->edit = false;
                $can->comfirm = false;
                break;
            case 'INTERFACE':
                $can->edit = true;
                $can->comfirm = true;
                break;
            case 'CONFIRMED':
                $can->edit = true;
                $can->comfirm = true;
                break;
            default:
                $can->edit = true;
                $can->comfirm = true;
                break;
        }

        return $can;
    }

    public function scopeSearchExportIRP0010($q, $search)
    {
        if ($search['year']) {
            $q->where('year', $search['year']);
        }else{
            $q;
        }

        if ($search['document_from'] && $search['document_to']) {
            $q->whereRaw("document_number between '{$search['document_from']}' and '{$search['document_to']}'");
        }elseif ($search['document_from']) {
            $q->where('document_number', $search['document_from']);
        }else{
            $q;
        }

        if ($search['accident_start_date'] || $search['accident_end_date']) {
            $accidentStartDate = convertDateFormatToQuery($search['accident_start_date']);
            $accidentEndDate = convertDateFormatToQuery($search['accident_end_date']);
            $q->whereRaw("trunc(accident_date) between TO_DATE('{$accidentStartDate}','YYYY-mm-dd')
                                            and nvl(TO_DATE('{$accidentEndDate}','YYYY-mm-dd'), TO_DATE(sysdate,'YYYY-mm-dd'))");
        }else{
            $q;
        }

        if ($search['department_from'] && $search['department_to']) {
            $q->whereRaw("department_code between '{$search['department_from']}' and '{$search['department_to']}'");
        }elseif ($search['department_from']) {
            $q->where('department_code', $search['department_from']);
        }else{
            $q;
        }

        if ($search['insurance_date_from'] && $search['insurance_date_to']) {
            $insuranceStartDate = convertDateFormatToQuery($search['insurance_date_from']);
            $insuranceEndDate = convertDateFormatToQuery($search['insurance_date_to']);
            $q->whereRaw("trunc(insurance_date) between TO_DATE('{$insuranceStartDate}','YYYY-mm-dd')
                                            and TO_DATE('{$insuranceEndDate}','YYYY-mm-dd')");
        }elseif ($search['insurance_date_from']) {
            $insuranceStartDate = convertDateFormatToQuery($search['insurance_date_from']);
            $q->whereRaw("trunc(insurance_date) = TO_DATE('{$insuranceStartDate}','YYYY-mm-dd')");
        }else{
            $q;
        }

        if ($search['status']) {
            if ($search['status'] == 'CANCELLED') {
                $q->where('insurance_status', strtoupper($search['status']))
                    ->orWhere(function($query) {
                        $query->where('irp0011_status', 'CANCELLED')
                            ->whereNotNull('cancelled_reason');
                    });
            }
            $q->where('insurance_status', strtoupper($search['status']));
        }else{
            if (!$search) {
                $q->where('status', '!=', 'CANCELLED')
                    ->orWhere(function($query) use ($search) {
                        $query->where('irp0011_status', 'CANCELLED')
                            ->whereNotNull('cancelled_reason')
                            ->where('year', $search['year']);
                    });
            }
        }

        return $q;
    }

    public function scopeSearchExportIRP0011($q, $search)
    {
        if ($search['year']) {
            $q->where('year', $search['year']);
        }else{
            $q;
        }

        if ($search['document_from'] && $search['document_to']) {
            $q->whereRaw("document_number between '{$search['document_from']}' and '{$search['document_to']}'");
        }elseif ($search['document_from']) {
            $q->where('document_number', $search['document_from']);
        }else{
            $q;
        }

        if ($search['status']) {
            $q->where('irp0011_insurance_status', strtoupper($search['status']));
        }else{
            $q;
        }

        return $q;
    }
}
