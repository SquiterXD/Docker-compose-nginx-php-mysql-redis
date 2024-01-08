<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Model;

class PtirVendorBranchView extends Model
{
    protected $table   = "ptir_vendor_brach_v";
    public $primaryKey = 'vendor_id';

    /**
     * Get all branch number
     */
    public function getBranchNumber($id) 
    {
        $collection = PtirVendorBranchView::select('branch_code',
                                                   'vendor_site_id',
                                                   'vendor_site_code',
                                                   'vendor_number',
                                                   'vendor_name',
                                                   'vendor_address',
                                                   'vendor_telephone')
                                           ->whereRaw("vendor_id = nvl(?, vendor_id)", [$id])
                                           ->orderBy('branch_code', 'asc')
                                           ->get();
     
        return $collection;        
    }
}
