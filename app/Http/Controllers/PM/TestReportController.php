<?php

namespace App\Http\Controllers\PM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PM\PtpmSummaryBatch1V;
use App\Models\PM\PtpmRequestReportV;
use App\Models\PM\PtpmBatchTransactionV;
use App\Models\PM\Settings\OpmRoutingV;

class TestReportController extends Controller
{
    public function report($number)
    {

        $ptpmHead = PtpmRequestReportV::where('request_number',$number)->first();
        $ptpmItems = PtpmRequestReportV::where('request_number',$number)->get();

        return view('pm.confirm-order.report',compact('ptpmHead','ptpmItems'));
    }

    public function report1Pdf($number)
    {

        $userProfile = getDefaultData('/pm/sample-report1-pdf');
 
        $ptpmHead = PtpmRequestReportV::where('request_number',$number)->first();
        $ptpmItems = PtpmRequestReportV::where('request_number',$number)
            // ->orderBy('request_line_id','asc')
            ->orderBy('item_number','asc')
            ->get();
            
        if($ptpmHead ==null){
            $ptpmHead = new PtpmRequestReportV;
        }

        $pdf = \PDF::loadView('pm.confirm-order.report1',compact('ptpmHead','ptpmItems'))
            ->setOption('header-html',view('pm.confirm-order.header-requests',compact('ptpmHead', 'userProfile')))
            ->setOption('footer-html', view('pm.confirm-order.footer-requests'))
            ->setOption('margin-top','40')
            ->setOption('margin-bottom','40')
            ->setOption('encoding','UTF-8')
            ->setOption('lowquality', false)
//            ->setOption('disable-javascript', true)
            ->setOption('disable-smart-shrinking', false)
            ->setOption('print-media-type', true)
           ->setOption('orientation', "Landscape")
            ->setPaper('a4');

        return $pdf->stream();
    }

