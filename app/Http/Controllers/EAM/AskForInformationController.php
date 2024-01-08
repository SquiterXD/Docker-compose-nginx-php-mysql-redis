<?php

namespace App\Http\Controllers\EAM;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AskForInformationController extends Controller
{
    public function checkSparePartsInventory()
    {
        return view('eam.ask-for-information.check-spare-parts-inventory');
    }
    public function partsTransferredWarehouse()
    {
        $user = Auth::user();
        return view('eam.ask-for-information.parts-transferred-warehouse', ['user'=>$user]);
    }
}
