<?php

namespace App\Http\Controllers\OM\Ajax;

use App\Http\Controllers\Controller;

use App\Models\OM\ConsignmentHeaders;
use App\Models\OM\TaxAdjustmentsBKK;
use App\Models\OM\TaxadjustBkkV;

class TaxAdjustmentsBKKController extends Controller
{
    public function getSearch()
    {
        $start_date = parseFromDateTh(request()->fromDate);
        $end_date = parseFromDateTh(request()->toDate);
        $decimals = 2;
        $decimalpoint = '.';
        $separator = ',';
        // $consignmentHeaders = ConsignmentHeaders::whereBetween('consignment_date', [$start_date,$end_date])
        //                                         ->get()
        //                                         ->groupBy(function($item){
        //                                             return parseToDateTh($item->consignment_date);
        //                                         });
        $consignmentHeaders = TaxadjustBkkV::whereBetween('consignment_date', [$start_date,$end_date])
                                                ->where('consignment_status','Confirm')
                                                ->orderBy('consignment_date', 'asc')
                                                ->get();
        $consignmentHeaders->map(function ($item, $key) use($decimals, $decimalpoint, $separator){
            $item->consignment_date_th = parseToDateTh($item->consignment_date);
            $item->total_amount_decimal_point = number_format($item->total_amount,$decimals,$decimalpoint,$separator);
            $item->vat_amount_decimal_point = number_format($item->vat_amount,$decimals,$decimalpoint,$separator);
            $item->checked = TaxAdjustmentsBKK::where('tax_adjustment_no', $item->consignment_no)->value('post_flag') == 'Y' ? true : false;
            $item->use_tax_adjustments = TaxAdjustmentsBKK::where('tax_adjustment_no', $item->consignment_no)->first();
            $item->tax_adjust_amount = $item->vat_amount ? $item->vat_amount : '';
        });
                                        
        return response()->json(['consignmentHeaders' => $consignmentHeaders]);
    }

    public function store()
    {
        $listFix = "ยอดจำหน่ายบุหรี่ ยาเส้น-สโมสร กทม.";
        $program_code = 'OMP0099';
        $userId = optional(auth()->user())->user_id ?? -1;
        \DB::beginTransaction();
        try {   
                foreach (request()['lineList'] as $key => $value) {
                    if(!$value['use_tax_adjustments']){
                        $taxAdjustments                             = new TaxAdjustmentsBKK();
                        $taxAdjustments->tax_adjustment_no          = $value['consignment_no'];
                        $taxAdjustments->tax_adjustment_date        = date('Y-m-d', strtotime($value['consignment_date']));
                        $taxAdjustments->tax_adjustment_list        = $listFix;
                        $taxAdjustments->total_amount               = $value['total_amount'];
                        $taxAdjustments->vat_amount                 = $value['vat_amount'];
                        $taxAdjustments->tax_adjust_amount          = $value['tax_adjust_amount'];
                        $taxAdjustments->post_flag                  = $value['checked'] == 'true' ? 'Y' : 'N';
                        $taxAdjustments->program_code               = $program_code;
                        $taxAdjustments->created_by                 = $userId;                        
                        $taxAdjustments->creation_date              = now();
                        $taxAdjustments->last_updated_by            = $userId;
                        $taxAdjustments->last_update_date           = now();
                        $taxAdjustments->save();  
                    }
                }
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
