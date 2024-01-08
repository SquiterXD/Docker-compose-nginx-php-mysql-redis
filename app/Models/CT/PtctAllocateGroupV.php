<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctAllocateGroupV extends Model
{
    use HasFactory;

    protected $table = 'PTCT_ALLOCATE_GROUP_V';
    public $timestamps = false;

    protected $guarded = [];

    public function scopeGetListAllocateGroups($query)
    {
        return $query->select(DB::raw("allocate_group as allocate_group_value, description as allocate_group_label, allocate_group || ' : ' || description as allocate_group_full_label, allocate_group, level_no, meaning, description"))
        ->where('enabled_flag', 'Y')
        ->orderBy('level_no');
    }

    // public static function getListAllocateGroups()
    // {
    //     return [
    //         (object)[
    //             "allocate_group"        => "DEPT",
    //             "allocate_group_value"  => "DEPT",
    //             "allocate_group_label"  => "DEPT",
    //             "level_no"              => "1",
    //         ],
    //         (object)[
    //             "allocate_group"        => "COST",
    //             "allocate_group_value"  => "COST",
    //             "allocate_group_label"  => "COST",
    //             "level_no"              => "2",
    //         ],
    //         (object)[
    //             "allocate_group"        => "PRODUCT",
    //             "allocate_group_value"  => "PRODUCT",
    //             "allocate_group_label"  => "PRODUCT",
    //             "level_no"              => "3",
    //         ]
    //     ];
    // }

    // public static function findAllocateGroupByValue($allocateGroupValue)
    // {
    //     $result = null;
    //     if($allocateGroupValue == "DEPT") {
    //         $result = (object)[
    //             "allocate_group"        => "DEPT",
    //             "allocate_group_value"  => "DEPT",
    //             "allocate_group_label"  => "DEPT",
    //             "level_no"              => "1",
    //         ];
    //     }
    //     if($allocateGroupValue == "COST") {
    //         $result = (object)[
    //             "allocate_group"        => "COST",
    //             "allocate_group_value"  => "COST",
    //             "allocate_group_label"  => "COST",
    //             "level_no"              => "2",
    //         ];
    //     }
    //     if($allocateGroupValue == "PRODUCT") {
    //         $result = (object)[
    //             "allocate_group"        => "PRODUCT",
    //             "allocate_group_value"  => "PRODUCT",
    //             "allocate_group_label"  => "PRODUCT",
    //             "level_no"              => "3",
    //         ];
    //     }
    //     return $result;
    // }

}
