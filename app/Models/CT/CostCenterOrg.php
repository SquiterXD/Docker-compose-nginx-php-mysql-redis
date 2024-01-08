<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostCenterOrg extends Model
{
    use HasFactory;
    protected $table = 'OACT.PTCT_COST_CENTER_ORG';
    public $primaryKey = 'cost_center_org_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

    protected $fillable = [
        'cost_center_id',
        'org_code',
        'description',
        'type'
    ];


}
