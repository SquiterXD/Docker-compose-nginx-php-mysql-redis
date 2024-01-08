<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportOmr0124V extends Model
{
    use HasFactory;

    protected $table = 'ptom_report_omr0124_v';

    public function scopeSearch($q, $dataSearch)
    {
        // dd('scopeSearch', $q, $dataSearch->all(), $dataSearch->bank_account_name);
        if ($dataSearch->payment_date) {
            $q->whereRaw("trunc(payment_date) = TO_DATE('{$dataSearch->payment_date}','dd/mm/YYYY')");
        }

        if ($dataSearch->bank_account_name) {
            $q->where('bank_account_name', $dataSearch->bank_account_name);
        }

        if ($dataSearch->customer_id) {
            $q->where('customer_id', $dataSearch->customer_id);
        }

        return $q;
    }
}
