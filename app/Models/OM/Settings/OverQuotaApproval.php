<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OverQuotaApproval extends Model
{
    use HasFactory;

    protected $table = 'ptom_over_quota_approvals';
    protected $primaryKey = 'over_quota_id';

    public function authority1()
    {
        return $this->belongsTo(AuthoRityList::class, 'authority_id1', 'authority_id');
    }

    public function authority2()
    {
        return $this->belongsTo(AuthoRityList::class, 'authority_id2', 'authority_id');
    }

    public function authority3()
    {
        return $this->belongsTo(AuthoRityList::class, 'authority_id3', 'authority_id');
    }
    public function salesDivision()
    {
        return $this->belongsTo(AuthoRityList::class, 'sales_division_id', 'authority_id');
    }
}
