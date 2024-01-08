<?php

namespace App\Models\Planning\FollowUps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class PtppPlanFollowMainV extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "PTPP_PLAN_FOLLOW_MAIN";
    public $primaryKey = 'follow_main_id';

    protected $appends = [
        'created_at_format',
        'updated_at_format',
        'creation_date_format',
        'last_update_date_format',
        'sysdate_format',
    ];


    public function products()
    {
        return $this->hasMany(\App\Models\Planning\FollowUps\PtppPlanFollowProductV::class, 'follow_main_id', 'follow_main_id');
    }

    public function ppBiweekly()
    {
        return $this->hasOne(\App\Models\Planning\BiWeeklyV::class, 'biweekly_id', 'biweekly_id');
    }

    public function ptBiWeekly()
    {
        return $this->hasOne(\App\Models\Planning\PtBiweeklyV::class, 'biweekly_id', 'biweekly_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by_id');
    }

    public function getSysdateFormatAttribute()
    {
        return parseToDateTh(now());
    }

    public function getCreatedAtFormatAttribute()
    {
        return parseToDateTh($this->creation_date);
    }

    public function getUpdatedAtFormatAttribute()
    {
        return parseToDateTh($this->creation_date);
    }

    public function getLastUpdateDateFormatAttribute()
    {
        return parseToDateTh($this->last_update_date);
    }

    public function getCreationDateFormatAttribute()
    {
        return parseToDateTh($this->creation_date);
    }

    public function getFindWithData($followMainId)
    {
        return (new self)->with(['products', 'ptBiweekly','ppBiWeekly', 'createdBy', 'updatedBy'])->find($followMainId);
    }
}
