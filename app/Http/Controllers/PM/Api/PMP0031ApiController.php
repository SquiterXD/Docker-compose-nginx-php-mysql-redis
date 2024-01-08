<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PM\PtmpSalesForecast;
use App\Models\Lookup\PtBiweeklyLookup;
use App\Models\PM\Lookup\PtpmItemConvUomV;
use App\Models\PM\PtmpProductPlanHeader;
use App\Models\PM\PtmpProductPlanLine;
use App\Models\PM\Lookup\PtpmItemNumberV;
use App\Models\PM\PtmpMothlySaleForeCast;
use Carbon\Carbon;


use DB;
use PDO;
class PMP0031ApiController extends Controller
{
    public function process()
    {



        $month = request()->pMonth;
        $year   = date('y', strtotime(request()->year));
        // // $x =  $this->openJob(542,400,'PTN',1110);
        $period = $month.'-'.$year;

        $hasPtmpProductPlanHeader =  PtmpProductPlanHeader::where('period', $period)
                                    ->where('biweekly', null)
                                    ->where('organization_id' , auth()->user()->organization_id)

                                    // ->where('year', request()->year)
                                    ->orderBy('plan_header_id', 'desc')
                                    ->first();

        if ($hasPtmpProductPlanHeader) {
            $result = [ 'status' => 'S',
                        'msg'   =>  'Success'
                    ];

            return response()->json([
                'productPlanHeader' => $hasPtmpProductPlanHeader,
                'result'            => $result,
                'productPlanLines'  => $hasPtmpProductPlanHeader->productPlanLines()
                                        ->with('itemNumberV', 'mtlUom')
                                        ->get(),
            ]);
        }


        try {
            $productPlanHeader = new PtmpProductPlanHeader;
            $productPlanHeader->plan_header_id      = PtmpProductPlanHeader::max('plan_header_id') + 1;
            $productPlanHeader->period              = $period;
            $productPlanHeader->department_code     = getDefaultData('/pm/pmp_0031')->department_code;
            // $productPlanHeader->biweekly            = request()->biweekly;
            $productPlanHeader->version             = request()->version;
            $productPlanHeader->creation_date       = now();
            $productPlanHeader->created_by          = 1110;
            $productPlanHeader->created_by_id       = auth()->user()->user_id;
            $productPlanHeader->organization_id     = auth()->user()->organization_id;
            // $productPlanHeader->source_version      = request()->source_version;
            $productPlanHeader->year                = request()->year;
            $productPlanHeader->print_type          = 1;
            $productPlanHeader->status              = 1;
            $productPlanHeader->save();

            $result = [];
            // $result = $this->createLines($productPlanHeader->plan_header_id);
        } catch (\Exception $e) {
            $result = ['status' => 'E',
                        'msg'   =>  $e->getMessage()
                    ];

            return response()->json([
                'result'    => $result,
            ]);
        }

        // $result = $this->createLines($productPlanHeader->plan_header_id);
        // $productPlanHeader =  PtmpProductPlanHeader::find(272)->first();

        $result = $this->createLines($productPlanHeader->plan_header_id);
        return response()->json([
            'productPlanHeader' => $productPlanHeader,
            'result'            => $result,
            'productPlanLines'  => $productPlanHeader->productPlanLines()
                                    ->with('itemNumberV', 'mtlUom')
                                    ->get(),
        ]);
    }

    public function openJob()
    {

        $lines =  request()->lines;
        $lineIds =  collect($lines)->pluck('plan_line_id');

        // $lines[0]['plan_header_id']  = 398;

        $header =  PtmpProductPlanHeader::where('plan_header_id', $lines[0]['plan_header_id'])
                    ->first();

        foreach ($lines as $line) {
            try {
                $productPlanLine =  PtmpProductPlanLine::where('plan_line_id', $line['plan_line_id'])->first();
                $productPlanLine->uom2 = $line['uom2'];
                $productPlanLine->period_name_request = $line['input'];
                $productPlanLine->attribute15 = $line['attribute15'];
                $productPlanLine->save();

            } catch (\Exception $e) {
                $result = ['status' => 'E',

                            'msg'   => $e->getMessage(),
                        ];

                return response()->json([
                    'result'    => $result,
                    'productPlanLines'      => $header->productPlanLines()
                                            ->with('itemNumberV', 'mtlUom')
                                            ->get(),
                ]);
            }

        }
        // dd($lineIds);
        // $lineIds = $header->;
        try {
            $productPlanLines =  PtmpProductPlanLine::whereIn('plan_line_id', $lineIds)->get();
            $date = now();
            foreach ($productPlanLines as $key => $productPlanLine) {
                if($productPlanLine->attribute15 && $productPlanLine->request_number == null) {
                    $this->callPkgUpdateLine($productPlanLine->plan_line_id,$productPlanLine->period_name_request,$productPlanLine->uom2,1110,$date);
                }
            }
        } catch (\Exception $e) {
            $result = ['status' => 'E',
                        'msg'   => $e->getMessage(),
                    ];

            return response()->json([
                'result'                => $result,
                'productPlanLines'      => $header->productPlanLines()
                                            ->with('itemNumberV', 'mtlUom')
                                            ->get(),
            ]);
        }



        $result = ['status' => 'S',
                    'msg'   =>  'Success'
                 ];

        return response()->json([
            'productPlanHeader' => $header,
            'result'            => $result,
            'productPlanLines'  => $header->productPlanLines()
                                    ->with('itemNumberV', 'mtlUom')
                                    ->get(),
        ]);


    }


