<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductGroup extends Model
{
    use HasFactory;
    protected $table = 'OACT.PTCT_PRODUCT_GROUPS';

    public $primaryKey = 'product_group_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

    protected $fillable = [
        'cost_center_id',
        'code',
        'name',
        'ratio',
        'unit_group_code',
        'unit_cost_center_code',
        'width',
        'long',
        'around',
        'area'
    ];

    public function productGroupDetails()
	{
		return $this->hasMany(ProductGroupDetail::class, 'product_group_id', 'product_group_id');
	}

    public function productGroupLots()
    {
        return  $this->hasMany(ProductGroupLot::class, 'product_group_id', 'product_group_id');
    }

}
