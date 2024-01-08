<?php

namespace App\Http\Controllers\OM\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Settings\PoVendorsV;

class VendorController extends Controller
{
    public function index()
    {

        $text  = request()->get('query');
        $vender  = request()->get('vender');

        // dd($vender);
        // if (vender) {
        //     # code...
        // }

        $data = PoVendorsV::when($text, function ($query, $text) {
                    return $query->where(function($r) use ($text) {
                        $r->where('vendor_code', 'like', "%${text}%")
                            ->orWhere('vendor_name', 'like', "%${text}%");
                    });
                })
                ->when($vender, function ($query, $vender) {
                    return $query->where(function($r) use ($vender) {
                        $r->where('vendor_code', 'like', "%${vender}%")
                            ->orWhere('vendor_name', 'like', "%${vender}%")
                            ->orWhere('vendor_id', 'like', "%${vender}%");
                    });
                })
                ->limit(30)
                ->get();
        // dd($data);
        // $data = Company::selectRaw('meaning, description')
        //                     ->when($text, function ($query, $text) {
        //                     return $query->where(function($r) use ($text) {
        //                         $r->where('description', 'like', "%${text}%")
        //                             ->orWhere('meaning', 'like', "${text}%");
        //                     });
        //                 })
        //                 ->get();

        return response()->json($data);
    }
}
