<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInvHeader extends Model
{
    use HasFactory;

    protected $table = "ptir_product_inv_headers";
    public $primaryKey = 'header_id';

    public function lines()
    {
        return $this->hasMany(ProductInvLine::class, 'header_id', 'header_id');
    }

    public function scopeSearch($q, $department, $status)
    {
        return $q->when($department, function($q) use($department) {
            $q->where('department_code', 'like', '%' . $department . '%');
            })
            ->when($status, function($q) use($status) {
                $q->where('status', $status);
        });
    }

    public function groupProduct()
    {
        return $this->belongsTo(GroupProduct::class, 'group_product_id', 'group_product_id');
    }

    public function department()
    {
        return $this->belongsTo(PtglCoaDeptCodeView::class, 'department_code', 'department_code');
    }

    public function subInventory()
    {
        return $this->belongsTo(SubInventory::class, 'subinventory_code', 'subinventory_code');
    }

    public function subGroups()
    {
        return $this->belongsTo(SubGroups::class, 'sub_group_code', 'sub_group_code');
    }
    
    public function productInvLines()
    {
        return $this->hasMany(ProductInvLine::class, 'header_id', 'header_id');
    }

    public function scopeSearchProductHeader($q, $request)
    {
        if ($request){
            
            if ($request['policy_set_header_id'] != null) {

                $policySetHeaderId = $request['policy_set_header_id'];

                $q->whereHas('groupProduct', function($q) use($policySetHeaderId){
                    $q->where('policy_set_header_id', $policySetHeaderId);
                })->get();

            } else {
                $q;
            }

            if ($request['asset_group'] != null) {

                $assetGroup = $request['asset_group'];

                $q->whereHas('groupProduct', function($q) use($assetGroup){
                    $q->where('asset_group_code', $assetGroup);
                })->get();

            } else {
                $q;
            }

            if ($request['group_products'] != null) {
                $q->where('group_product_id', $request['group_products'])->get();
            } else {
                $q;
            }

            if ($request['status'] != null) {
                $q->where('active_flag', $request['status'])->get();
            } else {
                $q;
            }

            if ($request['department_code'] != null) {
                $q->where('department_code', $request['department_code'])->get();
            } else {
                $q;
            }
            
            if ($request['subinventory_code'] != null) {
                $subinventoryArray = explode(',', $request['subinventory_code']);
                $subinventoryCode = $subinventoryArray[0];
                $subinventoryDesc = $subinventoryArray[1]; 
                $q->where('subinventory_code', 'like', '%'. $subinventoryCode .'%')->get();
                $q->where('subinventory_desc', 'like', '%'. $subinventoryDesc .'%')->get();
            } else {
                $q;
            }

            if ($request['sub_group_code'] != null) {
               
                $arr = explode(" : ",$request['sub_group_code']);
                $subGroupCode = $arr[0];
                $subGroupDes = $arr[1];
                
                $q->whereHas('subGroups', function($q) use ($subGroupCode, $subGroupDes){
                    $q->where('sub_group_code', $subGroupCode)
                      ->where('sub_group_description', $subGroupDes);
                })->get();
                
            } else {
                $q;
            }

        }

        return  $q;
    }

    public function updateActiveFlag($id, $flag, $userId) 
    {
        $db                     = ProductInvHeader::find($id);
        $db->ACTIVE_FLAG        = $flag;
        $db->LAST_UPDATED_BY    = $userId;
        $db->LAST_UPDATE_DATE   = now();
        $db->save();
    }
}