    public function getSaleForecasts()
    {
        // dd(auth()->user()->organization_id);

        $org    = \DB::connection('oracle')
        ->table('mtl_parameters')
        ->where('organization_code', 'MPG')
        ->first(['organization_id', 'organization_code']);


        $year  = request()->year;
        $month  = request()->month;
        // dd(request()->all());
        $salesForecasts =  PtmpMothlySaleForeCast::where('budget_year', $year)
                ->where('month_no', $month)
                ->whereHas('formulas', function($q) use($org) {
                    $q->where('organization_id', $org->organization_id);
                })
                ->where('mfg_flag', 'Y')
                ->orderBy('month_no')
                ->get();

        // dd($salesForecasts);
        // dd($salesForecasts);
        return response()->json([
            'salesForecasts' => $salesForecasts
        ]);

        // $year  = request()->year;

        // $salesForecasts =  PtmpSalesForecast::where('budget_year', $year)
        //         ->whereHas('formulas', function($q) {
        //             $q->where('organization_id', auth()->user()->organization_id);
        //         })
        //         ->where('mfg_flag', 'Y')
        //         ->get()
        //         ->groupBy('biweekly_no')
        //         ->sortBy('biweekly_no');

        // return response()->json([
        //     'salesForecasts' => $salesForecasts
        // ]);
    }

    public function getSaleForeByMonthCasts()
    {
        $year  = request()->year;
        $year  = request()->month;
        request()->all();
        $salesForecasts =  PtmpMothlySaleForeCast::where('budget_year', $year)
                ->whereHas('formulas', function($q) {
                    $q->where('organization_id', auth()->user()->organization_id);
                })
                ->where('mfg_flag', 'Y')
                ->get()
                ->groupBy('biweekly_no')
                ->sortBy('biweekly_no');

        return response()->json([
            'salesForecasts' => $salesForecasts
        ]);
    }

    public function getBiweeklies()
    {

        $biweekly = PtBiweeklyLookup::where('period_year', request()->year)
                    ->where('biweekly', request()->biweekly_no)
                    ->first();


        return response()->json([
            'biweekly' => $biweekly
        ]);
    }

    public function createLines($plan_header_id)
    {
            $result = [];
            $db     =   DB::connection('oracle')->getPdo();

                $sql    =   "
                declare
                v_status         varchar2(5);
                v_err_msg        varchar2(2000);
                begin

                                PTPM_MICS_PKG.genarate_plan_line_om( p_plan_header_id     =>'$plan_header_id'
                                    ,x_status   => v_status
                                    ,x_message  => v_err_msg);
                                dbms_output.put_line('Status : ' || :v_status);
                                dbms_output.put_line('Error : ' || :v_err_msg);
                end;
                                ";
            $sql = preg_replace("/[\r\n]*/", "", $sql);
            $stmt = $db->prepare($sql);


            // $stmt->bindParam(':lv_data', $result['data'], PDO::PARAM_STR, 4000);
            $stmt->bindParam(':v_status', $result['status'], PDO::PARAM_STR, 10);
            $stmt->bindParam(':v_err_msg', $result['message'], PDO::PARAM_STR, 4000);
            $stmt->execute();
            logger($result);
            return $result;

    }

    public function updateLines()
    {


        // foreach (request()->lines as $line) {
        //     $this->updateLine($line->);
        // }
    }

    public function callPkgUpdateLine($lindId,$periodNameQty,$uom2,$userId,$date)
    {
        $result = [];
        $db     =   DB::connection('oracle')->getPdo();
            $sql    =   "
                DECLARE
                    V_RESULT VARCHAR2 (4000);
                    BEGIN
                            V_RESULT := ptpm_create_report_pkg.REQUEST (
                                P_SOURCE_TABLE => 'PTPM_PRODUCT_PLAN_H',
                                P_SOURCE_ID => '$lindId',
                                P_QTY => '$periodNameQty',
                                P_UOM => '$uom2',
                                P_USER_ID => '$userId',
                                P_DATE => '$date');
                    END;
                            ";
        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $stmt->execute();

        // return $result;

    }

}