    public function reportInventory($batchNo,$departmentCode,$txnDate)
    {
        $timeStart = microtime(true);
        $lineFromHeaders     = null;
        $issueHeaderId       = request()->issue_header_id;
        $transactionTypeCode = request()->transaction_type_code;
        $programCode         = request()->program_code;
        $transactionTypeName = $transactionTypeCode;

        $profile =  getDefaultData(\Request::path());

        $issueHeader =  \DB::table('PTPM_MES_REVIEW_ISSUE_HEADERS')
                                ->where('PTPM_MES_REVIEW_ISSUE_HEADERS.issue_header_id', $issueHeaderId)
                                ->first();
        // dd(microtime(true) - $timeStart);
        $programCode = $issueHeader->program_code;
        // $issueHeaderId= 155;

        $requiredQty = 0;
        if ($issueHeader->program_code == 'PMP0007' || $issueHeader->program_code=='PMP0048') {
            if($profile->organization_code == "MP2"){
                $blend =  \DB::table('PTPM_MES_REVIEW_ISSUE_V')
                ->where('batch_id', $issueHeader->batch_id)
                ->where('organization_id', $issueHeader->organization_id)
                ->where('inventory_item_id', $issueHeader->inventory_item_id)
                ->first();

                $requiredQty = \DB::table('PTPM_MES_REVIEW_ISSUE_HEADERS')
                                ->where('PTPM_MES_REVIEW_ISSUE_HEADERS.attribute15' , $issueHeaderId)
                                ->orWhere('PTPM_MES_REVIEW_ISSUE_HEADERS.issue_header_id', $issueHeaderId)
                                ->get()
                                ->sum('opt_plan_qty');
            }else {
                $blend =  \DB::table('PTPM_PMP0007_0048_V')
                    ->where('batch_id', $issueHeader->batch_id)
                    ->where('organization_id', $issueHeader->organization_id)
                    ->where('inventory_item_id', $issueHeader->inventory_item_id)
                    ->first();

                $requiredQty = \DB::table('PTPM_MES_REVIEW_ISSUE_HEADERS')
                    ->where('PTPM_MES_REVIEW_ISSUE_HEADERS.attribute15' , $issueHeaderId)
                    ->orWhere('PTPM_MES_REVIEW_ISSUE_HEADERS.issue_header_id', $issueHeaderId)
                    ->get()
                    ->sum('opt_plan_qty');
            }

            
            // dd($requiredQty);

        } else {
            $blend =  \DB::table('PTPM_MES_REVIEW_ISSUE_V')
                        ->where('batch_id', $issueHeader->batch_id)
                        ->where('organization_id', $issueHeader->organization_id)
                        ->where('inventory_item_id', $issueHeader->inventory_item_id)
                        ->first();
  
        }
                        

        if ($issueHeaderId) {
            $lineFromHeaders =  \DB::table('PTPM_MES_REVIEW_ISSUE_LINES')
                                ->where('PTPM_MES_REVIEW_ISSUE_LINES.issue_header_id', $issueHeaderId)
                                ->get();

        }


        $ptpmHead = PtpmBatchTransactionV::where('ORGANIZATION_CODE',$departmentCode)
            // ->where('batch_status', 'WIP')
            ->where('batch_no' , $batchNo)
            ->whereDate('transaction_date','like',$txnDate.'%')
            ->when($issueHeaderId &&  $issueHeaderId && $transactionTypeName && $lineFromHeaders && $programCode != 'PMP0049', function($q) use ($lineFromHeaders, $transactionTypeName) {
                $q->whereIn('formulaline_id', $lineFromHeaders->pluck('formulaline_id'))
                    ->where('issue_status', $transactionTypeName);
            })
            ->when($issueHeaderId &&  $issueHeaderId && $transactionTypeName && $lineFromHeaders && $programCode == 'PMP0049', function($q) use ($lineFromHeaders, $transactionTypeName){
                $q->whereIn('inventory_item_id', $lineFromHeaders->pluck('inventory_item_id'))
                ->where('issue_status', $transactionTypeName); 
            })
            ->when($programCode == 'PMP0007', function($q){
                $q->where('tobacco_ingrident_type', 'LEAF_FORMULA');
            })
            ->when($issueHeader, function($q) use ($issueHeader) {
                $q->where('request_number', $issueHeader->request_number);
            })
            ->first();
            // dd( $ptpmHead);

        // dd($issueHeaderId &&  $issueHeaderId && $transactionTypeName && $lineFromHeaders && $programCode != 'PMP0049', $lineFromHeaders->pluck('formulaline_id'));
        $ptpmItems = PtpmBatchTransactionV::selectFiled()
            ->where('ORGANIZATION_CODE',$departmentCode)
            // ->where('batch_status', 'WIP')
            ->where('batch_no' , $batchNo)
            // ->where('item_no', '100400043')
            ->whereDate('transaction_date','like',$txnDate.'%')
            ->when($issueHeaderId &&  $issueHeaderId && $transactionTypeName && $lineFromHeaders && $programCode != 'PMP0049', function($q) use ($lineFromHeaders, $transactionTypeName) {
                $q->whereIn('formulaline_id', $lineFromHeaders->pluck('formulaline_id'))
                    ->where('issue_status', $transactionTypeName);
            })
            ->when($issueHeaderId &&  $issueHeaderId && $transactionTypeName && $lineFromHeaders && $programCode == 'PMP0049', function($q) use ($lineFromHeaders, $transactionTypeName){
                $q->whereIn('inventory_item_id', $lineFromHeaders->pluck('inventory_item_id'))
                ->where('issue_status', $transactionTypeName); 
            })
            // ->whereRaw("rownum <= 1")
            ->when($programCode == 'PMP0007', function($q){
                $q->where('tobacco_ingrident_type', 'LEAF_FORMULA');
            })
            ->when($issueHeader, function($q) use ($issueHeader) {
                $q->where('request_number', $issueHeader->request_number);
            })
            ->where('transaction_quantity', '>', 0)
            ->groupByRaw("ORGANIZATION_ID, BATCH_ID, BATCH_NO, TRANSACTION_TYPE_NAME, issue_status, BATCH_STATUS_CODE, BATCH_STATUS, DEPARTMENT_CODE, JOB_TYPE_CODE, JOB_TYPE, WEB_BATCH_STATUS_CODE, WEB_BATCH_STATUS, REQUEST_NUMBER, TOBACCO_INGRIDENT_TYPE, INVENTORY_ITEM_ID, ITEM_NO, ITEM_DESC, BLEND_NO, ORGANIZATION_CODE, SUBINVENTORY_CODE, LOCATOR_ID, LOCATOR_CODE, TRANSACTION_DATE, TRANSACTION_UOM, transaction_quantity, LOT_NUMBER, FORMULALINE_ID, MATERIAL_DETAIL_ID, onhand, REQUIRE_QTY, leaf_formula, uom_name, REF_ISSUE_LINE_ID, casting_flavor_name")
            ->orderBy('item_no')
            ->get();

            // dd($ptpmItems->pluck('request_number'), $issueHeader);
            if($programCode == 'PMP0007'){
                $ptpmItems->sortBy('leaf_formula');
                $ptpmItems->map(function($q) use ($issueHeader) {
                    $q->seq = $q->leaf_formula.'_'.$q->item_no;
                });
            }
            // dd($ptpmItems);
            if ($programCode == 'PMP0048') {   
                $ptpmItems->map(function($q) use ($issueHeader) {
                    $formula =  \DB::table('ptct_mfg_formula_v')
                    // ->where('batch_id', $issueHeader->batch_id)
                    ->where('organization_id', $issueHeader->organization_id)
                    ->where('formulaline_id', $q->formulaline_id)
                    ->first(['organization_id','formulaline_id' , 'tobacco_ingrident_type', 'casting_flavor_name', 'item_number', 'used_leaf_formula']); 

                    if ($formula) {
                        if($formula->tobacco_ingrident_type == 'CASING'){
                            if(strlen(preg_replace('/[^0-9.]+/', '',$formula->casting_flavor_name)) == 2){
                                $castingFlavorName =  preg_replace('/[^0-9.]+/', '',$formula->casting_flavor_name);
                            }else {
                                $castingFlavorName =  sprintf("%02d", preg_replace('/[^0-9.]+/', '',$formula->casting_flavor_name));
                            }
                            $q->seq = $formula->used_leaf_formula.'_'.$castingFlavorName.'_'.$formula->item_number.'_'.$formula->formulaline_id;     
                        }

                        if($formula->tobacco_ingrident_type == 'FLAVOR'){
                            $q->seq = $formula->casting_flavor_name.'_'.$formula->item_number.'_'.$formula->formulaline_id;
                        }
                    } else {
                        if($q->tobacco_ingrident_type == 'CASING'){
                            if(strlen(preg_replace('/[^0-9.]+/', '',$q->casting_flavor_name)) == 2){
                                $castingFlavorName =  preg_replace('/[^0-9.]+/', '',$q->casting_flavor_name);
                            }else {
                                $castingFlavorName =  sprintf("%02d", preg_replace('/[^0-9.]+/', '',$q->casting_flavor_name));
                            }
                            $q->seq = $q->leaf_formula.'_'.$castingFlavorName.'_'.$q->item_number.'_'.$q->formulaline_id;     
                        }

                        if($q->tobacco_ingrident_type == 'FLAVOR'){
                            $q->seq = $q->casting_flavor_name.'_'.$q->item_number.'_'.$q->formulaline_id;
                        }
                    }

                });
            }


        if($programCode == 'PMP0049' || $programCode == 'PMP0051' ||  $programCode == 'PMP0059'){
            $ptpmItems->map(function($q) {
                $q->seq = $q->item_no;
            });

            $requiredQty = $issueHeader->opt_plan_qty ?? 0;
            $programCode = 'PDR0880';
        }

        $departmentdesc = '';
        $org = \App\Models\MtlParameter::where('organization_id', $profile->organization_id)->first();
        // dd('xx', $ptpmHead->issueStatus);
        if ($org) {
            $dept = \App\Models\PtglCoaDeptCodeAllV::where('department_code', $org->attribute11)->first();
            if ($dept) {
                $departmentdesc = $dept->description;
            }
        }
        $routing = OpmRoutingV::where('owner_organization_id', $profile->organization_id)->where('oprn_no', $ptpmHead->oprn_no)->first();
        $batch  = \App\Models\PM\PtpmSummaryBatchV::selectRaw("item_no, item_desc")
                    ->where('organization_id', $profile->organization_id)
                    ->where('batch_id', $ptpmHead->batch_id)
                    ->first();
        $headerStatus = $ptpmHead->issueStatus;
        $reportInfo = (object) [
            'department_desc'   => $departmentdesc,
            'routing_desc'      => $routing ? "$routing->oprn_class_desc $routing->oprn_desc" : '',
            'status_desc'       => $headerStatus ? $headerStatus->description : '',
            'product_desc'      => $batch ? "$batch->item_no: $batch->item_desc" : '',
        ];

        $lines = $lineFromHeaders;
        $pdf = \PDF::loadView('pm.confirm-order.report-inventory',compact('reportInfo', 'ptpmHead','ptpmItems', 'issueHeader', 'profile', 'blend', 'lines', 'requiredQty' , 'programCode'))
            ->setOption('header-html',view('pm.confirm-order.report-inventory-header',compact('reportInfo', 'ptpmHead', 'issueHeader', 'profile', 'blend', 'requiredQty' , 'programCode')))
            ->setOption('margin-top','40')
            ->setOption('lowquality', false)
            ->setOption('disable-javascript', false)
            ->setOption('disable-smart-shrinking', false)
            ->setOption('print-media-type', true)
            ->setOption('orientation', "Landscape")
            ->setPaper('a4');

        return $pdf->stream();
    }

