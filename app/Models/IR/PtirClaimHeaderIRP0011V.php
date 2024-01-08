<?php

namespace App\Models\IR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use stdClass;
use \Carbon\Carbon;

class PtirClaimHeaderIRP0011V extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "ptir_claim_header_irp0011_v";
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
                $q->where('irp0011_status', strtoupper($search['status']));
            }else{
                $q;
            }
        }

        return $q;
    }
}
