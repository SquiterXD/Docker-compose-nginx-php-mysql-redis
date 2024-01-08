<?php

namespace App\Http\Controllers\OM\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PriceListCheckController extends Controller
{
    public function checkHeader()
    {
        $start_date = date('Y-m-d', strtotime(request()->row_start_date));
        // $effective_dates_from = date('Y-m-d', strtotime(request()->effective_dates_from));

        // dd(request()->all(), $start_date, parseFromDateTh(request()->effective_dates_from));

        if ($start_date < request()->effective_dates_from) {
            $data = true;
        } else {
            $data = false;
        }

        return response()->json($data);
    }

    public function checkHeaderDateTo()
    {
        // dd(request()->all(), parseFromDateTh(request()->effective_dates_to));
        

        // dd($start_date, parseFromDateTh($start_date), parseFromDateTh(request()->effective_dates_to))
        if (request()->row_end_date) {
            $end_date = date('Y-m-d', strtotime(request()->row_end_date));

            if ($end_date > request()->effective_dates_to) {
                $data = true;
            } else {
                $data = false;
            }

        } else {
            $start_date = date('Y-m-d', strtotime(request()->row_start_date));
            
            if ($start_date > request()->effective_dates_to) {
                $data = true;
            } else {
                $data = false;
            }
        }
        

        

        return response()->json($data);
    }
}
