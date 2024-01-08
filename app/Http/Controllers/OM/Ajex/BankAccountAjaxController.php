<?php

namespace App\Http\Controllers\OM\Ajex;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OM\BankAccounts;

class BankAccountAjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function byBankId($id)
    {
        $bankAccount = BankAccounts::where('bank_id',$id)->get();

        return response()->json(['data' => $bankAccount]);
    }

    public function byShortName($name)
    {
        $bankAccount = BankAccounts::where('short_account_name',$name)->get();

        return response()->json(['data' => $bankAccount]);
    }

}
