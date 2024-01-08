<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueStockLines extends Model
{
    use HasFactory;

    protected $table = 'PTOM_ISSUE_STOCK_LINES';
    public $primaryKey = 'issue_line_id';

    public function issueable()
    {
        return $this->morphTo();
    }

    public function onHands()
    {
        return $this->hasMany('App\Models\OM\IssueStockLots', 'issue_line_id', 'issue_line_id')->orderBy('issue_lot_id');
    }

    public function getTotalIssueQtyAttribute()
    {
        return $this->onHands()->sum('issue_quantity');
    }
}