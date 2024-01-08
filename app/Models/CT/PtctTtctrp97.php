<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CT\PtmesProductWipV;
class PtctTtctrp97 extends Model
{
    use HasFactory;
    protected $table = 'ptct_TTCTRP97';


    public function sumTransactionQuantity($batchID, $wip, $dateFrom , $dateTo)
    {
        dd($batchID, $wip, $dateFrom , $dateTo);
    }
}
