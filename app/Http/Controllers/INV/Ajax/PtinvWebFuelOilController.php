<?php

namespace App\Http\Controllers\INV\Ajax;

use App\Http\Controllers\Controller;
use App\Models\INV\WebFuelOil;
use Illuminate\Http\Request;

class PtinvWebFuelOilController extends Controller
{
    public function index()
    {
        $webFuelOils = WebFuelOil::with(['webFuelDists', 'carInfos'])
            ->when(request()->from_date, function ($q) {
                $from_date = \Carbon\Carbon::parse(request()->from_date);
                $q->whereDate('transaction_date', '>=', $from_date);
            })
            ->when(request()->to_date, function ($q) {
                $to_date = \Carbon\Carbon::parse(request()->to_date);
                $q->whereDate('transaction_date', '<=', $to_date);
            })
            ->when(request()->car_license_plate, function ($q) {
                $q->where("car_license_plate", request()->car_license_plate);
            })
            ->when(request()->car_user, function ($q) {
                $q->whereHas('carInfos', function ($r) {
                    $r->where('car_user', request()->car_user);
                });
            })
            ->whereNotNull('tran_id')
            ->orderBy('transaction_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        // dd($webFuelOils);
        return response()->json($webFuelOils);
    }
}
