<?php

namespace App\Http\Controllers\OM\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Settings\CEBankBranchesV;

class DirectDebitBankController extends Controller
{
    public function getBankBranchs()
    {
        // dd(request()->bank_id);
        $data = CEBankBranchesV::selectRaw('bank_home_country, bank_party_id, bank_name, bank_number,
            branch_party_id, bank_branch_name, branch_number')->where('bank_party_id', request()->bank_id)
            ->where(function($q){
                return $q->whereDate('start_date', '<=', \Carbon\Carbon::now())
                    ->where(function($p) {
                        return $p->whereDate('end_date', '>=', \Carbon\Carbon::now())
                            ->orwhereNull('end_date');
                    });
            })
            ->get();

        // dd($data);

        return response()->json($data);
    }
}
