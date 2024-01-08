<?php

namespace App\Http\Controllers\EAM;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function preventiveMaintenancePlan()
    {
        $user = Auth::user();
        $profile = getDefaultData('/eam/transaction/preventive-maintenance-plan');
        $user->department = $profile->department;
        $year = request()['year'] ?? null;
        $version = request()['version'] ?? null;

        return view('eam.transaction.preventive-maintenance-plan', ['user'=>$user, 
                                                                    'year'=>$year,
                                                                    'version'=>$version]);
    }
}
