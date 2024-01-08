<?php
namespace App\Models\PP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtppPPR0004V extends Model
{
	use HasFactory;
    protected $table = 'PTPP_PPR0004_RPT_V';

    public function scopeSearch($q, $productType)
    {
    	if ($productType == 'all') {
    		$q;
    	}else{
    		$q->where('product_type', $productType);
    	}

    	return $q;
    }
}
