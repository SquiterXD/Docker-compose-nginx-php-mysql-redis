<?php

namespace App\Http\Controllers\IR\Settings\Ajax;

use App\Models\IR\Settings\SubGroups;
use App\Models\IR\Settings\PtirProductInvHeaders;
use App\Models\IR\Settings\PtirGroupProducts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubGroupsController extends Controller
{
    public function show($id)
    {
        $subGroups = SubGroups::where('policy_set_header_id', $id)
                                    ->get();
                                            
        return view('ir.settings.sub-groups._table_edit_rows', compact('subGroups'));
        return response()->json(['subGroups' => $subGroups]);
    }

    public function checkInactive(Request $request)
    {
        $subGroupCode = $request['sub_group_code'];
        $flag = $request['active'];
        $id = $request['id'];
        $userId = optional(auth()->user())->user_id ?? -1;
        $policySetHeaderId = SubGroups::where('sub_group_code', $subGroupCode)
                                        ->where('sub_group_id', $id)
                                        ->value('policy_set_header_id');
        $subGroupCode = SubGroups::where('sub_group_code', $subGroupCode)
                                    ->where('sub_group_id', $id)
                                    ->value('sub_group_code');
        $groupProducts = PtirGroupProducts::where('policy_set_header_id', $policySetHeaderId)->get();
        foreach ($groupProducts as $key => $data) {
            $isProductInvHeaders = PtirProductInvHeaders::where('sub_group_code', $subGroupCode)
                                                        ->where('group_product_id', $data['group_product_id'])
                                                        ->first();
            if($isProductInvHeaders != null && $isProductInvHeaders['group_product_id'] == $data['group_product_id']){
                if($isProductInvHeaders['active_flag'] == 'Y'){
                    $data = ['status' => 'error'];
                    return response()->json($data); 
                }else{
                    (new SubGroups)->updateActiveFlag($id, $flag, $userId);
                    $data = ['status' => 'success'];
                    return response()->json($data); 
                }
            }
        }
        foreach ($groupProducts as $key => $value) {
            $isProductInvHeaders = PtirProductInvHeaders::where('sub_group_code', $subGroupCode)
                                                        ->where('group_product_id', $value['group_product_id'])
                                                        ->first();
            if($isProductInvHeaders == null){
                (new SubGroups)->updateActiveFlag($id, $flag, $userId);
                $data = ['status' => 'success'];
                return response()->json($data);
            }
        }
    }

    public function destroy(Request $request)
    {
        $productInvHeaders = PtirProductInvHeaders::where('sub_group_code',request('sub_group_id'))
                                                ->first();
        if($productInvHeaders != null){
            $data = [   'status' => 'e',
                        'index' => request('index') ];
            return response()->json($data);
        }else {
            $subGroups = SubGroups::find(request('sub_group_id'));
            $subGroups->delete();
            $data = [   'status' => 's',
                        'index' => request('index') ];
            return response()->json($data); 
        }
        
    }


}
