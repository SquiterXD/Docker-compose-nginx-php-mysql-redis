<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class PtStatusYnView extends Model
{
    use HasFactory;
    protected $table   = "pt_status_yn_v";
    public $primaryKey = 'flex_value';

    public function getStatus()
    {
        $collection = PtStatusYnView::select('flex_value', 'flex_value_meaning', DB::raw("(case when flex_value = 'Y' then 
                                                                                                'Active'
                                                                                               else 
                                                                                                'Inactive'
                                                                                           end) description"))->get();


        return $collection;
    }
}
