<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Model;
use stdClass;

class PtirCustomerView extends Model
{
    protected $table   = "ptir_customer_v";
    public $primaryKey = 'customer_id';

    private $limit = 50;

    /**
     * Get all customer number
     */
    public function getCustomerNumber($id, $keyword)
    {
        $keyword = (isset($keyword)) ? '%'.$keyword.'%' : '%';
        $collection = PtirCustomerView::select('customer_id', 'customer_number', 'customer_name')
                                        ->whereRaw('customer_id = nvl(?, customer_id)
                                                    and (customer_number like ? or customer_name like ?)', 
                                                    [$id, $keyword, $keyword])
                                        ->take($this->limit)
                                        ->orderBy('customer_number', 'asc')
                                        ->get();
     
        return $collection;
    }

    /**
     * Get specifier customer keyword
     */
    public function getCustomerName($id)
    {
       
        $collection = PtirCustomerView::select('CUSTOMER_NAME')
                                        ->where('CUSTOMER_NUMBER', $id)
                                        ->first();
        $obj = new stdClass;
        $obj->customer_keyword = (isset($collection->customer_name)) ? $collection->customer_name : '';

        return $obj;
    }
}
