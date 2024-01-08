<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PtirRenewCarInsurancesView extends Model
{
    use HasFactory;
    protected $table = "ptir_renew_car_insurances";
    public $timestamps = false;

    private $limit = 50;

    public function getRenewTypeLov($keyword)
    {
        $collection = PtirRenewCarInsurancesView::select(DB::raw("
            lookup_code, 
            meaning,
            description,
            lookup_type,
            tag,
            (case when lookup_type = 'PTIR_RENEW_CAR_INSURANCES' then
                'IRS0002'
            when lookup_type = 'PTIR_RENEW_CAR_ACT' then 
                'IRS0003'
            when lookup_type = 'PTIR_RENEW_CAR_LICENSE_PLATE' then 
                'IRS0004'
            when lookup_type = 'PTIR_RENEW_CAR_INSPECTION' then 
                'IRS0005'
            else 
                lookup_type
            end) renew_program_code
        "))
        ->when($keyword, function ($query, $keyword) {
            return $query->where(function($r) use ($keyword) {
                $r->where('lookup_code', 'like', "${keyword}%")
                    ->orWhere('description', 'like', "%${keyword}%");
            });
        })
        ->orderByRaw("renew_program_code asc, lookup_code asc")
        ->get();

        return $collection;
    }

    public function getRenewTypeLovIRM07($keyword)
    {
        $collection = PtirRenewCarInsurancesView::select('lookup_code', 'meaning', 'description', 'lookup_type')
                                                ->where('lookup_type', 'PTIR_RENEW_CAR_INSURANCES')
                                                ->when($keyword, function ($query, $keyword) {
                                                    return $query->where(function($r) use ($keyword) {
                                                        $r->where('lookup_code', 'like', "${keyword}%")
                                                            ->orWhere('description', 'like', "%${keyword}%");
                                                    });
                                                })
                                                ->orderBy('lookup_code')
                                                ->get();

        return $collection;
    }

}
