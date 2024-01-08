<?php

namespace App\Http\Controllers\OM\Api;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OM\ClaimHeaders;
use App\Models\OM\ClaimStatusV;
use App\Models\OM\Customers;
use App\Models\OM\UomV;
use App\Models\OM\Attachments;
use DB;
use PDO;

class TrackClaimController extends Controller
{
    public function getHeaders()
    {
        $claimStatusList = ClaimStatusV::where('enabled_flag','Y')
                                    ->get();
        // $headersList = ClaimHeaders::where('program_code','OMP0049')
        //                             ->where('sales_type','DOMESTIC')
        //                             ->with('customers')
        //                             ->orderBy('claim_header_id', 'DESC')
        //                             ->get();
        $headersList = ClaimHeaders::whereNotNull('claim_number')
                                    ->where('sales_type','DOMESTIC')
                                    ->with('customers')
                                    ->orderBy('claim_header_id', 'DESC')
                                    ->get();
        $customerList = Customers::where('sales_classification_code','Domestic')
                                ->whereNotNull('customer_number')
                                ->orderBy('customer_number', 'asc')
                                ->get();

        return response()->json([   'headersList' => $headersList,
                                    'claimStatusList' => $claimStatusList,
                                    'customerList' => $customerList         ]);
    }

    public function getSearch()
    {
        $tableClaimHeaders = new ClaimHeaders();
        $headerList = $tableClaimHeaders->search(request()->all());
        $headerList->map(function ($item, $key) {
            $item->uom_claim_quantity_cbb = UomV::where('domestic', 'Y')
                                                    ->where('uom_code', 'CGC')
                                                    ->first();
            $item->uom_claim_quantity_carton = UomV::where('domestic', 'Y')
                                                    ->where('uom_code', 'CG2')
                                                    ->first();
            $item->uom_claim_quantity_pack = UomV::where('domestic', 'Y')
                                                    ->where('uom_code', 'CGP')
                                                    ->first();
        });
        
        return response()->json([   'headerList' => $headerList     ]);
    }

    public function getCancleClaim()
    {
        $userId = optional(auth()->user())->user_id ?? -1;
        $claimStatus = ClaimStatusV::select('lookup_code', 'meaning', 'description', 'enabled_flag')
                                    ->where('lookup_code', '9')
                                    ->where('enabled_flag', 'Y')
                                    ->first();

        \DB::beginTransaction();
        try {   

            $claimHeaders                       = ClaimHeaders::find(request()->claim_header_id);
            $claimHeaders->status_claim_code    = $claimStatus['lookup_code'];
            $claimHeaders->status_claim         = $claimStatus['meaning'];
            $claimHeaders->last_updated_by      = $userId;
            $claimHeaders->last_update_date     = now();
            
            $claimHeaders->save();
            // SUCCESS CREATE
            \DB::commit();

        } catch (\Exception $e) {
                // ERROR CREATE
                \DB::rollBack();
                if(request()->ajax()){
                        $result['status'] = 'ERROR';
                        $result['err_msg'] = $e->getMessage();
                        return $result;
                }else{
                        \Log::error($e->getMessage());
                        return abort('403');
                }  
        }
        $result = 'success';
        return response()->json(['result' => $result]);
    }

    public function getConfirmReceipt()
    {
        $userId = optional(auth()->user())->user_id ?? -1;
        $claimStatus = ClaimStatusV::select('lookup_code', 'meaning', 'description', 'enabled_flag')
                                    ->where('lookup_code', '6')
                                    ->where('enabled_flag', 'Y')
                                    ->first();

        \DB::beginTransaction();
        try {   

            $claimHeaders                       = ClaimHeaders::find(request()->claim_header_id);
            $claimHeaders->status_claim_code    = $claimStatus['lookup_code'];
            $claimHeaders->status_claim         = $claimStatus['meaning'];
            $claimHeaders->last_updated_by      = $userId;
            $claimHeaders->last_update_date     = now();
            
            $claimHeaders->save();
            // SUCCESS CREATE
            \DB::commit();

        } catch (\Exception $e) {
                // ERROR CREATE
                \DB::rollBack();
                if(request()->ajax()){
                        $result['status'] = 'ERROR';
                        $result['err_msg'] = $e->getMessage();
                        return $result;
                }else{
                        \Log::error($e->getMessage());
                        return abort('403');
                }  
        }
        $result = 'success';
        return response()->json(['result' => $result]);
    }

