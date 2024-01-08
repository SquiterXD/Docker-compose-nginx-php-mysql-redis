<?php

namespace App\Http\Controllers\CT\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CT\SetAccountTypeDept;

class SetAccountTypeDeptController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'acc_code' => 'required',
            'depte_code' => 'required',
            'acc_group' => 'required',
            'is_active' => 'required',
        ]);

        $setAccountTypeDept = SetAccountTypeDept::updateOrCreate(['acc_code' => $request->input('acc_code'), 'depte_code' => $request->input('depte_code')],
            [   
                'acc_group' => $request->input('acc_group'), 
                'is_active' => $request->input('is_active')
            ]
        );
        
        return response()->json($setAccountTypeDept);
    }
}