    public function reportMasterList($departmentCode,$startDate,$endDate)
    {
        $user = auth()->user();
        $startDateSt = $this->getThaiString($startDate);
        $endDateSt = $this->getThaiString($endDate);
    //    dd($startDate,$endDate);
        $ptpmHead = PtpmSummaryBatch1V::where('department_code',$departmentCode)
                    // ->where('batch_status', 'WIP')
                    ->first();

        $ptpmItems = PtpmSummaryBatch1V::where('department_code',$departmentCode)
            ->whereRaw("TRUNC(plan_start_date) BETWEEN  to_date('".$startDate."', 'YYYY-MM-DD')  AND to_date('".$endDate."', 'YYYY-MM-DD')")
            // ->whereBetween('creation_date',[$startDate,$endDate])
            // ->where('batch_status', 'WIP')
            ->orderBy('batch_no','asc')
            ->orderBy('creation_date','desc')
            ->get();

        // dd( $ptpmItems);
        $pdf = \PDF::loadView('pm.confirm-order.report-summary',compact('ptpmHead','ptpmItems'))
            ->setOption('header-html',view('pm.confirm-order.header-summary',compact('ptpmHead','startDateSt','endDateSt', 'user')))
            ->setOption('margin-top','40')
            ->setOption('orientation', "Landscape")
            ->setPaper('a4');

        return $pdf->stream();

    }

    private function getThaiString($date)
    {
        $monthTH = array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
            "กรกฏาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");

        $stringDate = explode('-',$date);
        $stDay = (int)$stringDate[2];
        $stMonth = $monthTH[(int)$stringDate[1]-1];
        $stYear = (int)$stringDate[0]+543;

        $result = $stDay . ' ' . $stMonth . ' ' .$stYear;

        return $result;
    }

    public function reportVue()
    {

        $ptpmHead = PtpmRequestReportV::where('request_number','64-6B16-0053')->first();
        $ptpmItems = PtpmRequestReportV::where('request_number','64-6B16-0053')->get();

        return view('pm.confirm-order.reportVue',compact('ptpmHead','ptpmItems'));
    }

    public function testPdf()
    {

        $pdf = \PDF::loadHTML('<h1>Test</h1>');
        return $pdf->stream();


    }

    public function report2()
    {

        // $ptpmHead = PtpmRequestReportV::where('request_number','64-6B16-0053')->first();
        $ptpmItems = PtpmRequestReportV::all();

        $url = (object)[];
        $url->ajax_get_item = route('pm.ajax.sample-report2.get-items');

        return view('pm',compact('url','ptpmItems'));
    }
}
