<?php


namespace App\Models\PM;

use App\Models\Lookup\PtglCoaDeptCodeVLookup;
use App\Models\Lookup\PtpmItemClassificationsVLookup;
use App\Models\Lookup\PtpmItemNumberVLookup;
use App\Models\Lookup\PtpmJobTypeLookup;
use App\Models\Lookup\PtpmMesReviewIssuesVLookup;
use App\Models\Lookup\PtpmMesReviewJobHeadersLookup;
use App\Models\Lookup\PtpmMesReviewJobLinesLookup;
use App\Models\Lookup\PtpmOperationOfBatchVLookup;
use App\Models\Lookup\PtpmSummaryBatchVLookup;
use App\Models\PM\PtpmMesReviewIssueLines;
use App\Models\PM\PtmpMesReviewIssueV;
use App\Models\PM\PtmpIssueStatus;
use App\Models\PM\PtmpPmp00070And048V;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;


class PtpmMesReviewIssueHeaders extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'oapm.ptpm_mes_review_issue_headers';
    protected $primaryKey = 'issue_header_id';
    public $timestamps = false;

    protected $guarded = [];
//    protected $fillable = [
//        'department_code',
//        'batch_no',
//        'opt',
//        'inventory_item_id',
//        'ingridient_group_code',
//        'opt_plan_qty',
//        'opt_plan_uom',
//        'wip_qty',
//        'request_number',
//        'job_type_code',
//        'wip_step',
//        'machine_set',
//        'issue_date',
//        'complete_date',
//        'trial_flag',
//        'wms_get_flag',
//        'web_batch_no',
//        'record_status',
//    ];

    public function coaDeptCodeV()
    {
        return $this->belongsTo(PtglCoaDeptCodeVLookup::class, 'department_code', 'department_code');
    }

    public function mesReviewIssueV()
    {
        return $this->belongsTo(PtpmMesReviewIssuesVLookup::class, 'batch_no', 'batch_no');
    }

    public function itemNumberV()
    {
        return $this->belongsTo(PtpmItemNumberVLookup::class, 'inventory_item_id', 'inventory_item_id');
    }

    public function itemClassificationsV()
    {
        return $this->belongsTo(PtpmItemClassificationsVLookup::class, 'ingridient_group_code', 'item_classification_code');
    }

    public function mesReviewJobHeaders()
    {
        return $this->belongsTo(PtpmMesReviewJobHeadersLookup::class, 'batch_no', 'batch_no');
    }

    public function mesReviewJobLines()
    {
        return $this->belongsTo(PtpmMesReviewJobLinesLookup::class, 'review_header_id', 'issue_header_id')
            ->where('wip_step', $this->wip_step);
    }

    public function jobType()
    {
        return $this->belongsTo(PtpmJobTypeLookup::class, 'job_type_code', 'lookup_code');
    }

    public function summaryBatchV()
    {
        return $this->hasOne(PtpmSummaryBatchVLookup::class, 'batch_no', 'batch_no');
    }

    public function operationOfBatchV()
    {
        return $this->hasOne(PtpmOperationOfBatchVLookup::class, 'batch_no', 'batch_no');
    }

    public function mesReviewIssueLines()
    {
        return $this->hasMany(PtpmMesReviewIssueLines::class, 'issue_header_id', 'issue_header_id');
    }

    public function mesReviewIssueView()
    {
        $profile =  getDefaultData(\Request::path());
        // if($profile->organization_code == 'MP2'){

        // }
        if (($this->program_code == 'PMP0007' || $this->program_code == 'PMP0048') && $profile->organization_code != 'MP2') {
            return $this->belongsTo(PtmpPmp00070And048V::class, 'batch_id', 'batch_id');
        }else {
            return $this->belongsTo(PtmpMesReviewIssueV::class, 'batch_id', 'batch_id');
        }
        
    }


    public function mesPmp0007And48()
    {
        // if ($this->program_code == 'PMP0007' || $this->program_code == 'PMP0048') {
            return $this->belongsTo(PtmpPmp00070And048V::class, 'batch_id', 'batch_id');
        // }else {
        //     return $this->belongsTo(PtmpMesReviewIssueV::class, 'batch_id', 'batch_id');
        // }
        
    }
    
    public function mesReviewIssueVHasBlend()
    {
        $profile =  getDefaultData(\Request::path());
        if (($this->program_code == 'PMP0007' || $this->program_code == 'PMP0048') && $profile->organization_code != 'MP2') {
            return $this->belongsTo(PtmpPmp00070And048V::class, 'batch_id', 'batch_id')->where('blend_no', '!=', null);
        }else {
            return $this->belongsTo(PtmpMesReviewIssueV::class, 'batch_id', 'batch_id')->where('blend_no', '!=', null);
        }
        
    }

    // public function mesIssueV()
    // {
    //     return $this->belongsTo(PtmpPmp00070And048V::class, 'batch_id', 'batch_id');
    // }

    // public function mesIssueVHasBlend()
    // {
    //     return $this->belongsTo(PtmpPmp00070And048V::class, 'batch_id', 'batch_id')->where('blend_no', '!=', null);
    // }

    public function issueStatus()
    {
        return $this->belongsTo(PtmpIssueStatus::class, 'issue_status', 'lookup_code');
    }

    public function childHeaders()
    {
        return $this->hasMany(self::class, 'attribute15', 'issue_header_id');
    }

    public function parentHeader()
    {
        return $this->belongsTo(self::class, 'attribute15', 'issue_header_id');
    }



    public function badgeStatus()
    {
        $op = (object)[];
        if ($this->issue_status == 1) {

            $op->class = 'badge';
            $op->description = $this->issueStatus->description;
        }
        if ($this->issue_status == 2) {
            $op->class = 'badge badge-primary';
            $op->description = $this->issueStatus->description;
        }
        if ($this->issue_status == 3) {
            $op->class = 'badge badge-inverse';
            $op->description = $this->issueStatus->description;
        }

        return $op;
    }

}
