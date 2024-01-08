<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtqmQtmBrandMappingV extends Model
{
    use HasFactory;

    protected $table  = 'PTQM_QTM_BRAND_MAPPING_V';

    public function scopeGetListQtmBrands($query)
    {
        return $query->select(DB::raw("lot_no as brand_value, product_name as brand_label, lot_no, product_name, product_description, category_code, category_name"))
            ->groupBy('lot_no', 'product_name', 'product_description', 'category_code', 'category_name')
            ->orderBy('product_name');
    }

    public function scopeGetListQtmCigBrands($query)
    {
        return $query->select(DB::raw("lot_no as brand_value, product_name as brand_label, lot_no, product_name, product_description, category_code, category_name"))
            ->where('category_code', 'LIKE',  'C%')
            ->groupBy('lot_no', 'product_name', 'product_description', 'category_code', 'category_name')
            ->orderBy('product_name');
    }

    public function scopeGetListQtmFilterBrands($query)
    {
        return $query->select(DB::raw("lot_no as brand_value, product_name as brand_label, lot_no, product_name, product_description, category_code, category_name"))
            ->where('category_code', 'LIKE',  'F%')
            ->groupBy('lot_no', 'product_name', 'product_description', 'category_code', 'category_name')
            ->orderBy('product_name');
    }

    public function scopeGetListQtmBrandCategories($query)
    {
        return $query->select(DB::raw("category_code as category_value, category_name as category_label, category_code, category_name"))
            ->groupBy('category_code', 'category_name')
            ->orderBy('category_name');
    }

    public function scopeGetListBrands($query)
    {
        return $query->select(DB::raw("lot_no as brand_value, product_name as brand_label, lot_no, product_name, product_description, category_code, category_name"))
            ->groupBy('lot_no', 'product_name', 'product_description', 'category_code', 'category_name')
            ->orderBy('product_name');
    }

    public function scopeGetListLeakBrands($query)
    {
        return $query->select(DB::raw("lot_no as brand_value, product_name as brand_label, lot_no, brand, product_name, product_description, category_code, category_name"))
            ->where('category_code', 'like', 'C%')
            ->groupBy('lot_no', 'brand', 'product_name', 'product_description', 'category_code', 'category_name')
            ->orderBy('product_name');
    }

    public function scopeGetListLeakBrandCategories($query)
    {
        return $query->select(DB::raw("category_code as category_value, category_name as category_label, category_code, category_name"))
            ->where('category_code', 'like', 'C%')
            ->groupBy('category_code', 'category_name')
            ->orderBy('category_name');
    }

    public function scopeGetListCigBrands($query)
    {
        return $query->select(DB::raw("lot_no as brand_value, product_name as brand_label, lot_no, brand, product_name, product_description, category_code, category_name"))
            ->where('category_code', 'like', 'C%')
            ->groupBy('lot_no', 'brand', 'product_name', 'product_description', 'category_code', 'category_name')
            ->orderBy('product_name');
    }

    public function scopeGetListCigBrandCategories($query)
    {
        return $query->select(DB::raw("category_code as category_value, category_name as category_label, category_code, category_name"))
            ->where('category_code', 'like', 'C%')
            ->groupBy('category_code', 'category_name')
            ->orderBy('category_name');
    }

}
