<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PtirEffectiveDate extends Model
{
    use HasFactory;
    protected $table = "ptir_effective_date";
    public $timestamps = false;

    public function getEffectiveDate($year)
    {
        $collection = PtirEffectiveDate::select('lookup_code', 'meaning', 'description', 
                                                DB::raw("to_char(start_date_active, 'dd/mm/yyyy','nls_calendar=''Thai Buddha'' nls_date_language = Thai') start_date_active, 
                                                         to_char(add_months(start_date_active, 12), 'dd/mm/yyyy','nls_calendar=''Thai Buddha'' nls_date_language = Thai') end_date_active"))
                                        ->where('lookup_code', $year)
                                        ->first();
                    
        return $collection;
    }
}
