<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirGroupsView extends Model
{
    use HasFactory;

    protected $table = "ptir_groups";
    public $timestamps = false;

    public function getAllGroup($id)
    {
        $collection = PtirGroupsView::select('lookup_code as group_code', 'meaning', 'description')
                                    ->whereRaw('lookup_code = nvl(?, lookup_code)', [$id]) 
                                    ->orderBy('lookup_code', 'asc')
                                    ->get();
        
        return $collection;
    }
}