    public function getConfirmCreditNote()
    {
        $userId = optional(auth()->user())->user_id ?? -1;
        $claimStatus = ClaimStatusV::select('lookup_code', 'meaning', 'description', 'enabled_flag')
                                    ->where('lookup_code', '7')
                                    ->where('enabled_flag', 'Y')
                                    ->first();

        \DB::beginTransaction();
        try {   

            $claimHeaders                       = ClaimHeaders::find(request()->claim_header_id);
            $claimHeaders->status_claim_code    = $claimStatus['lookup_code'];
            $claimHeaders->status_claim         = $claimStatus['meaning'];
            $claimHeaders->last_updated_by      = $userId;
            $claimHeaders->last_update_date     = now();
            
            $claimHeaders->save();
            // SUCCESS CREATE
            \DB::commit();

        } catch (\Exception $e) {
                // ERROR CREATE
                \DB::rollBack();
                if(request()->ajax()){
                        $result['status'] = 'ERROR';
                        $result['err_msg'] = $e->getMessage();
                        return $result;
                }else{
                        \Log::error($e->getMessage());
                        return abort('403');
                }  
        }
        $result = 'success';
        return response()->json(['result' => $result]);
    }

    public function getImage()
    {
        $image = Attachments::where('attachment_id', request()->attachment_id)->first();
        $pathName = self::substrPathName($image->path_name);
        $pathImage = base_path($pathName.$image->file_name);
        $imagesType = pathinfo($pathImage, PATHINFO_EXTENSION);
        $dataImage = file_get_contents($pathImage);
        $image = 'data:image/'.$imagesType.';base64,'.base64_encode($dataImage);
        return response()->json(['result' => $image]);
    }

    public function substrPathName($para){
        $db = DB::connection('oracle')->getPdo();
        $sql  = "
                    DECLARE
                    v_char varchar2(300)    := '{$para}';
                    v_out varchar2(300)     := null;
                    
                    BEGIN
                    dbms_output.put_line('---------------------  S T A R T. -------------------');
                    
                    select  substr(V_char,instr(V_char,'storage'),LENGTH(V_char)-instr(V_char,'storage')+1)
                    
                    into :v_out
                    from dual;
            
                    dbms_output.put_line('v_out = '|| :v_out);
                    
                    dbms_output.put_line('---------------------  E N D. -------------------');

                    END;
                ";
        \Log::info($sql);
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
    
        $stmt->bindParam(':v_out', $result['v_out'], PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $result['v_out'];
    }

    public function getConfirmCash()
    {
        $userId = optional(auth()->user())->user_id ?? -1;
        $claimStatus = ClaimStatusV::select('lookup_code', 'meaning', 'description', 'enabled_flag')
                                    ->where('lookup_code', '11')
                                    ->where('enabled_flag', 'Y')
                                    ->first();

        \DB::beginTransaction();
        try {   

            $claimHeaders                       = ClaimHeaders::find(request()->claim_header_id);
            $claimHeaders->status_claim_code    = $claimStatus['lookup_code'];
            $claimHeaders->status_claim         = $claimStatus['meaning'];
            $claimHeaders->last_updated_by      = $userId;
            $claimHeaders->last_update_date     = now();
            
            $claimHeaders->save();
            // SUCCESS CREATE
            \DB::commit();

        } catch (\Exception $e) {
                // ERROR CREATE
                \DB::rollBack();
                if(request()->ajax()){
                        $result['status'] = 'ERROR';
                        $result['err_msg'] = $e->getMessage();
                        return $result;
                }else{
                        \Log::error($e->getMessage());
                        return abort('403');
                }  
        }
        $result = 'success';
        return response()->json(['result' => $result]);
    }
}
