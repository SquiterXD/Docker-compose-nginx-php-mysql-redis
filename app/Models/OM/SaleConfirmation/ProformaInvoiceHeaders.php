<?php

namespace App\Models\OM\SaleConfirmation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProformaInvoiceHeaders extends Model
{
    use HasFactory;

    protected $table = 'PTOM_PROFORMA_INVOICE_HEADERS';
    public $primaryKey = 'PI_HEADER_ID';
    public $timestamps = false;

    public function customer()
    {
        return $this->hasOne('App\Models\OM\Customers', 'customer_id', 'customer_id');
    }

    public function lines()
    {
        return $this->hasMany(ProformaInvoiceLines::class, 'pi_header_id', 'pi_header_id')->orderBy('pi_line_id');
    }

    public function scopeStatusConfirm()
    {
        return $this->where('pick_release_status', 'Confirm');
    }

    public function scopeExchangeRateNotNull()
    {
        return $this->whereNotNull('pick_exchange_rate');
    }

    public function scopeOmp0078invoice()
    {
        return $this->where('program_code', 'OMP0072');
    }

    public function scopeClosedflagconditions() 
    {
        return $this->whereNull('web_batch_no')->whereNull('ar_close_group_id')->whereNull('ar_invoice_web_batch_no')->whereNull('ar_invoice_group_id');
    }

    public function transactionType()
    {
        return $this->hasOne('App\Models\OM\TransactionTypeAllV', 'order_type_id', 'order_type_id');
    }

    public function issues()
    {
        return $this->morphMany('App\Models\OM\IssueStockHeaders', 'issueable');
    }
}
