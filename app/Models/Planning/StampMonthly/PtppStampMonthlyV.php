<?php

namespace App\Models\Planning\StampMonthly;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtppStampMonthlyV extends Model
{
    use HasFactory;
    protected $table = "ptpp_stamp_monthly_v";
    public $primaryKey = 'monthly_id';

    protected $appends = [
        'can',
        'created_at_format',
        'updated_at_format',
        'creation_date_format',
        'last_update_date_format',
        'approved_at_format',
        'as_of_date_format',
        'status_lable_html'
    ];

    public function ppPeriod()
    {
        return $this->hasOne(\App\Models\Planning\PtppPeriodsV::class, 'period_name', 'period_name');
    }

    public function updatedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by_id');
    }

    public function scopeIsApproved($q)
    {
        return $q->whereRaw("upper(approved_status) = 'APPROVED'");
    }

    public function getCreatedAtFormatAttribute()
    {
        return parseToDateTh($this->creation_date);
    }

    public function getUpdatedAtFormatAttribute()
    {
        return parseToDateTh($this->creation_date);
    }

    public function getApprovedAtFormatAttribute()
    {
        return parseToDateTh($this->approved_date);
    }

    public function getAsOfDateFormatAttribute()
    {
        return parseToDateTh($this->as_of_date);
    }

    public function getLastUpdateDateFormatAttribute()
    {
        return parseToDateTh($this->last_update_date);
    }

    public function getCreationDateFormatAttribute()
    {
        return parseToDateTh($this->creation_date);
    }

    public function getCanAttribute()
    {
        $can = (object)[];
        $status = trim($this->approved_status);
        switch (strtoupper($status)) {
            case 'ACTIVE':
                $can->edit = false;
                $can->approve = false;
                break;
            case 'APPROVED':
                $can->edit = false;
                $can->approve = false;
                break;
            case 'INACTIVE':
                $can->edit = true;
                $can->approve = true;
                break;
            case 'CANCEL':
                $can->edit = false;
                $can->approve = false;
                break;
            default:
                $can->edit = true;
                $can->approve = true;
                break;
        }

        return $can;
    }

    public function getStatusLableHtmlAttribute()
    {
        return view('planning.production-biweekly._lable_status', ['status' => trim($this->approved_status)])->render();
    }
}
