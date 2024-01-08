<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountInfo extends Model
{
    use HasFactory;
    protected $table = 'PTIE_ACCOUNT_INFO_V';

    public function scopeCompany($query)
    {
        return $query->whereApplicationColumnName('SEGMENT1');
    }

    public function scopeEVM($query)
    {
        return $query->whereApplicationColumnName('SEGMENT2');
    }

    public function scopeDepartment($query)
    {
        return $query->whereApplicationColumnName('SEGMENT3');
    }

    public function scopeCostCenter($query)
    {
        return $query->whereApplicationColumnName('SEGMENT4');
    }

    public function scopeBudgetYear($query)
    {
        return $query->whereApplicationColumnName('SEGMENT5');
    }

    public function scopeBudgetType($query)
    {
        return $query->whereApplicationColumnName('SEGMENT6');
    }

    public function scopeBudgetDetail($query)
    {
        return $query->whereApplicationColumnName('SEGMENT7');
    }

    public function scopeBudgetReason($query)
    {
        return $query->whereApplicationColumnName('SEGMENT8');
    }

    public function scopeAccount($query)
    {
        return $query->whereApplicationColumnName('SEGMENT9');
    }

    public function scopeSubAccount($query)
    {
        return $query->whereApplicationColumnName('SEGMENT10');
    }

    public function scopeReserve1($query)
    {
        return $query->whereApplicationColumnName('SEGMENT11');
    }

    public function scopeReserve2($query)
    {
        return $query->whereApplicationColumnName('SEGMENT12');
    }
}
