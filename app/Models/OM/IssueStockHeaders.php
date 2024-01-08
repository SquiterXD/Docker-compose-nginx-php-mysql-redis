<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueStockHeaders extends Model
{
    use HasFactory;

    protected $table = 'PTOM_ISSUE_STOCK_HEADERS';
    public $primaryKey = 'issue_header_id';

    public function issueable()
    {
        return $this->morphTo();
    }

    public function lines()
    {
        return $this->hasMany('App\Models\OM\IssueStockLines', 'issue_header_id', 'issue_header_id')->orderBy('issue_line_id');
    }

    public function customer()
    {
        return $this->hasOne('App\Models\OM\Customers', 'customer_id', 'customer_id');
    }

    public function transactionType()
    {
        return $this->hasOne('App\Models\OM\TransactionTypeAllV', 'order_type_id', 'order_type_id');
    }
}
