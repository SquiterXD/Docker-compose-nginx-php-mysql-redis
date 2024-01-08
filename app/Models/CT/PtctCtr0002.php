<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctCtr0002 extends Model
{
    use HasFactory;
    protected $table = 'oact.ptct_CTR0002';
    public $timestamps = false;

    protected $guarded = [];

    public function getItemListAttribute() {
        if($this->level_no == 1)
        return $this->where('product_item_id', $this->inventory_item_id)->where('level_no', 2)->where('rpt_id', $this->rpt_id)->get();
    }

}
