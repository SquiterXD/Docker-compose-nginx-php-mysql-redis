<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Model;
use stdClass;

class PtirVendorView extends Model
{
    protected $table   = "ptir_vendor_v";
    public $primaryKey = 'vendor_id';

    private $limit = 50;

    /**
     * Get all supplier number
     */
    public function getSupplierNumber($id, $keyword) 
    {
        $keyword = (isset($keyword)) ? '%'.$keyword.'%' : '%';
        $collection = PtirVendorView::select('vendor_id', 
                                             'vendor_name', 
                                             'vendor_number'
                                            )
                                      ->whereRaw('vendor_id = nvl(?, vendor_id)
                                                  and (vendor_number like ? or vendor_name like ?)',
                                                 [$id, $keyword, $keyword])
                                    ->take($this->limit)
                                    ->orderBy('vendor_number', 'asc')
                                    ->get();
     
        return $collection;
    }

    /**
     * Get specifier supplier name
     */
    public function getSupplierName($id) 
    {
        $collection = PtirVendorView::select('VENDOR_NAME')
                                    ->where('VENDOR_ID', $id)
                                    ->first();
        $obj = new stdClass;
        $obj->vendor_name = (isset($collection->vendor_name)) ? $collection->vendor_name : '';
                            
        return $obj;
    }
}
