<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirAccountsMappingView extends Model
{
    use HasFactory;
    protected $table = "ptir_accounts_mapping_v";
    public $primaryKey = 'account_id';
    public $timestamps = false;

    private $limit = 50;
     
    public function getAccountCodeCombineLov($id, $keyword) 
    {
        $keyword = (isset($keyword)) ? '%'.$keyword.'%' : '%';
        $collection = PtirAccountsMappingView::select('account_id', 'account_code', 'description', 
                                                      'account_combine', 'account_combine_desc')
                                          ->whereRaw('account_id = nvl(?, account_id)
                                                      and (account_code like ? or description like ?)', [$id, $keyword, $keyword])
                                          ->take($this->limit)
                                          ->orderBy('account_code', 'asc')
                                          ->get();

        return $collection;
    }
}
