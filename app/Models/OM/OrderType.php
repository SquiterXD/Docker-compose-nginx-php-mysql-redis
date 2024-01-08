<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderType extends Model
{
    use HasFactory;

    protected $table = 'ptom_transaction_types_v';
    public $primaryKey = 'order_type_id';

    public function scopeSearch($q, $type)
    {
        // 30112021 -- เปลี่ยนเงื่อนไขโดยไม่ต้อง where product_type ไม่เป็นค่าว่างแล้ว ->whereNotNull('receivables_transaction_type')
        // ให้ where sales_type = domestic ได้เลย
        if ($type == 'domestic') {
            $q->whereRaw("lower(sales_type) = '{$type}'");
        }

        return $q;
    }
}
