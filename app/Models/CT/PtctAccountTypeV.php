<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class PtctAccountTypeV extends Model
{
    use HasFactory;
    protected $table = 'OACT.PTCT_ACCOUNT_TYPE_V';
    public $timestamps = false;

    protected $guarded = [];

    public function scopeGetListAccountTypes($query)
    {
        return $query->select(DB::raw("ACCOUNT_TYPE, DESCRIPTION AS ACCOUNT_TYPE_DESC, DESCRIPTION"))
            ->orderBy('ACCOUNT_TYPE');
    }

    public function scopeGetListOemAccountTypes($query)
    {
        return $query->select(DB::raw("ACCOUNT_TYPE, DESCRIPTION AS ACCOUNT_TYPE_DESC, DESCRIPTION"))
            ->orderBy('ACCOUNT_TYPE');
    }

    public static function getAccountTypeDesc($accoutTypes, $accoutTypeValue) {
        $result = "";
        foreach($accoutTypes as $accoutType) {
            if($accoutType->account_type == $accoutTypeValue) {
                $result = $accoutType->description;
            }
        }
        return $result;
    }
}
