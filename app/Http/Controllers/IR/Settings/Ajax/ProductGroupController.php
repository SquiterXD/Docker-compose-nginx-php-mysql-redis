<?php

namespace App\Http\Controllers\IR\Settings\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\IR\Settings\GroupProduct;
use App\Models\IR\Settings\SubGroups;
use App\Models\IR\Settings\SubInventory;
use App\Models\IR\Settings\PtglCoaDeptCodeView;
use App\Models\IR\Settings\ItemCategory;
use App\Models\IR\Settings\ItemLocatorV;
use App\Models\IR\Settings\ProductInvHeader;
use App\Models\IR\Settings\ProductInvLine;

use stdClass;

class ProductGroupController extends Controller
{
    public function index()
    {
        $today = \Carbon\Carbon::now();
        $tableSubInventory = (new SubInventory)->getTable();
        $groupProduct = GroupProduct::where('group_product_id', request()->groupCode)
                        ->with('policySetHeader', 'AccountsMapping', 'assetGroup')
                        ->first();
        $subGroups = SubGroups::where('policy_set_header_id',$groupProduct->policy_set_header_id)
                            ->where('active_flag', 'Y')
                            ->orderBy('sub_group_code', 'asc')
                            ->get();
        $subInventories = \DB::select("     select  DISTINCT
                                                                subinventory_code,
                                                                subinventory_desc
                                            from    {$tableSubInventory}
                                            where   disable_date <= SYSDATE
                                            or      disable_date is null
                                                    ORDER BY subinventory_code ASC              ");
                                                    
        $departments = PtglCoaDeptCodeView::all();
        $itemCategories = ItemCategory::all();

        return response()->json(['data' => [
                'groupProduct'   => $groupProduct,
                'departments'    => $departments,
                'subInventories' => $subInventories,
                'subGroups'      => $subGroups,
                'itemCategories' => $itemCategories,
            ]
        ]);
    }

    public function getLocator(Request $request)
    {
        if($request['subinventory_code'] != null){
            $subinventoryArray = explode(',', $request['subinventory_code']);
            $subinventoryCode = $subinventoryArray[0];
            $subinventoryDesc = $subinventoryArray[1]; 
            $itemLocators = ItemLocatorV::where('parent_flex_value', $subinventoryCode)
                                        ->limit(100)
                                        ->get();
            if($itemLocators->isEmpty()){
                $data = [ 'status' => 'e' ];
                return response()->json($data);
            }else{
                return response()->json(['itemLocators' => $itemLocators]);
            }
        }else {
            $data = [ 'status' => 'clearData' ];
            return response()->json($data);
        }
    }

    public function updateActiveFlag(Request $request){
        $id = $request->header_id;
        $flag = $request->active_flag;
        $confirm = $request->confirm;
        $userId = optional(auth()->user())->user_id ?? -1;
        $headers = ProductInvHeader::find($request->header_id);
        $groupProducts = GroupProduct::find($headers['group_product_id']);
        $subGroups = SubGroups::where('sub_group_code', $headers['sub_group_code'])
                            ->where('policy_set_header_id', $groupProducts['policy_set_header_id'])
                            ->first();

        if($flag == 'Y'){
            if($groupProducts['active_flag'] == 'N' && $subGroups['active_flag'] == 'N'){
                if($confirm == "true"){
                    (new GroupProduct)->updateActiveFlag($groupProducts['group_product_id'], $flag, $userId);
                    (new SubGroups)->updateActiveFlag($subGroups['sub_group_id'], $flag, $userId);
                    (new ProductInvHeader)->updateActiveFlag($id, $flag, $userId);
                    $data = ['status' => 'success'];
                    return response()->json($data);
                }else{
                    $data = ['status' => 'twoClose'];
                    return response()->json($data);
                }
            }
            if($groupProducts['active_flag'] == 'N'){
                if($confirm == "true"){
                    (new GroupProduct)->updateActiveFlag($groupProducts['group_product_id'], $flag, $userId);
                    (new ProductInvHeader)->updateActiveFlag($id, $flag, $userId);
                    $data = ['status' => 'success'];
                    return response()->json($data);
                }else{
                    $data = ['status' => 'IRM0004Close'];
                    return response()->json($data);
                }
            }
            if($subGroups['active_flag']  == 'N'){
                if($confirm == "true"){ 
                    (new SubGroups)->updateActiveFlag($subGroups['sub_group_id'], $flag, $userId);
                    (new ProductInvHeader)->updateActiveFlag($id, $flag, $userId);
                    $data = ['status' => 'success'];
                    return response()->json($data);
                }else {
                    $data = ['status' => 'IRM0009Close'];
                    return response()->json($data);
                }
            }
            if($groupProducts['active_flag'] == 'Y' && $subGroups['active_flag'] == 'Y'){
                (new ProductInvHeader)->updateActiveFlag($id, $flag, $userId);
                $data = ['status' => 'success'];
                return response()->json($data);
            }
        }else{
            (new ProductInvHeader)->updateActiveFlag($id, $flag, $userId);
            $data = ['status' => 'success'];
            return response()->json($data);
        }
       
    }

    public function destroy(Request $request){
        $productInvLine = ProductInvLine::find(request('sub_group_id'));
        $productInvLine->delete();
        $data = [ 'status' => 's' ];

        return response()->json($data);
    }

    public function getValueSet(Request $request){
        $text = $request->get('query');
        if($request->status == 'Edit'){
            $subinventoryCode = $request->subinventory_code;
        }else{
            $subinventoryArray = explode(',', $request['subinventory_code']);
            $subinventoryCode = $subinventoryArray[0];
            $subinventoryDesc = $subinventoryArray[1]; 
        }
        // $subinventoryCode = $request->get('subinventory_code');
        // \Log::info($text);
        if($text){
            $data = ItemLocatorV::when($text, function($query, $text) use($subinventoryCode){
                                    return  $query->whereRaw("parent_flex_value = '{$subinventoryCode}'")
                                                ->whereRaw('UPPER(flex_value) LIKE ?', ['%' . strtoupper($text) . '%'])
                                                ->orWhereRaw('UPPER(description) LIKE ?', ['%' . strtoupper($text) . '%']);
                                })
                                ->orderBy('flex_value')
                                ->limit(50)
                                ->get();
        }else {
            $data = ItemLocatorV::where('parent_flex_value', $subinventoryCode)
                                ->orderBy('flex_value')
                                ->limit(50)
                                ->get();
        }

        return response()->json(['data' => $data]);
    }    

    public function getDataActiveFlag(Request $request){
        $flag = $request->active_flag;
        $headers = ProductInvHeader::find($request->header_id);
        $groupProducts = GroupProduct::find($headers['group_product_id']);
        $subGroups = SubGroups::where('sub_group_code', $headers['sub_group_code'])
                            ->where('policy_set_header_id', $groupProducts['policy_set_header_id'])
                            ->first();
        if($flag == 'Y'){
            if($groupProducts['active_flag'] == 'N' && $subGroups['active_flag'] == 'N'){
                $data = ['status' => 'twoClose'];
                return response()->json($data);
            }
            if($groupProducts['active_flag'] == 'N'){
                $data = ['status' => 'IRM0004Close'];
                return response()->json($data);
            }
            if($subGroups['active_flag']  == 'N'){
                $data = ['status' => 'IRM0009Close'];
                return response()->json($data);
            }
            if($groupProducts['active_flag'] == 'Y' && $subGroups['active_flag'] == 'Y'){
                $data = ['status' => 'success'];
                return response()->json($data);
            }  
        }else{
            $data = ['status' => 'success'];
            return response()->json($data);
        }   
    }

}
