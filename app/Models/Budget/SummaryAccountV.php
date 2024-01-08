<?php

namespace App\Models\Budget;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SummaryAccountV extends Model
{
    use HasFactory;
    protected $table        = 'ptie_summary_accounts_v';
    protected $connection   = 'oracle';
}
