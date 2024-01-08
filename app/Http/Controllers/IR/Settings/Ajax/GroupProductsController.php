<?php

namespace App\Http\Controllers\IR\Settings\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IR\Settings\PtirGroupProducts;
use App\Models\IR\Settings\PtirProductInvHeaders;

use stdClass;

class GroupProductsController extends Controller
{
    public function updateActiveFlag(Request $request){     
        $id = $request->group_product_id;
        $flag = $request->active_flag;
        $userId = optional(auth()->user())->user_id ?? -1;
        $productInvHeaders = PtirProductInvHeaders::where('group_product_id',$id)
                                                ->first();
        if($productInvHeaders != null){
            if($productInvHeaders->active_flag == 'Y'){
                $data = ['status' => 'error'];
                return response()->json($data); 
            }else {
                (new PtirGroupProducts)->updateActiveFlag($id, $flag, $userId);
                $data = ['status' => 'success'];
                return response()->json($data);
            }
        }else {
            (new PtirGroupProducts)->updateActiveFlag($id, $flag, $userId);
            $data = ['status' => 'success'];
            return response()->json($data);
        }
    }

}
