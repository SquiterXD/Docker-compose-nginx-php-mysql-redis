<?php

namespace App\Http\Controllers\CT\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CT\PtglCoaV;
use App\Models\CT\SetAccountType;
use App\Models\CT\PtglCoaSubAccountV;
use Illuminate\Support\Facades\DB;

class SetAccountTypeController extends Controller
{
    public function getListSetAccountType()
    {
        $ptglCoaSubAccountV = PtglCoaSubAccountV::select('ptct_set_account_types.set_account_type_id AS set_account_type_id', 'description')
            ->selectRaw("
                CONCAT( main_account, sub_account ) AS acc_code,
                CASE WHEN acc_group IS NOT NULL THEN acc_group ELSE 'O' END AS acc_group,
                CASE WHEN is_transfer IS NOT NULL THEN is_transfer ELSE '0' END AS is_transfer
            ")
            ->leftJoin('oact.ptct_set_account_types', function ($join) {
                $join->on('oact.ptct_set_account_types.acc_code', '=', DB::raw('toat.ptgl_coa_sub_account_v.main_account||sub_account'));
            })
            ->get();

        return response()->json($ptglCoaSubAccountV);
    }

    public function update(Request $request)
    {
        $request->validate([
            'acc_code' => 'required',
            'acc_group' => 'required',
            'is_transfer' => 'required',
        ]);

        $setAccountType = SetAccountType::updateOrCreate(
            ['acc_code' => $request->input('acc_code')],
            ['acc_group' => $request->input('acc_group'), 'is_transfer' => $request->input('is_transfer')]
        );
        
        return response()->json($setAccountType);
    }

}
