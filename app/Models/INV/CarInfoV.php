<?php

namespace App\Models\INV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarInfoV extends Model
{
    use HasFactory;
    protected $table = 'PTINV_CAR_INFO_V';

    public function department()
    {
        return $this->belongsTo('App\Models\INV\CoaDeptCodeV', 'default_dept_code', 'department_code');
    }

    public function aliasName()
    {
        return $this->belongsTo('App\Models\INV\AliasNameV', 'account_code', 'alias_name');
    }

    public function additions()
    {
        return $this->belongsTo('App\Models\INV\FaAdditionV', 'asset_id', 'asset_id')
        ->selectRaw('ROWIDTOCHAR(rowid) as "rowid"')
        ->select('asset_id', 'asset_number', 'asset_key_ccid', 'asset_type', 'tag_number', 'description', 'asset_category_id', 'attribute22');
    }

    public function webFuelOils()
    {
        return $this->belongsTo('App\Models\INV\WebFuelOil', 'car_license_plate', 'car_license_plate');
    }

}
