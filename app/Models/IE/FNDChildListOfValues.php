<?php

namespace App\Models\IE;

use \App\Models\IE\AccountInfo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FNDChildListOfValues extends Model
{
    use HasFactory;
    protected $table = 'ptie_fnd_child_lovs_v';

    public function scopeEnabled($query)
    {
        return $query->where('enable', 'Y');
    }

    public function scopeParent($query)
    {
        return $query->where('parent_flag', 'Y');
    }

    public function scopeDepartment($query,$orgId = null)
    {
        $flexValueSetName = self::getFlexNameByAppColumnName('SEGMENT3',$orgId);
        return $query->where('flex_value_set_name',$flexValueSetName)->enabled();
    }

    private static function getFlexNameByAppColumnName($applicationColumnName,$orgId)
    {
        if(!$orgId)
        // $orgId = \Auth::user()->employee->org_id;
        $orgId = 81;

        $accountInfo = AccountInfo::whereApplicationColumnName($applicationColumnName)->first();

        if(!$accountInfo)
        return ;

        return $accountInfo->flex_value_set_name;
    }
}
