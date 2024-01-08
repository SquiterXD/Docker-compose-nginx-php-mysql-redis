<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SequenceEcom extends Model
{
    use HasFactory;

    protected $table = 'ptom_sequence_ecoms';
    protected $primaryKey = 'sequence_ecom_id';

    public function scopeSearch($q, $request)
    {
        $items       = [];

        array_push($items, request()->item_id, request()->ecom_item);

        $itemId      = request()->item_id;
        $ecomItem    = request()->ecom_item;
        $salesType   = request()->sales_type;
        $productType = request()->product_type;
        $status      = request()->status;

        // dd($q, $request, $itemId, $ecomItem);
        return  $q->when($itemId, function($q) use($items) {
                    $q->whereIn('item_id', $items);
                })->when($ecomItem, function($q) use($items) {
                    $q->whereIn('item_id', $items);
                })->when($salesType, function($q) use($salesType) {
                    $q->where('sale_type_code', $salesType);
                })->when($productType, function($q) use($productType) {
                    $q->where('product_type_code', $productType);
                })->when($status, function($q) use($status) {
                    if ($status == 'Active') {
                        $q->whereRaw(' trunc(sysdate) between trunc(start_date) and nvl(trunc(end_date), trunc(sysdate))');
                        // $q->whereRaw("trunc(sysdate) between start_date and end_date");
                        // $q->when('start_date' != '', function ($d) {
                        //     return $d->where('start_date', '<=', date("Y-m-d"));
                        // })
                        // ->when('end_date' != '', function ($d) {
                        //     return $d->where('end_date', '>=', date("Y-m-d"));
                        // })
                        // ->orWhere('start_date', null)
                        // ->orWhere('end_date', null);

                        // dd(date("Y-m-d"), $this);
                        // $q->where('start_date', '<=', date("Y-m-d"))
                        // ->when('end_date' != '', function ($d) {
                        //     return $d->where('end_date', '>=', date("Y-m-d"));
                        // });
                            // 

                    } elseif ($status == 'Inactive') {
                        $q->whereRaw("trunc(sysdate) not between start_date and end_date");
                        
                        // $q->->whereRaw("TRUNC(start_date) <> TRUNC(sysdate)")
                        // ->whereRaw("TRUNC(end_date) <> TRUNC(sysdate)");
                    }
                    
                });
    }
    
    public function salesType()
    {
        return $this->belongsTo(SalesTypeV::class, 'sale_type_code', 'value');
    }

    public function productTypeDomestic()
    {
        return $this->belongsTo(ProductTypeDomestic::class, 'product_type_code', 'lookup_code');
    }

    public function productTypeExport()
    {
        return $this->belongsTo(ProductTypeExport::class, 'product_type_code', 'lookup_code');
    }

    public function taste()
    {
        return $this->belongsTo(TasteV::class, 'taste_code', 'value');
    }

    public function mainAccount()
    {
        return $this->belongsTo(MainAccount::class, 'main_account_code', 'main_account');
    }

    public function subAccount()
    {
        return $this->belongsTo(SubAccount::class, 'sub_account_code', 'sub_account')->where('main_account', $this->main_account_code);
    }

}
