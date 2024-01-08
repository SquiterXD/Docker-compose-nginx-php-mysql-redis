<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueStockLots extends Model
{
    use HasFactory;

    protected $table = 'PTOM_ISSUE_STOCK_LOTS';
    public $primaryKey = 'issue_lot_id';
}