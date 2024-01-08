<?php

namespace App\Http\Controllers\INV\Ajax;

use App\Http\Controllers\Controller;
use App\Models\INV\WebFuelDist;
use Illuminate\Http\Request;

class PtinvWebFuelDistController extends Controller
{
    public function index()
    {
        $webFuelDists = WebFuelDist::with(['webFuelOils', 'webFuelOils.carInfos'])
            ->whereHas('webFuelOils', function ($r) {
                $r->when(request()->from_date, function ($q) {
                        $from_date = request()->from_date;
                        $q->where('gl_date', '>=', $from_date);
                    })
                    ->when(request()->to_date, function ($q) {
                        $to_date = request()->to_date;
                        $q->where('gl_date', '<=', $to_date);
                    })
                    ->when(request()->car_license_plate, function ($q) {
                        $q->where("car_license_plate", request()->car_license_plate);
                    })
                    ->whereNotNull('tran_id');
            })
            ->when(request()->car_user, function ($q) {
                $q->whereHas('webFuelOils.carInfos', function ($r) {
                    $r->where('car_user', request()->car_user);
                });
            })
            ->orderBy("created_at", "desc")
            ->get();

        return response()->json($webFuelDists);
    }
}
