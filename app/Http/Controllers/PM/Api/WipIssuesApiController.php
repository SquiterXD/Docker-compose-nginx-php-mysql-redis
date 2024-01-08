<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PM\PtmpMesReviewIssueV;
use App\Models\PM\PtmpIssueStatus;
use App\Models\PM\PtpmListOprnByItemsV;
// use App\Models\PM\PtctMfgFormulaV;
use App\Models\PM\PtpmMesReviewIssueHeaders;
use App\Models\PM\PtpmMesReviewIssueLines;
use App\Models\Lookup\PtpmJobTypeLookup;
use App\Repositories\PM\WipIssueRequestRepository;
use App\Models\PM\Lookup\PtinvOnhandQuantitiesV;
use App\Models\PM\PtpmSetupMfgDepartmentsV;
use Carbon\Carbon;
use App\Models\PM\PtpmManufactureStep;
use App\Models\PM\Lookup\PtpmItemConvUomV;
use App\Models\PM\MtlSystemItemB;
use App\Models\PM\OapmPtmesProductLine;
use App\Models\PM\PtmpProductBatchV;
use App\Models\PM\PtBiweeklyV;
use App\Repositories\PM\CommonRepository;
use App\Models\PM\PtpmSummaryBatch1V;
use App\Models\PM\PtctMfgFormulaV;
use App\Models\PM\PtpmMfgFormulaV;
use App\Models\PM\Settings\OpmRoutingV;

use App\Models\PM\PtmpPmp00070And048V;


use DB;

class WipIssuesApiController extends Controller
{

    public function getHeaders()
    {

        $programCode =  request()->program_code;

        if ($programCode == 'PMP0049' || $programCode == 'PMP0051' || $programCode == 'PMP0059') {
            $mesReviewIssueHeaders = PtpmMesReviewIssueHeaders::where('organization_id', auth()->user()->organization_id)
                ->has('mesReviewIssueView')
                ->where('program_code', $programCode)
                ->where('attribute15', null)
                ->orderBy('issue_date', 'desc')
                ->limit(5)
                ->get();

            $headers = (new WipIssueRequestRepository)->setHeader($mesReviewIssueHeaders);

            return response()->json([
                'mesReviewIssueHeaders' => $headers
            ]);
        }

        $mesReviewIssueHeaders = PtpmMesReviewIssueHeaders::where('organization_id', auth()->user()->organization_id)
            ->has('mesReviewIssueView')
            ->where('ingridient_group_code', request()->item_classification_code)
            ->where('attribute15', null)
            ->orderBy('complete_date', 'desc')
            ->limit(5)
            ->get();
        // dd($mesReviewIssueHeaders);
        $headers = (new WipIssueRequestRepository)->setHeader($mesReviewIssueHeaders);

        return response()->json([
            'mesReviewIssueHeaders' => $headers,
        ]);
    }

    public function getMesReviewIssuesV()
    {
        $casePmp0007 = request()->program_code == 'PMP0007' ? true : false;
        $casePmp0048 = request()->program_code == 'PMP0048' ? true : false;
        $casePmp0049 = request()->program_code == 'PMP0049' ? true : false;
        $casePmp0051 = request()->program_code == 'PMP0051' ? true : false;
        $casePmp0059 = request()->program_code == 'PMP0059' ? true : false;

        $wipStepList = [];
        $findWipStepList = $this->getWipStepListForIssue();
        if (count($findWipStepList)) {
            $wipStepList = $findWipStepList->pluck('oprn_class_desc', 'oprn_class_desc')->all();
        }
        // dd($casePmp0007,
        // $casePmp0048,
        // $casePmp0049,
        // $casePmp0051);

        $start = microtime(true);

        $profile =  getDefaultData(\Request::path());
        $classificationCode = request()->classification_code;
        $header = null;
        // dd(request()->set_header != "true");
        if (request()->set_header != "true") {
            $formYear = Carbon::createFromFormat('d/m/Y', request()->date)->format('Y');
            $formDate = Carbon::createFromFormat('d/m/Y', request()->date)->format('d-m');

            $year = (int) $formYear - 543;
            $date = (string) $formDate . "-" . $year;
            $date = date('Y/m/d', strtotime($date));
        } else {

            $formYear = Carbon::createFromFormat('d/m/Y', request()->date)->format('Y');
            $formDate = Carbon::createFromFormat('d/m/Y', request()->date)->format('d-m');

            $year = (int) $formYear - 543;
            $date = (string) $formDate . "-" . $year;
            $date = date('Y/m/d', strtotime($date));
            if (request()->program_code == 'PMP0051' || request()->program_code == 'PMP0049' || request()->program_code == 'PMP0059') {
                $date = Carbon::createFromFormat('d/m/Y', request()->date)->format('Y/m/d');
            }

            if (request()->issue_header_id && request()->issue_header_id!='undefined') {
                $header = PtpmMesReviewIssueHeaders::where('issue_header_id', request()->issue_header_id)->first();
            }
        }

        if ($casePmp0007 || $casePmp0048) {
            if ($profile->organization_code  == 'MP2') {
                $mesReviewIssueV =  PtmpMesReviewIssueV::where('organization_id', auth()->user()->organization_id)
                                    ->whereDate('transaction_date', $date)
                                    ->whereIn('wip_step', $wipStepList)
                                    ->whereRaw("nvl(transaction_quantity, 0) > 0 ")
                                    ->getBlend($profile, request()->program_code)
                                    ->with(['uom'])
                                    ->get();
            }else{
                $mesReviewIssueV =  PtmpPmp00070And048V::where('organization_id', auth()->user()->organization_id)
                ->whereIn('wip_step', $wipStepList)
                ->whereDate('transaction_date', $date)
                ->getBlend($profile, request()->program_code)
                ->when($classificationCode == 01, function ($q) {
                    $q->where('issue_item_class_01_flag', null);
                })
                ->when($classificationCode == 02, function ($q) {
                    $q->where('issue_item_class_02_flag', null);
                })
                ->when($header && ($header->issue_status == '2' || $header->issue_status == '3') , function($q) use ($header){
                    $q->orWhere('batch_id' , $header->batch_id); 
                })  
                ->with('mtlSystemItemB', function ($q) {
                    $q->selectRaw('attribute2  , segment1 , organization_id');
                })
                ->get(['batch_no',  'job_type_code', 'blend_no', 'item_number', 'batch_id', 'inventory_item_id', 'transaction_date']);
            }



            // dd($mesReviewIssueV->pluck('issue_item_class_01_flag'));
        }

        if ($casePmp0049) {
            $mesReviewIssueV =  PtmpMesReviewIssueV::where('organization_id', auth()->user()->organization_id)
                ->whereIn('wip_step', $wipStepList)
                ->whereDate('transaction_date', $date)
                ->whereRaw("nvl(transaction_quantity, 0) > 0 ")
                ->getBlend($profile, request()->program_code)
                // ->when($classificationCode == 01, function($q) {
                //     $q->where('issue_item_class_01_flag', null);
                // })
                // ->when($classificationCode == 02, function($q) {
                //     $q->where('issue_item_class_02_flag', null);
                // })
                ->with(['uom'])
                ->get();
        }
        if ($casePmp0051) {
            // dd('xxxxxxxxxxxxxxx');
            $mesReviewIssueV =  PtmpMesReviewIssueV::where('organization_id', auth()->user()->organization_id)
                ->whereIn('wip_step', $wipStepList)
                ->whereDate('transaction_date', $date)
                ->whereRaw("nvl(transaction_quantity, 0) > 0 ")
                ->getBlend($profile, request()->program_code)
                // ->when($classificationCode == 01, function($q) {
                //     $q->where('issue_item_class_01_flag', null);
                // })
                // ->when($classificationCode == 02, function($q) {
                //     $q->where('issue_item_class_02_flag', null);
                // })
                ->with(['uom'])
                ->get();
                // dd( $mesReviewIssueV->toArray());
        }

        if ($casePmp0059) {
            $mesReviewIssueV =  PtmpMesReviewIssueV::where('organization_id', auth()->user()->organization_id)
                ->whereIn('wip_step', $wipStepList)
                ->whereDate('transaction_date', $date)
                ->whereRaw("nvl(transaction_quantity, 0) > 0 ")
                ->getBlend($profile, request()->program_code)
                ->hasStampItem()
                ->with(['uom'])
                ->get();
        }


        // $mesReviewIssueV =  PtmpMesReviewIssueV::where('organization_id', auth()->user()->organization_id)
        //                     ->whereDate('transaction_date',$date)
        //                     ->getBlend($profile, request()->program_code)
        //                     ->when($classificationCode == 01, function($q) {
        //                         $q->where('issue_item_class_01_flag', null);
        //                     })
        //                     ->when($classificationCode == 02, function($q) {
        //                         $q->where('issue_item_class_02_flag', null);
        //                     })
        //                     ->with(['uom'])
        //                     ->get();
        // dd($mesReviewIssueV);

        $data = [
            'status' => 'S',
            'msg' => 'Success'
        ];

        // check period 

        if (count($mesReviewIssueV) == 0) {
            $data = [
                'status' => 'E',
                'msg' => 'ไม่มีผลผลิตในวันที่เลือกตัดใช้ !'
            ];
            return response()->json([
                'result'   => $data
            ]);
        }

        $jopType = PtpmJobTypeLookup::where('lookup_code',  (int)$mesReviewIssueV->first()->job_type_code)
            ->first();

        // $blends = $mesReviewIssueV->unique('blend_no');
        $blends =   $mesReviewIssueV->unique(function ($item) {
            return $item->blend_no . $item->batch_no;
        });



        $blends = $blends->mapWithKeys(function($item) {
            return [$item->blend_no . $item->batch_no => $item];
        });
        // dd($blends);
        if ($casePmp0049 || $casePmp0051 || $casePmp0059) {
            $blends = $mesReviewIssueV->unique('batch_no');
        }

        if ($profile->organization_code  == 'M03') {
            $blends = $mesReviewIssueV->unique('item_number');
        }

        if ($profile->organization_code  == 'MP2') {
            $blends =   $mesReviewIssueV->unique(function ($item) {
                return $item->blend_no . $item->batch_no;
            });
        }
// dd('xxx');
        foreach ($blends as $key => $blend) {
            $freezeBatch = (new \App\Repositories\PM\CommonRepository)->freezeBatchStatus($blend->batch_no);
            $blend->is_freeze_flag = $freezeBatch->is_freeze_flag;
            $blend->freeze_msg = $freezeBatch->freeze_msg;
            $blend->freeze_flag_date = $freezeBatch->freeze_flag_date;
        }

        // ================ TEST FREEZE ========================
        // if(getDefaultData('/pm/wip-issue')->organization_code == 'M02'){
        //     $blend->is_freeze_flag = "";
        //     $blend->freeze_msg ="";
        //     $blend->freeze_flag_date = "";
        // }
        // dd($blends->pluck('freeze_flag_date','batch_no'));
        // dd($blends->pluck('freeze_flag_date', 'transaction_date'));
        // dd($blends, $date);
        // if($profile->organization_code  == 'M02'){
        //     $blends->mapWithKeys(function ($item, $key) {
        //         return [$item => $item['name']];
        //     });
        // }
        // dd('xxx');
        // dd($mesReviewIssueV);
        // dd(microtime(true) - $start , $mesReviewIssueV);

        // dd($blends, $mesReviewIssueV);
        return response()->json([
            'result'            => $data,
            'mesReviewIssueV'   => $mesReviewIssueV,
            'blends'            => $blends,
            'jobType'           => $jopType,
            // 'opts'   =>  $mesReviewIssueV->unique('opt'),
        ]);
    }

    public function getOptsFromBlends()
    {
        $casePmp0007 = request()->program_code == 'PMP0007' ? true : false;
        $casePmp0048 = request()->program_code == 'PMP0048' ? true : false;
        $casePmp0049 = request()->program_code == 'PMP0049' ? true : false;
        $casePmp0051 = request()->program_code == 'PMP0051' ? true : false;
        $casePmp0059 = request()->program_code == 'PMP0059' ? true : false;
        $start = microtime(true);

        $wipStepList = [];
        $findWipStepList = $this->getWipStepListForIssue();
        if (count($findWipStepList)) {
            $wipStepList = $findWipStepList->pluck('oprn_class_desc', 'oprn_class_desc')->all();
        }

        // dd('xxx');
        // dd($casePmp0007,
        // $casePmp0048,
        //  $casePmp0049,
        // $casePmp0051 , request()->all());
        // dd('xxx');
        $profile =  getDefaultData(\Request::path());
        $blendNo =  request()->blend_no;
        $batchNo =  request()->batch_no;

        if ($profile->organization_code == "MP2") {
            $batchNo =  request()->blend_no;
        }


        $classificationCode = request()->classification_code;

        $formYear = Carbon::createFromFormat('d/m/Y', request()->date)->format('Y');
        $formDate = Carbon::createFromFormat('d/m/Y', request()->date)->format('d-m');

        $year = (int) $formYear - 543;
        $date = (string) $formDate . "-" . $year;
        $date = date('Y/m/d', strtotime($date));

        $blend =    PtmpMesReviewIssueV::where('batch_no', $batchNo)
            ->with(['uom'])
            ->first();
        // dd( $blend );
        $productByBlend = PtctMfgFormulaV::where('product_blend_no', $blend ? $blend->blend_no : $blendNo)
            ->where('organization_id', auth()->user()->organization_id)
            ->isApproved()
            ->first();

        if ($casePmp0007 || $casePmp0048) {
            if ($profile->organization_code  == 'M03') {
                $blend =    PtmpPmp00070And048V::where('item_number', $blendNo)
                    ->orWhere('blend_no', $blendNo)
                    ->when($profile->organization_code  == 'M03', function ($q) {
                        // $q->whereIn('wip_step', ['WIP02', 'WIP03'])
                        $q->where('wip_status', 2)
                            ->where('mes_job_status', "Y");
                    })
                    ->whereIn('wip_step', $wipStepList)
                    ->with(['uom'])
                    ->first();
                // dd($blend);
                $productByBlend = PtctMfgFormulaV::where('organization_id', auth()->user()->organization_id)
                    ->isApproved()
                    ->where('product_item_id', $blend->inventory_item_id)
                    ->first();

                $productByBlend = null;
                $opts = [];
                if ($blend) {
                    $productByBlend = PtctMfgFormulaV::where('organization_id', auth()->user()->organization_id)
                        ->isApproved()
                        ->where('product_item_id', $blend->inventory_item_id)
                        ->first();

                    $opts =  PtmpPmp00070And048V::where('organization_id', auth()->user()->organization_id)
                        ->where('item_number', $blend->item_number)
                        ->whereDate('transaction_date', $date)
                        ->when($profile->organization_code  == 'M03', function ($q) {
                            $q->where('wip_status', 2)
                                ->where('mes_job_status', "Y");
                        })
                        ->whereIn('wip_step', $wipStepList)
                        ->with(['uom'])
                        // ->with('formulaByInvItem')
                        ->get();
                }

            } elseif($profile->organization_code  == 'MP2'){
                $blend =    PtmpMesReviewIssueV::where('batch_id', $batchNo)
                        ->where('organization_id', auth()->user()->organization_id)
                        ->whereIn('wip_step', $wipStepList)
                        ->whereDate('transaction_date', $date)
                        ->with(['uom'])
                        ->first();
                $productByBlend = PtctMfgFormulaV::where('organization_id', auth()->user()->organization_id)
                    ->isApproved()
                    ->where('product_item_id', $blend->inventory_item_id)
                    ->first();

                $opts =  PtmpMesReviewIssueV::where('batch_id', $batchNo)
                    ->whereIn('wip_step', $wipStepList)
                    ->where('organization_id', auth()->user()->organization_id)
                    ->whereDate('transaction_date', $date)
                    ->get();

            } else {

                $blend =    PtmpPmp00070And048V::where('batch_id', $blendNo)
                                ->whereIn('wip_step', $wipStepList)
                                ->with(['uom'])
                                ->first();
                // dd($blend , 'xxxx' , $batchNo);
                $productByBlend = PtctMfgFormulaV::where('product_blend_no', $blend ? $blend->blend_no : $blendNo)
                                                    ->isApproved()
                                                    ->where('organization_id', auth()->user()->organization_id)
                                                    ->first();
                // dd($blendNo);
                $opts =  PtmpPmp00070And048V::when($batchNo, function ($q) use ($batchNo) {
                    $q->where('batch_no', $batchNo);
                })
                    ->whereIn('wip_step', $wipStepList)
                    ->when(!$batchNo, function ($q) use ($blendNo) {
                        $q->where('batch_id', $blendNo);
                    })
                    ->where('organization_id', auth()->user()->organization_id)
                    ->whereDate('transaction_date', $date)
                    ->when($classificationCode == 01, function ($q) {
                        $q->where('issue_item_class_01_flag', null);
                    })
                    ->when($classificationCode == 02, function ($q) {
                        $q->where('issue_item_class_02_flag', null);
                    })
                    ->when($profile->organization_code  == 'M02', function ($q) {
                        // $q->where('wip_step', 'WIP01')
                        $q
                            ->where('wip_status', 2)
                            ->where('mes_job_status', "Y");
                    })
                    // ->when($profile->organization_code  == 'M03', function($q) {
                    //     $q->whereIn('wip_step', ['WIP02', 'WIP03'])
                    //     ->where('wip_status', 2)
                    //     ->where('mes_job_status', "Y");
                    // })
                    // ->with('formulaByInvItem')
                    ->get(['transaction_quantity', 'opt', 'inventory_item_id']);

                // dd(microtime(true) - $start , $opts);
                // dd($opts);
            }
        }

        if ($casePmp0049) {
            // dd($casePmp0049);
            $opts =  PtmpMesReviewIssueV::when($batchNo, function ($q) use ($batchNo) {
                $q->where('batch_no', $batchNo);
            })
                ->whereIn('wip_step', $wipStepList)
                ->when(!$batchNo, function ($q) use ($blendNo) {
                    $q->where('blend_no', $blendNo);
                })
                ->where('organization_id', auth()->user()->organization_id)
                ->whereDate('transaction_date', $date)
                // ->when($classificationCode == 01, function($q) {
                //     $q->where('issue_item_class_01_flag', null);
                // })
                // ->when($classificationCode == 02, function($q) {
                //     $q->where('issue_item_class_02_flag', null);
                // })
                // ->when($profile->organization_code  == 'M02', function($q) {
                //     $q->where('wip_step', 'WIP01')
                //     ->where('wip_status', 2)
                //     ->where('mes_job_status', "Y");
                // })
                // ->when($profile->organization_code  == 'M03', function($q) {
                //     $q->whereIn('wip_step', ['WIP02', 'WIP03'])
                //     ->where('wip_status', 2)
                //     ->where('mes_job_status', "Y");
                // })
                ->with('formulaByInvItem')
                ->get();
                // dd( $opts );
        }

        if ($casePmp0051) {
            // dd($casePmp0051);
            $opts =  PtmpMesReviewIssueV::when($batchNo, function ($q) use ($batchNo) {
                $q->where('batch_no', $batchNo);
            })
                ->whereIn('wip_step', $wipStepList)
                ->when(!$batchNo, function ($q) use ($blendNo) {
                    $q->where('blend_no', $blendNo);
                })
                ->where('organization_id', auth()->user()->organization_id)
                ->whereDate('transaction_date', $date)
                // ->when($classificationCode == 01, function($q) {
                //     $q->where('issue_item_class_01_flag', null);
                // })
                // ->when($classificationCode == 02, function($q) {
                //     $q->where('issue_item_class_02_flag', null);
                // })
                // ->when($profile->organization_code  == 'M02', function($q) {
                //     $q->where('wip_step', 'WIP01')
                //     ->where('wip_status', 2)
                //     ->where('mes_job_status', "Y");
                // })
                // ->when($profile->organization_code  == 'M03', function($q) {
                //     $q->whereIn('wip_step', ['WIP02', 'WIP03'])
                //     ->where('wip_status', 2)
                //     ->where('mes_job_status', "Y");
                // })
                ->with('formulaByInvItem')
                ->get();
        }

        if ($casePmp0059) {
            // dd($casePmp0059);
            $opts =  PtmpMesReviewIssueV::when($batchNo, function ($q) use ($batchNo) {
                $q->where('batch_no', $batchNo);
            })
                ->whereIn('wip_step', $wipStepList)
                ->when(!$batchNo, function ($q) use ($blendNo) {
                    $q->where('blend_no', $blendNo);
                })
                // ->whereIn('wip_step', $wipStepList)
                ->where('organization_id', auth()->user()->organization_id)
                ->whereDate('transaction_date', $date)
                // ->when($classificationCode == 01, function($q) {
                //     $q->where('issue_item_class_01_flag', null);
                // })
                // ->when($classificationCode == 02, function($q) {
                //     $q->where('issue_item_class_02_flag', null);
                // })
                // ->when($profile->organization_code  == 'M02', function($q) {
                //     $q->where('wip_step', 'WIP01')
                //     ->where('wip_status', 2)
                //     ->where('mes_job_status', "Y");
                // })
                // ->when($profile->organization_code  == 'M03', function($q) {
                //     $q->whereIn('wip_step', ['WIP02', 'WIP03'])
                //     ->where('wip_status', 2)
                //     ->where('mes_job_status', "Y");
                // })
                ->hasStampItem()
                ->with('formulaByInvItem')
                ->get();
                // dd( $opts );
        }






        if ($batchNo && $profile->organization_code != 'MP2') {
            $productByBlend = MtlSystemItemB::where('segment1', $blend->item_number)
                ->first(['segment1', 'description']);
        }

        return response()->json([
            'opts' => $opts,
            'productByBlend' => $productByBlend,
            // 'groupByOpts' => $opts->groupBy('opt'),
            'groupByOpts' => count($opts) ? $opts->groupBy('opt') : $opts,
        ]);
    }

    public function getIssuesStatus()
    {
        $issueStatuses =  PtmpIssueStatus::get()->take(5);

        return response()->json([
            'issueStatuses' => $issueStatuses,
        ]);
    }

    public function getOprnByItem()
    {


        $casePmp0007 = request()->program_code == 'PMP0007' ? true : false;
        $casePmp0048 = request()->program_code == 'PMP0048' ? true : false;
        $casePmp0049 = request()->program_code == 'PMP0049' ? true : false;
        $casePmp0051 = request()->program_code == 'PMP0051' ? true : false;
        $casePmp0059 = request()->program_code == 'PMP0059' ? true : false;

        $productBatchV = null;
        $productBatchVs = [];
        // dd('xxx');
        $profile =  getDefaultData(\Request::path());
        $programCode = request()->program_code;
        if ($casePmp0007 || $casePmp0048) {
            $listOprnByItems =  PtpmListOprnByItemsV::where('product_item_id', request()->item_id)
                ->where('organization_id', auth()->user()->organization_id)
                ->orderBy('oprn_no')
                ->get();
        }

        if ($casePmp0049) {

            $formYear = Carbon::createFromFormat('d/m/Y', request()->tran_date)->format('Y');
            $formDate = Carbon::createFromFormat('d/m/Y', request()->tran_date)->format('d-m');

            $year = (int) $formYear - 543;
            $date = (string) $formDate . "-" . $year;
            $date = date('Y/m/d', strtotime($date));

            if (request()->set_header == 'true') {
                $date = Carbon::createFromFormat('d/m/Y', request()->tran_date)->format('Y/m/d');
            }

            if (request()->batch_no) {
                $issueV =    PtmpMesReviewIssueV::where('batch_no', request()->batch_no)
                    ->where('organization_id', auth()->user()->organization_id)
                    ->whereDate('transaction_date',  $date)
                    ->when($profile->organization_code  == 'M03', function ($q) {
                        $q->whereIn('wip_step', ['WIP02', 'WIP03'])
                            ->where('wip_status', 2)
                            ->where('mes_job_status', "Y");
                    })
                    ->with(['uom'])
                    ->get();
            } else {
                $issueV =    PtmpMesReviewIssueV::where('inventory_item_id', request()->item_id)
                    ->where('organization_id', auth()->user()->organization_id)
                    ->whereDate('transaction_date',  $date)
                    ->when($profile->organization_code  == 'M03', function ($q) {
                        $q->whereIn('wip_step', ['WIP02', 'WIP03'])
                            ->where('wip_status', 2)
                            ->where('mes_job_status', "Y");
                    })
                    ->with(['uom'])
                    ->get();
            }

            $listOprnByItems =  PtpmManufactureStep::selectRaw('DISTINCT wip_step,
            wip_step_desc,
            owner_organization')
                ->whereIn('wip_step', $issueV->pluck('wip_step'))
                ->where('owner_organization', getDefaultData('/pm/wip-issue')->organization_code)
                ->orderBy('wip_step')
                ->get();
                // dd( $listOprnByItems);

            // dd($listOprnByItems);
            return response()->json([
                'listOprnByItems' => $listOprnByItems,
                'defaultOprn'   => $listOprnByItems->first(),

            ]);
        }

        if ($casePmp0051) {

            $formYear = Carbon::createFromFormat('d/m/Y', request()->tran_date)->format('Y');
            $formDate = Carbon::createFromFormat('d/m/Y', request()->tran_date)->format('d-m');

            $year = (int) $formYear - 543;
            $date = (string) $formDate . "-" . $year;
            $date = date('Y/m/d', strtotime($date));
            $dateEn = $date;

            if (request()->set_header == 'true') {
                $date = Carbon::createFromFormat('d/m/Y', request()->tran_date)->format('Y/m/d');
            }


            $issueV =    PtmpMesReviewIssueV::where('batch_no', request()->batch_no)
                ->where('organization_id', auth()->user()->organization_id)
                ->whereDate('transaction_date',  $dateEn)
                ->with(['uom'])
                ->orderBy('wip_step')
                ->first();


            $listOprnByItems = PtmpProductBatchV::where('organization_id', auth()->user()->organization_id)
                // ->where('wip_step', $issueV->wip_step)
                ->where('batch_no', $issueV->batch_no)
                ->whereDate('transaction_date', $dateEn)
                // ->whereHas('manufactureStep', function($q) use ($issueV) {
                //     $q->where('wip_id', $issueV->wip_id);
                // })
                ->with('manufactureStep')
                ->get();
        }

        if ($casePmp0059) {

            $formYear = Carbon::createFromFormat('d/m/Y', request()->tran_date)->format('Y');
            $formDate = Carbon::createFromFormat('d/m/Y', request()->tran_date)->format('d-m');

            $year = (int) $formYear - 543;
            $date = (string) $formDate . "-" . $year;
            $date = date('Y/m/d', strtotime($date));

            if (request()->set_header == 'true') {
                $date = Carbon::createFromFormat('d/m/Y', request()->tran_date)->format('Y/m/d');
            }

            if (request()->batch_no) {
                $issueV =    PtmpMesReviewIssueV::where('batch_no', request()->batch_no)
                    ->where('organization_id', auth()->user()->organization_id)
                    ->whereDate('transaction_date',  $date)
                    ->when($profile->organization_code  == 'M03', function ($q) {
                        $q->whereIn('wip_step', ['WIP02', 'WIP03'])
                            ->where('wip_status', 2)
                            ->where('mes_job_status', "Y");
                    })
                    ->with(['uom'])
                    ->hasStampItem()
                    ->get();
            } else {
                $issueV =    PtmpMesReviewIssueV::where('inventory_item_id', request()->item_id)
                    ->where('organization_id', auth()->user()->organization_id)
                    ->whereDate('transaction_date',  $date)
                    ->when($profile->organization_code  == 'M03', function ($q) {
                        $q->whereIn('wip_step', ['WIP02', 'WIP03'])
                            ->where('wip_status', 2)
                            ->where('mes_job_status', "Y");
                    })
                    ->with(['uom'])
                    ->hasStampItem()
                    ->get();
            }

            $listOprnByItems =  PtpmManufactureStep::selectRaw('DISTINCT wip_step,
            wip_step_desc,
            owner_organization')
                ->whereIn('wip_step', $issueV->pluck('wip_step'))
                ->where('owner_organization', getDefaultData('/pm/wip-issue')->organization_code)
                ->orderBy('wip_step')
                ->get();
                // dd( $listOprnByItems);

            // dd($listOprnByItems);
            return response()->json([
                'listOprnByItems' => $listOprnByItems,
                'defaultOprn'   => $listOprnByItems->first(),

            ]);
        }

        // if ($programCode == 'PMP0049') {
        //     $formYear = Carbon::createFromFormat('d/m/Y', request()->tran_date)->format('Y');
        //     $formDate = Carbon::createFromFormat('d/m/Y', request()->tran_date)->format('d-m');

        //     $year =(int) $formYear-543;
        //     $date = (string) $formDate."-".$year;
        //     $date = date('Y/m/d', strtotime($date));

        //     if (request()->set_header == 'true') {
        //         $date = Carbon::createFromFormat('d/m/Y', request()->tran_date)->format('Y/m/d');
        //     }

        //     if (request()->batch_no) {
        //         $issueV =    PtmpMesReviewIssueV::where('batch_no', request()->batch_no)
        //         ->where('organization_id', auth()->user()->organization_id)
        //         ->whereDate('transaction_date',  $date)
        //         ->when($profile->organization_code  == 'M03', function($q) {
        //             $q->whereIn('wip_step', ['WIP02', 'WIP03'])
        //             ->where('wip_status', 2)
        //             ->where('mes_job_status', "Y");
        //         })
        //         ->with(['uom'])
        //         ->get();
        //     }else{
        //         $issueV =    PtmpMesReviewIssueV::where('inventory_item_id', request()->item_id)
        //         ->where('organization_id', auth()->user()->organization_id)
        //         ->whereDate('transaction_date',  $date)
        //         ->when($profile->organization_code  == 'M03', function($q) {
        //             $q->whereIn('wip_step', ['WIP02', 'WIP03'])
        //             ->where('wip_status', 2)
        //             ->where('mes_job_status', "Y");
        //         })
        //         ->with(['uom'])
        //         ->get();

        //     }

        //     $listOprnByItems =  PtpmManufactureStep::whereIn('wip_step', $issueV->pluck('wip_step'))
        //                         ->where('owner_organization', getDefaultData('/pm/wip-issue')->organization_code)
        //                         ->orderBy('wip_step')
        //                         ->get();


        //     // dd($listOprnByItems);
        //     return response()->json([
        //         'listOprnByItems' => $listOprnByItems,
        //         'defaultOprn'   => $listOprnByItems->first(),

        //     ]);
        // }


        // if (getDefaultData(\Request::path())->organization_code == 'M12') {

        //     $productBatchV = PtmpProductBatchV::where('organization_id', auth()->user()->organization_id)
        //                         ->where('wip_step', $issueV->wip_step)
        //                         ->where('batch_no', $issueV->batch_no)
        //                         ->first();
        //     dd( $productBatchV );
        // }

        // $listOprnByItems =  PtpmListOprnByItemsV::where('product_item_id', request()->item_id)
        //     ->where('organization_id', auth()->user()->organization_id)
        //     ->orderBy('oprn_no')
        //     ->get();


        // if ($programCode == 'PMP0051') {

        //     $formYear = Carbon::createFromFormat('d/m/Y', request()->tran_date)->format('Y');
        //     $formDate = Carbon::createFromFormat('d/m/Y', request()->tran_date)->format('d-m');

        //     $year =(int) $formYear-543;
        //     $date = (string) $formDate."-".$year;
        //     $date = date('Y/m/d', strtotime($date));

        //     if (request()->set_header == 'true') {
        //         $date = Carbon::createFromFormat('d/m/Y', request()->tran_date)->format('Y/m/d');
        //     }


        //     $issueV =    PtmpMesReviewIssueV::where('batch_no', request()->batch_no)
        //                 ->where('organization_id', auth()->user()->organization_id)
        //                 ->whereDate('transaction_date',  $date)
        //                 ->with(['uom'])
        //                 ->orderBy('wip_step')
        //                 ->first();


        //     $listOprnByItems = PtmpProductBatchV::where('organization_id', auth()->user()->organization_id)
        //                 // ->where('wip_step', $issueV->wip_step)
        //                 ->where('batch_no', $issueV->batch_no)
        //                 ->whereDate('transaction_date', $date)
        //                 // ->whereHas('manufactureStep', function($q) use ($issueV) {
        //                 //     $q->where('wip_id', $issueV->wip_id);
        //                 // })
        //                 ->with('manufactureStep')
        //                 ->get();
        //     // dd($listOprnByItems);


        // }

        // dd($listOprnByItems->first());
        return response()->json([
            'listOprnByItems'   => $listOprnByItems,
            'defaultOprn'       => $listOprnByItems->first(),
            'productBatchV'     => $listOprnByItems->first(),

        ]);
    }

    public function getFormula()
    {

        $casePmp0007 = request()->program_code == 'PMP0007' ? true : false;
        $casePmp0048 = request()->program_code == 'PMP0048' ? true : false;
        $casePmp0049 = request()->program_code == 'PMP0049' ? true : false;
        $casePmp0051 = request()->program_code == 'PMP0051' ? true : false;
        $casePmp0059 = request()->program_code == 'PMP0059' ? true : false;

        $getFormula =  request()->request_line != 1;
        $getLines   =  request()->request_line == 1;

        ini_set('max_execution_time', 1000);
        set_time_limit(1000);

        $programCode = request()->program_code;
        $request = request()->all();
        $header = null;
        $start  = microtime(true);


        //=====================================  PMP0007 =========================================
        if ($casePmp0007) {
            if ($getFormula) {
                $batchN0 = $request['blend_batch_no'] ?? $request['blend_no'];
                $formulas =  PtctMfgFormulaV::
                            // whereRaw("(formula_id,routing_id,recipe_id)= (select ptp.formula_id,ptp.routing_id, ptp.recipe_id from ptpm_summary_batch_v ptp where batch_no =  '$batchN0')")
                            where('product_item_id', $request['item_id'])
                            ->where('organization_id', auth()->user()->organization_id)
                            ->where('receipe_type_code', 1)
                            ->where('item_classification_code', '01')
                            ->where('organization_id', auth()->user()->organization_id)
                            ->where('reference_item_number' , null)
                            ->isApproved()
                            // ->where('item_number' , '100200BB1')
                            ->get();

                $max = $formulas->max('recipe_version');
                $formulasV = $formulas->where('recipe_version', $max);

                // 1001000BT6364

                $dataSet = (new WipIssueRequestRepository)->setFormula($formulasV, $request, $programCode, $costValidate = null);
                $formulasVV = $dataSet;
                $formulas = $formulasVV;


                return response()->json([
                    'formulas' => $formulas,
                    'header'  => $header
                ]);
                
            } else {

                $lines = PtpmMesReviewIssueLines::where('issue_header_id', request()->issue_header_id)
                        ->get()
                        ->sortBy('ptctMfgFormula.item_cat_code')
                        ->sortBy('ptctMfgFormula.item_number');
                // dd($lines);
                $linesV = [];
                foreach ($lines   as $line) {
                    // dd( $line->header->issue_status == '2');

                    $formula = $line->ptctMfgFormula;
                    if (!$formula) {
                        $formula = $line->mfgFormula;
                    }

                    if (!$formula) {
                        continue;
                    }

                    $onHandQty = $formula->getOnhand()->count()  > 0
                                ? $formula->getOnhand()->first()->onhand_quantity
                                : 0;
                    if($line->lot_number){

                        $checkOnhand = $formula->getOnhand()->where('lot_number', $line->lot_number)->first();
                        if($checkOnhand){
                            $onHandQty = $checkOnhand->onhand_quantity;
                        }
                    }
                    $sumQ               =  $formula->itemConvUom()
                                            ?  $formula->itemConvUom()->conversion_rate * $request['total_opt_quantity'] * $formula->ratio_qty_per_unit
                                            :  $request['total_opt_quantity'] * $formula->ratio_qty_per_unit;


                    // $groupLines  =  $formula->formulaline_id . $formula->leaf_formula ?? $formula->leaf_fomula;


                    // $formYear = Carbon::createFromFormat('d/m/Y',$line->issue_date)->format('Y-m-d');
                    // dd($formYear);
                    // $formDate = Carbon::createFromFormat('Y-m-d', $line->issue_date)->format('Y-m-d');
                    // $year =(int) $formYear-543;
                    // $date = (string) $formDate."-".$year;
                    // $date = date('Y-m-d', strtotime($line->issue_date));
                    // dd($formDate);
                    // dd(date('Y-m-d' , strtotime($line->header->issue_date)) , $line->issue_date);
                    // dd();
                    $date = date('Y-m-d' , strtotime($line->header->issue_date));

                    $period = PtBiweeklyV::whereRaw("TRUNC(to_date('$date', 'YYYY-MM-DD')) between start_date and end_date")->first();
                    $costValidate = (new CommonRepository)->costValidate(
                        $formula->inventory_item_id,
                        $formula->setupMfgDeptVLByUserOrg->from_organization_id,
                        $period->period_year );
                        $costValidate = (object)$costValidate;


                        $confirmQty = $line->confirm_qty;
                        if($formula->reference_item_number != null){
                            $groupLine = $formula->taxItem->formulaline_id.$formula->taxItem->leaf_fomula . $formula->taxItem->casting_flavor_name.'-1';
                            $leafFormula = $formula->taxItem->leaf_fomula ?? $formula->taxItem->leaf_formula;
                            // $msgOnhandText  = $this->checkOnhandTex($formula);
                            
    
                            if($checkOnhand){
                                $onHandQty = $checkOnhand->onhand_quantity;
                            } else {
                                $onHandQty =0;
                                $confirmQty=0;
                            } 

                        } else {
                            // dd('xxxx');
                            $msgOnhandText = "";
                            $groupLine = $formula->formulaline_id . $formula->leaf_fomula.$formula->casting_flavor_name;
                            $leafFormula = $formula->leaf_fomula ?? $formula->leaf_formula;
                            if($line->lot_number){
    
                                $checkOnhand = $formula->getOnhand()
                                        ->where('lot_number', $line->lot_number)
                                        ->first();

                            }
                        }
                        $linesV[] = $line->formulaline_id = [
                            'group_line'                => $groupLine,
                            'casting_flavor_name'       => $formula->casting_flavor_name,
                            'formulaline_id'            => $formula->formulaline_id,
                            'leaf_formula'              => $leafFormula,
                            'used_leaf_formula'         => $formula->used_leaf_formula,
                            'item_number'               => $formula->item_number,
    
                            'product_detail_uom'        => $formula->product_detail_uom,
                            'product_unit_of_measure'   => $formula->product_unit_of_measure,
    
                            // 'formula_uom'               =>
                            'from_subinventory'         => $line->subinventory_code,
                            'from_location_code'        => $formula->setupMfgDeptVLByUserOrg->from_location_code,
                            'default_lot_no'            => $line->lot_number,
                            'expiration_date'           => $line->expiration_date,
                            'line_quantity'             => $line->interface_status != null ? $line->attribute15 : $onHandQty,
                            'onhand_quantity'           => $onHandQty,
                            'onhand_quantity_display'   => $onHandQty,
                            'quantity_summary'          => round($sumQ, -1),
                            'input_quantity_summary'    => $confirmQty,
                            'item_desc'                 => $formula->item_desc,
                            'interface_status'          => $line->interface_status,
                            'onhand_lists'              => $formula->getOnhand(),
                            'line_disabled'             => false,
                            'last_line'                 => false,
                            'tobacco_ingrident_type'    => $formula->tobacco_ingrident_type,
                            'new_key'                   => 0,
                            'header_interface_status'   => $line->header->issue_status == '2' ? 'S' : $line->header->interface_status,
                            'reference_item_number'     => $formula->reference_item_number,
                            'item_cat_code'             => $formula->item_cat_code,
                            'msg_onhand_tax'            => $msgOnhandText,
                            'line_id'                   => $line->issue_line_id,
                            'cost_validate_msg'         => $costValidate->msg ?? "",
                            'cost_validate_status'      => $costValidate->status ?? "",
    
                        ];

                        // dd($linesV);
                    // } 
                    
                    
                    // else {
                    
                    // // dd($formula , $formula->taxItem);
                    // // dd($formula->taxItem->leaf_fomula);
                    //  $linesV[] = $line->formulaline_id = [
                    //         'group_line'                => $formula->taxItem->formulaline_id . $formula->taxItem->leaf_fomula,
                    //         'casting_flavor_name'       => $formula->taxItem->casting_flavor_name,
                    //         'formulaline_id'            => $formula->taxItem->formulaline_id,
                    //         'leaf_formula'              => $formula->taxItem->leaf_fomula ?? $formula->taxItem->leaf_formula,
                    //         'used_leaf_formula'         => $formula->taxItem->used_leaf_formula,
                    //         'item_number'               => $formula->taxItem->item_number,
    
                    //         'product_detail_uom'        => $formula->taxItem->product_detail_uom,
                    //         'product_unit_of_measure'   => $formula->taxItem->product_unit_of_measure,
    
                    //         // 'formula_uom'               =>
                    //         'from_subinventory'         => $line->subinventory_code,
                    //         'from_location_code'        => $formula->taxItem->setupMfgDeptVLByUserOrg->from_location_code,
                    //         'default_lot_no'            => $line->lot_number,
                    //         'expiration_date'           => $line->expiration_date,
                    //         'line_quantity'             => $line->interface_status != null ? $line->attribute15 : $onHandQty,
                    //         'onhand_quantity'           => $onHandQty,
                    //         'onhand_quantity_display'   => $onHandQty,
                    //         'quantity_summary'          => round($sumQ, -1),
                    //         'input_quantity_summary'    => $line->confirm_qty,
                    //         'item_desc'                 => $formula->item_desc,
                    //         'interface_status'          => $line->interface_status,
                    //         'onhand_lists'              => $formula->taxItem->getOnhand(),
                    //         'line_disabled'             => false,
                    //         'last_line'                 => false,
                    //         'tobacco_ingrident_type'    => $formula->taxItem->tobacco_ingrident_type,
                    //         'new_key'                   => 0,
                    //         'header_interface_status'   => $line->header->issue_status == '2' ? 'S' : $line->header->interface_status,
                    //         'reference_item_number'     => $formula->reference_item_number,
                    //         'item_cat_code'             => $formula->item_cat_code,
    
                    //     ];
                    //     // dd($linesV);
                    // }
                    

                    // TAX FORMULA
                    // $taxFormula = PtctMfgFormulaV::where('reference_item_number' , $formula->item_number)
                    //                 ->where('product_item_number' , $formula->product_item_number)
                    //                 ->where('organization_code' , $formula->organization_code)
                    //                 ->where('item_classification_code' , $formula->item_classification_code)
                    //                 ->first();
                    // if($taxFormula){
                    //     $linesV[] = $line->formulaline_id = [

                    //         'group_line'                => $formula->formulaline_id . $formula->leaf_formula ?? $formula->leaf_fomula,
    
                    //         'casting_flavor_name'       => $formula->casting_flavor_name,
                    //         'formulaline_id'            => $formula->formulaline_id,
                    //         'leaf_formula'              => $formula->leaf_fomula ?? $formula->leaf_formula,
                    //         'used_leaf_formula'         => $formula->used_leaf_formula,
                    //         'item_number'               => $formula->item_number,
    
                    //         'product_detail_uom'        => $formula->product_detail_uom,
                    //         'product_unit_of_measure'   => $formula->product_unit_of_measure,
    
                    //         // 'formula_uom'               =>
                    //         'from_subinventory'         => $line->subinventory_code,
                    //         'from_location_code'        => $formula->setupMfgDeptVLByUserOrg->from_location_code,
                    //         'default_lot_no'            => $line->lot_number,
                    //         'expiration_date'           => $line->expiration_date,
                    //         'line_quantity'             => $line->interface_status != null ? $line->attribute15 : $onHandQty,
                    //         'onhand_quantity'           => $onHandQty,
                    //         'onhand_quantity_display'   => $onHandQty,
                    //         'quantity_summary'          => round($sumQ, -1),
                    //         'input_quantity_summary'    => $line->confirm_qty,
                    //         'item_desc'                 => $taxFormula->item_desc,
                    //         'interface_status'          => $line->interface_status,
                    //         'onhand_lists'              => $taxFormula->getOnhand(),
                    //         'line_disabled'             => false,
                    //         'last_line'                 => false,
                    //         'tobacco_ingrident_type'    => $formula->tobacco_ingrident_type,
                    //         'new_key'                   => 0,
                    //         'header_interface_status'   => $line->header->issue_status == '2' ? 'S' : $line->header->interface_status,
    
                    //     ];
                    // }
                }

                $formulas =  $linesV;
                // dd($formulas ,collect($formulas)->sortBy('item_cat_code')->toArray());
                return response()->json([
                    'formulas' => $formulas,
                    'header'  => $header
                ]);
            }
        }

        //=====================================  PMP0048 ========================================

        if ($casePmp0048) {
            if ($getFormula) {
                // dd(sprintf("%02d", 14));
                // dd(number_format((int)7, 2));
                $batchN0 = $request['blend_batch_no'] ?? $request['blend_no'];
                $formulasV =  PtctMfgFormulaV::
                    // whereRaw("(formula_id,routing_id,recipe_id)= (select ptp.formula_id,ptp.routing_id, ptp.recipe_id from ptpm_summary_batch_v ptp where batch_no =  '$batchN0')")
                    where('product_item_id', $request['item_id'])
                    ->where('receipe_type_code', 1)
                    ->where('item_classification_code', '02')
                    ->where('organization_id', auth()->user()->organization_id)
                    ->isApproved()
                    // ->where('item_number', '100400023')
                    ->get()
                    // ->sortBy('casting_flavor_name')
                    // ->sortBy('item_number');
                    ->sortBy('group_line');
                    // dd($formulasV->pluck('group_line'));

                $max = $formulasV->max('recipe_version');
                $formulas = $formulasV->where('recipe_version', $max);

                // $str = preg_replace('/[^0-9.]+/', '',$formulas->first()->casting_flavor_name);

                // dd($str);
                // dd($formulas->pluck('casting_flavor_name'));
                $dataSet = (new WipIssueRequestRepository)->setFormula($formulas, $request, $programCode, $costValidate = null);
                $formulasVV = $dataSet;
                // dd($formulasVV);
                return response()->json([
                    'formulas' => $formulasVV,
                    'header'  => $header
                ]);
            } else {
                $lines = PtpmMesReviewIssueLines::where('issue_header_id', request()->issue_header_id)->get()
                            // ->sortBy('ptctMfgFormula.leaf_formula')
                            ->sortBy('ptctMfgFormula.casting_flavor_name')
                            ->sortBy('ptctMfgFormula.item_number');

                $linesV = [];
                foreach ($lines   as $line) {

                    $formula  = $line->ptctMfgFormula;
                    $onHandQty = $line->ptctMfgFormula->getOnhand()->count()  > 0
                                        ?  $line->ptctMfgFormula
                                            ->getOnhand()
                                            ->first()
                                            ->onhand_quantity
                                        : 0;
                                        
                    $sumQ               =  $formula->itemConvUom()
                        ? $formula->itemConvUom()->conversion_rate * (float)$request['total_opt_quantity'] * $formula->ratio_qty_per_unit
                        : (float)$request['total_opt_quantity'] * $formula->ratio_qty_per_unit;

                        if($line->lot_number){

                            $checkOnhand = $formula->getOnhand()->where('lot_number', $line->lot_number)->first();
                            if($checkOnhand){
                                $onHandQty = $checkOnhand->onhand_quantity;
                            }
                        }

                        $date = date('Y-m-d' , strtotime($line->header->issue_date));

                        $period = PtBiweeklyV::whereRaw("TRUNC(to_date('$date', 'YYYY-MM-DD')) between start_date and end_date")->first();
                        $costValidate = (new CommonRepository)->costValidate(
                            $formula->inventory_item_id,
                            $formula->setupMfgDeptVLByUserOrg->from_organization_id,
                            $period->period_year );
                            $costValidate = (object)$costValidate;

                            // dd($line->uom);
                    $linesV[] = $line->formulaline_id = [
                        'group_line'                =>  $formula->group_line,
                        'casting_flavor_name'       =>  $formula->casting_flavor_name,
                        'formulaline_id'            =>  $formula->formulaline_id,
                        'leaf_formula'              =>  $formula->leaf_fomula ??  $formula->leaf_formula,
                        'used_leaf_formula'         =>  $formula->used_leaf_formula,
                        'item_number'               =>  $formula->item_number,

                        'product_detail_uom'        =>  $formula->product_detail_uom,
                        'product_unit_of_measure'   =>   $line->uom->unit_of_measure ?? $formula->product_unit_of_measure,

                        // 'formula_uom'               =>
                        'from_subinventory'         => $line->subinventory_code,
                        'from_location_code'        =>  $formula->setupMfgDeptVLByUserOrg->from_location_code,
                        'default_lot_no'            => $line->lot_number,
                        'expiration_date'           => $line->expiration_date,
                        'line_quantity'             => $line->interface_status != null ? $line->attribute15 : $onHandQty,
                        'onhand_quantity'           => $onHandQty,
                        'onhand_quantity_display'   => $onHandQty,
                        'quantity_summary'          => $sumQ,
                        'input_quantity_summary'    => $line->confirm_qty,
                        'item_desc'                 =>  $formula->item_desc,
                        'interface_status'          => $line->interface_status,
                        'onhand_lists'              =>  $formula->getOnhand(),
                        'line_disabled'             => false,
                        'last_line'                 => false,
                        'tobacco_ingrident_type'    => $formula->tobacco_ingrident_type,
                        'new_key'                   => 0,
                        'header_interface_status'   => $line->header->interface_status,
                        'line_id'                   => $line->issue_line_id,
                        
                    ];
                }

                $formulas =  $linesV;



                return response()->json([
                    'formulas' => $formulas,
                    'header'  => $header
                ]);

            }
        }

        //=====================================  PMP0049 =========================================
        if ($casePmp0049) {
            if ($getFormula) {
                // get formula pmp0049
                $issueDate = Carbon::createFromFormat('d/m/Y', request()->date)->format('Y/m/d');
                $formYear  = Carbon::createFromFormat('d/m/Y', request()->date)->format('Y');
                $formDate  = Carbon::createFromFormat('d/m/Y', request()->date)->format('d-m');

                $year = (int) $formYear - 543;
                $date = (string) $formDate . "-" . $year;
                $issueDate = date('Y/m/d', strtotime($date));

                $header =  PtpmMesReviewIssueHeaders::where('program_code', $programCode)
                    ->where('organization_id', auth()->user()->organization_id)
                    ->where('issue_status', '!=' , 3)
                    ->where('batch_no', request()->blend_no)
                    ->where('wip_step', request()->oprn_no)
                    ->where('inventory_item_id', request()->item_id)
                    ->whereDate('issue_date',  $issueDate)
                    ->with('issueStatus')
                    ->orderBy('issue_header_id', 'desc')
                    ->first();
                    
                    if($header){
                        $linesV = $this->setLinesPmp0049($header->mesReviewIssueLines()->get());
                        
                        return response()->json([
                            'formulas' => $linesV,
                            'header'  => $header
                        ]);
                    }

                $blend =    PtmpMesReviewIssueV::where('batch_no', $request['blend_no'])->first();
                $mfg =  PtpmSetupMfgDepartmentsV::where('organization_id', auth()->user()->organization_id)
                    ->where('wip_transaction_type_id', 35)
                    ->whereHas('formulas', function ($fml) use ($request, $blend) {
                        $fml->where('product_item_id', $request['item_id'])
                            // ->where('item_classification_code',$request['classification'])
                            // ->where('product_blend_no',  $blend->blend_no)
                        ;
                    })
                    ->get();



                $formulas = PtpmMfgFormulaV::has('setupMfgDeptVLByUserOrg')
                    ->where('product_item_id', $request['item_id'])
                    ->where('organization_id', auth()->user()->organization_id)
                    ->where('receipe_type_code', 1)
                    ->where('item_cat_code', '<>', '1013') // แสตมป์
                    // ->where('item_classification_code', null)
                    ->where('oprn_code', $request['oprn_no'])
                    // ->where('item_number', '100300001')
                    ->get();
                // dd($formulas->where('item_number','100300001'));
                $dataSet = (new WipIssueRequestRepository)->setFormulaByPMP0049($formulas, $request, $programCode);

                $formulasVV = $dataSet;

                return response()->json([
                    'formulas' => $formulasVV,
                    'header'  => $header
                ]);
            } else {
                // get Lines pmp0049
                $lines = PtpmMesReviewIssueLines::where('issue_header_id', request()->issue_header_id)->get();
                $linesV = $this->setLinesPmp0049($lines);
                // $linesV = [];
                // foreach ($lines   as $line) {
                //     $onhands =  $line->mfgFormula->getOnhand();
                //     $uOnhand = 0;
                //     if (!$onhands->first()) {
                //         $uOnhand  = $onhands->first() ? $onhands->first()->onhand_quantity : 0;
                //     }

                //     $request = [
                //         'oprn_no' => $line->header->wip_step,
                //         'blend_no' =>  $line->header->batch_no,
                //     ];
                //     $date = date('d-M-Y', strtotime($line->header->complete_date));
                //     $mfgFormula = $line->mfgFormula ? $line->mfgFormula : new PtctMfgFormulaV;

                //     $summaryQty =  (new WipIssueRequestRepository)->summaryQty($request, $mfgFormula, $date);
                //     $linesV[] = $line->formulaline_id = [
                //         'casting_flavor_name'       => $mfgFormula->casting_flavor_name,
                //         'formulaline_id'            => $mfgFormula->formulaline_id,
                //         'leaf_formula'              => $mfgFormula->leaf_fomula ?? $mfgFormula->leaf_formula,
                //         'used_leaf_formula'         => $mfgFormula->used_leaf_formula,
                //         'item_number'               => $mfgFormula->item_number,
                //         'item_desc'                 => $mfgFormula->item_desc,
                //         'product_detail_uom'        => $line->confirm_uom_code,
                //         'product_unit_of_measure'   => $line->uom->unit_of_measure  ?? $mfgFormula->product_unit_of_measure,
                //         'item_desc'                 => $mfgFormula->item_desc,
                //         // 'formula_uom'               =>
                //         'from_subinventory'         => $line->subinventory_code,
                //         'from_location_code'        => $line->organization_code,
                //         'default_lot_no'            => $line->lot_number,
                //         'expiration_date'           => $line->expiration_date,
                //         'line_quantity'             => $onhands->where('lot_number', $line->lot_number)->first()
                //                                         ? $onhands->where('lot_number', $line->lot_number)->first()->onhand_quantity
                //                                         : $uOnhand,
                //         'onhand_quantity'           => $onhands->where('lot_number', $line->lot_number)->first()
                //                                         ? $onhands->where('lot_number', $line->lot_number)->first()->onhand_quantity
                //                                         : $line->attribute15,
                //         'quantity_summary'          => $summaryQty,
                //         'input_quantity_summary'    => $line->confirm_qty * 1,
                //         'item_desc'                 => $mfgFormula->item_desc,
                //         'interface_status'          => $line->interface_status,
                //         'onhand_lists'              => $mfgFormula->getOnhand(),
                //         'line_disabled'             => false,
                //         'last_line'                 => false,
                //         'tobacco_ingrident_type'    => $mfgFormula->tobacco_ingrident_type,
                //         'new_key'                   => 0,
                //         'header_interface_status'   => $line->header->interface_status,
                //         'line_id'                   => $line->issue_line_id,
                //     ];
                // }
                $header = $lines->first() ? $lines->first()->header : null;
                $formulas =  $linesV;

                return response()->json([
                    'formulas' => $formulas,
                    'header'  => $header
                ]);
            }
        }

        //=====================================  PMP0051 =========================================
        if ($casePmp0051) {
            if($getFormula){

                $issueDate = Carbon::createFromFormat('d/m/Y', request()->date)->format('Y/m/d');
                $formYear  = Carbon::createFromFormat('d/m/Y', request()->date)->format('Y');
                $formDate  = Carbon::createFromFormat('d/m/Y', request()->date)->format('d-m');

                $year = (int) $formYear - 543;
                $date = (string) $formDate . "-" . $year;
                $issueDate = date('Y/m/d', strtotime($date));


                if (!!$header) {
                    request()->request_line = 1;
                    request()->issue_header_id = $header->issue_header_id;
                }
                

                // dd(request()->all() , $request['item_id'] , $request['oprn_no']);

                $header =  PtpmMesReviewIssueHeaders::where('program_code', $programCode)
                            ->where('organization_id', auth()->user()->organization_id)
                            ->where('issue_status', '!=' , 3)
                            ->where('batch_no', request()->blend_no)
                            ->where('wip_step', request()->oprn_no)
                            ->where('inventory_item_id', request()->item_id)
                            ->whereDate('issue_date',  $issueDate)
                            ->with('issueStatus')
                            ->orderBy('issue_header_id', 'desc')
                            ->first();

    
                if($header){
                    // dd( $header );
                    $linesV = $this->setLinesPmp0051($header->mesReviewIssueLines()->get());
                    // dd($header);
                    return response()->json([
                        'formulas' => $linesV,
                        'header'  => $header
                    ]);
                }

                // dd('xxx');

                // $formulas =  PtctMfgFormulaV::whereHas('summaryBatch1V', function ($q) {
                //                 $q->where('batch_no', request()->blend_no);
                //             })
                //             ->get();
                // $max = $formulas->max('recipe_version');
                // $uFormulas = $formulas->where('recipe_version', $max);


                
                $formulas = PtpmMfgFormulaV::has('setupMfgDeptVLByUserOrg')
                            ->where('product_item_id', $request['item_id'])
                            ->where('organization_id', auth()->user()->organization_id)
                            ->where('receipe_type_code', 1)
                            ->where('oprn_code', $request['oprn_no'])
                            ->get();
                // dd($formulas);
                $dataSet = (new WipIssueRequestRepository)->setFormulaByPMP0049($formulas, $request, $programCode);
    
                $formulasVV = $dataSet;
    
                return response()->json([
                    'formulas' => $formulasVV,
                    'header'  => $header
                ]);
            } else {

                $lines = PtpmMesReviewIssueLines::where('issue_header_id', request()->issue_header_id)->get();
                $linesV = $this->setLinesPmp0051($lines);
                return response()->json([
                    'formulas' => $linesV,
                    'header'  => $header
                ]);
                // $linesV = [];

                // foreach ($lines   as $line) {
                //         $onhands = $line->ptctMfgFormula 
                //             ?  $line->ptctMfgFormula->getOnhand() 
                //             :  new PtinvOnhandQuantitiesV;
                //         $line->tctMfgFormula;
                //         $uOnhand = 0;
                //         if (!$onhands->first()) {
                //             $uOnhand  = $onhands->first() ? $onhands->first()->onhand_quantity : 0;
                //         }

                //     $request = [
                //         'oprn_no' => $line->header->wip_step,
                //         'blend_no' =>  $line->header->batch_no,
                //     ];

                //     $date = date('d-M-Y', strtotime($line->header->complete_date));
                //     $mfgFormula = $line->ptctMfgFormula ? $line->ptctMfgFormula : new PtctMfgFormulaV;
                //     $summaryQty = (float)request()->total_opt_quantity * $mfgFormula->ratio_qty_per_unit;

                //     $linesV[] = $line->formulaline_id = [
                //         'casting_flavor_name'       => $mfgFormula->casting_flavor_name,
                //         'formulaline_id'            => $mfgFormula->formulaline_id,
                //         'leaf_formula'              => $mfgFormula->leaf_fomula ?? $mfgFormula->leaf_formula,
                //         'used_leaf_formula'         => $mfgFormula->used_leaf_formula,
                //         'item_number'               => $mfgFormula->item_number,
                //         'item_desc'                 => $mfgFormula->item_desc,
                //         'product_detail_uom'        => $line->confirm_uom_code,
                //         // 'product_unit_of_measure'   => $mfgFormula->th_detail_unit_of_measure,
                //         'product_unit_of_measure'   => $line->uom->unit_of_measure  ?? $mfgFormula->product_unit_of_measure,
                //         // $line->uom->unit_of_measure ?? $formula->product_unit_of_measure
                //         'item_desc'                 => $mfgFormula->item_desc,
                //         'from_subinventory'         => $line->subinventory_code,
                //         'from_location_code'        => $line->organization_code,
                //         'default_lot_no'            => $line->lot_number,
                //         'expiration_date'           => $line->expiration_date,
                //         'line_quantity'             => $onhands->where('lot_number', $line->lot_number)->first()
                //                                         ? $onhands->where('lot_number', $line->lot_number)->first()->onhand_quantity
                //                                         : $uOnhand,
                //         'onhand_quantity'           => $onhands->where('lot_number', $line->lot_number)->first()
                //                                         ? $onhands->where('lot_number', $line->lot_number)->first()->onhand_quantity
                //                                         : $line->attribute15,
                //         'quantity_summary'          => $summaryQty,
                //         'input_quantity_summary'    => $line->confirm_qty * 1,
                //         'item_desc'                 => $mfgFormula->item_desc,
                //         'interface_status'          => $line->interface_status,
                //         'onhand_lists'              => $mfgFormula->getOnhand(),
                //         'line_disabled'             => false,
                //         'last_line'                 => false,
                //         'tobacco_ingrident_type'    => $mfgFormula->tobacco_ingrident_type,
                //         'new_key'                   => 0,
                //         'header_interface_status'   => $line->header->interface_status,
                        
                //     ];
                // }
                // $header = $lines->first() ? $lines->first()->header : null;
                // $formulas =  $linesV;

            }
            

        }

        //=====================================  PMP0059 =========================================
        if ($casePmp0059) {
            if ($getFormula) {
                // get formula pmp0059
                $issueDate = Carbon::createFromFormat('d/m/Y', request()->date)->format('Y/m/d');
                $formYear  = Carbon::createFromFormat('d/m/Y', request()->date)->format('Y');
                $formDate  = Carbon::createFromFormat('d/m/Y', request()->date)->format('d-m');

                $year = (int) $formYear - 543;
                $date = (string) $formDate . "-" . $year;
                $issueDate = date('Y/m/d', strtotime($date));

                $header =  PtpmMesReviewIssueHeaders::where('program_code', $programCode)
                    ->where('organization_id', auth()->user()->organization_id)
                    ->where('issue_status', '!=' , 3)
                    ->where('batch_no', request()->blend_no)
                    ->where('wip_step', request()->oprn_no)
                    ->where('inventory_item_id', request()->item_id)
                    ->whereDate('issue_date',  $issueDate)
                    ->with('issueStatus')
                    ->orderBy('issue_header_id', 'desc')
                    ->first();

                    if($header){
                        $linesV = $this->setLinesPmp0059($header->mesReviewIssueLines()->get());
                        return response()->json([
                            'formulas' => $linesV,
                            'header'  => $header
                        ]);
                    }

                $blend =    PtmpMesReviewIssueV::where('batch_no', $request['blend_no'])->first();
                $mfg =  PtpmSetupMfgDepartmentsV::where('organization_id', auth()->user()->organization_id)
                    ->where('wip_transaction_type_id', 35)
                    ->whereHas('formulas', function ($fml) use ($request, $blend) {
                        $fml->where('product_item_id', $request['item_id'])
                            // ->where('item_classification_code',$request['classification'])
                            // ->where('product_blend_no',  $blend->blend_no)
                        ;
                    })
                    ->get();



                $formulas = PtpmMfgFormulaV::has('setupMfgDeptVLByUserOrg')
                    ->where('product_item_id', $request['item_id'])
                    ->where('organization_id', auth()->user()->organization_id)
                    ->where('receipe_type_code', 1)
                    ->where('item_cat_code', '1013') // แสตมป์
                    // ->where('item_classification_code', null)
                    ->where('oprn_code', $request['oprn_no'])
                    // ->where('item_number', '100300001')
                    ->get();
                // dd($formulas->where('item_number','100300001'));
                $dataSet = (new WipIssueRequestRepository)->setFormulaByPMP0059($formulas, $request, $programCode);

                $formulasVV = $dataSet;

                return response()->json([
                    'formulas' => $formulasVV,
                    'header'  => $header
                ]);
            } else {
                // get Lines pmp0059
                $lines = PtpmMesReviewIssueLines::where('issue_header_id', request()->issue_header_id)->get();
                $linesV = $this->setLinesPmp0059($lines);
                $header = $lines->first() ? $lines->first()->header : null;
                $formulas =  $linesV;

                return response()->json([
                    'formulas' => $formulas,
                    'header'  => $header
                ]);
            }
        }



        dd(" noting  ");

    }

    public function findClassification()
    {
        $classificationCode =  request()->classification_code;

        $classification =  PtctMfgFormulaV::where('item_classification_code', $classificationCode)
            ->where('organization_id', auth()->user()->organization_id)
            ->first();

        return response()->json([
            'classification' => $classification,
        ]);
    }

    public function saveData()
    {
        $programCode        = request()->program_code;
        $profile            = getDefaultData(\Request::path());
        $interfaceStatus    = [];

        $result = [
            'status' => 'S',
            'msg'    => 'บันทึกสำเร็จ'
        ];

        if (request()->submit != true) {
            try {
                $mesReviewIssueHeader = (new WipIssueRequestRepository)->save(request());

                (new WipIssueRequestRepository)->updateRequestNumber(PtpmMesReviewIssueHeaders::find($mesReviewIssueHeader->issue_header_id));
            } catch (\Exception $e) {
                $result = [
                    'status' => 'E',
                    'msg'   =>  $e->getMessage()
                ];

                return response()->json([
                    'result'    => $result,
                ]);
            }
        }


        if (request()->submit == true) {

            $interfaceStatus = [];

            $mesReviewIssueHeader = PtpmMesReviewIssueHeaders::where('issue_header_id', request()->issue_header_id)
                ->with('issueStatus')
                ->first();
            $programCode = $programCode ?? $mesReviewIssueHeader->program_code;

            $lines = $mesReviewIssueHeader->mesReviewIssueLines()
                                        ->where('confirm_qty', 0)
                                        ->get();

            foreach ($lines as $key => $line) {
                $line->web_batch_no = $line->web_batch_no . '-' . 'x';
                $line->interface_status = "S";
                $line->save();
            }

            try {
                logger("submit");
                $interfaceStatus = (new WipIssueRequestRepository)->submit($mesReviewIssueHeader->web_batch_no, $programCode);
            } catch (\Exception $e) {
                $result = [
                    'status' => 'E',
                    'msg'   =>  $e->getMessage()
                ];

                return response()->json([
                    'result'    => $result,
                ]);
            }

            $result = [
                'status' => 'S',
                'msg'    => 'บันทึกสำเร็จ'
            ];

            $newHeader = PtpmMesReviewIssueHeaders::where('issue_header_id', $mesReviewIssueHeader->issue_header_id)
                ->with('issueStatus')
                ->first();

            if ($mesReviewIssueHeader->interface_status == 'S') {
                $result = [
                    'status' => 'S',
                    'msg'    => 'ตัดใช้สำเร็จ'
                ];

                $mesReviewIssueHeader->issue_status = 2;
                $mesReviewIssueHeader->save();
            }

            if ($newHeader->interface_status == 'S'  && ($profile->organization_code == 'MG6' || $profile->organization_code == 'M05' || $profile->organization_code == 'MG6')) {
                $productLine = OapmPtmesProductLine::where('organization_id', auth()->user()->organization_id)
                                                    ->where('wip_step', $mesReviewIssueHeader->wip_step)
                                                    ->where('batch_id', $mesReviewIssueHeader->batch_id)
                                                    ->whereDate('product_date', Carbon::parse($mesReviewIssueHeader->complete_date))
                                                    ->first();

                $productLine->transaction_flag = 'Y';
                $productLine->save();
            }

            if ($newHeader->interface_status == 'S'  && ($profile->organization_code == 'M06' || $profile->organization_code == 'M12')) {
                $organizationId     = session('organization_id',  auth()->user()->organization_id);
                $batchId            = $mesReviewIssueHeader->batch_id;
                $wipStep            = $mesReviewIssueHeader->wip_step;
                $productDate        = Carbon::parse($mesReviewIssueHeader->complete_date)->format('Y-m-d');

                $db = \DB::statement("
                    UPDATE ptpm_product_header SET transaction_flag = 'Y'
                    WHERE 1=1
                    and organization_id = $organizationId
                    AND batch_id = $batchId
                    --AND wip_step = '$wipStep'
                    AND TRUNC(PRODUCT_DATE) = TO_DATE('$productDate', 'YYYY-MM-DD')
                ");
            }

            if ($newHeader->interface_status != 'S') {
                $err =  "";
                $err =  $newHeader->mesReviewIssueLines->pluck('interface_msg', 'interface_msg')->implode(',');
                $result = [
                    'status' => 'E',
                    'msg'   =>  $err
                ];
            }
        }

        $newMesReviewIssueHeader = PtpmMesReviewIssueHeaders::where('issue_header_id', $mesReviewIssueHeader->issue_header_id)
                                                            ->with('issueStatus')
                                                            ->first();

        if ($newMesReviewIssueHeader->interface_status != 'S' && request()->submit == true) {
            $err =  $newMesReviewIssueHeader->mesReviewIssueLines()->pluck('interface_msg', 'interface_msg')->implode(',');
            $result = [
                'status' => 'E',
                'msg'   =>  $err
            ];
        }

        $uLines = $newMesReviewIssueHeader->mesReviewIssueLines->sortBy('ptctMfgFormula.item_cat_code')->sortBy('ptctMfgFormula.item_number');
        if($programCode == 'PMP0048'){
            $uLines = PtpmMesReviewIssueLines::where('issue_header_id',  $newMesReviewIssueHeader->issue_header_id)
                    ->get()
                    ->sortBy('ptctMfgFormula.used_leaf_formula')
                    ->sortBy('ptctMfgFormula.used_leaf_formula')
                    ->sortBy('ptctMfgFormula.item_number');

        }
    
        $lines = $this->setLines($uLines, request());
        
        return response()->json([
            'is_interface'      => request()->submit,
            'interfaceStatus'   => $interfaceStatus,
            'result'            => $result,
            'header'            => $newMesReviewIssueHeader,
            'lines'             => $lines,
            'all_opt'           => $newMesReviewIssueHeader->childHeaders->count() > 0
                                    ? true
                                    : false,
            'total_qty'         => $newMesReviewIssueHeader->childHeaders->count() > 0
                                    ?  $newMesReviewIssueHeader->childHeaders->sum('opt_plan_qty') + $newMesReviewIssueHeader->opt_plan_qty
                                    : $newMesReviewIssueHeader->opt_plan_qty,
        ]);
    }

    public function cancelData()
    {
        $profile =  getDefaultData(\Request::path());

        try {
            $mesReviewIssueHeaders = PtpmMesReviewIssueHeaders::where('attribute15', request()->issue_header_id)
                ->orWhere('issue_header_id', request()->issue_header_id)
                ->get();
            foreach ($mesReviewIssueHeaders as $mesReviewIssueHeader) {
                if ($mesReviewIssueHeader->interface_status != null) {
                    $mesReviewIssueHeader->cancel_flag = 'Y';
                    $mesReviewIssueHeader->interface_status = null;
                    $mesReviewIssueHeader->attribute1 = null;
                    $mesReviewIssueHeader->issue_status = 3;
                    $mesReviewIssueHeader->record_status = 'UPDATE';
                    $mesReviewIssueHeader->save();

                    $mesReviewIssueHeader->mesReviewIssueLines()
                        ->update([
                            'attribute1' =>  null,
                            'interface_status'  => null,
                            'record_status' => 'UPDATE'
                        ]);
                } else {
                    // $mesReviewIssueHeader->mesReviewIssueLines()->delete();
                    // $mesReviewIssueHeader->delete();

                    $result = [
                        'status' => 'S',
                        'msg'    => 'ยกเลิกสำเร็จ',
                        'interface_status' => "",
                    ];
                }
            }
        } catch (\Exception $e) {

            $result = [
                'status' => 'E',
                'msg'    => $e->getMessage(),
                'interface_status' => ""
            ];

            return response()->json([
                'result' => $result,
            ]);
        }

        if ($mesReviewIssueHeader) {

            $interfaceStatus = (new WipIssueRequestRepository)->submit($mesReviewIssueHeader->web_batch_no, $mesReviewIssueHeader->program_code);

            $newMesReviewIssueHeader = PtpmMesReviewIssueHeaders::where('issue_header_id', $mesReviewIssueHeader->issue_header_id)
                                        ->with('issueStatus')
                                        ->first();

            if ($newMesReviewIssueHeader->interface_status != 'S') {
                $headers =  PtpmMesReviewIssueHeaders::where('issue_header_id', $mesReviewIssueHeader->issue_header_id)
                                                        ->orWhere('attribute15' , $mesReviewIssueHeader->issue_header_id)
                                                        ->get();
                if (count($headers) > 1) {
                    foreach ($headers as $key => $header) {
                        $header->issue_status = 2;
                        $header->save();
                    }
                }

                $mesReviewIssueHeader->issue_status = 2;
                $mesReviewIssueHeader->save();

            }

            if ($newMesReviewIssueHeader->interface_status == 'S'  && ($profile->organization_code == 'MG6' || $profile->organization_code == 'M05')) {
                $productLine = OapmPtmesProductLine::where('organization_id', auth()->user()->organization_id)
                    ->where('wip_step', $mesReviewIssueHeader->wip_step)
                    ->where('batch_id', $mesReviewIssueHeader->batch_id)
                    ->whereDate('product_date', Carbon::parse($mesReviewIssueHeader->complete_date))
                    ->first();
                $productLine->transaction_flag = null;
                $productLine->save();
            }

            if ($newMesReviewIssueHeader->interface_status == 'S'  && ($profile->organization_code == 'M06' || $profile->organization_code == 'M12')) {
                $organizationId     = session('organization_id',  auth()->user()->organization_id);
                $batchId            = $mesReviewIssueHeader->batch_id;
                $wipStep            = $mesReviewIssueHeader->wip_step;
                $productDate        = Carbon::parse($mesReviewIssueHeader->complete_date)->format('Y-m-d');

                $db = \DB::statement("
                    UPDATE ptpm_product_header SET transaction_flag = null
                    WHERE 1=1
                    and organization_id = $organizationId
                    AND batch_id = $batchId
                    --AND wip_step = '$wipStep'
                    AND TRUNC(PRODUCT_DATE) = TO_DATE('$productDate', 'YYYY-MM-DD')
                ");
            }


            if ($newMesReviewIssueHeader->interface_status == 'S') {
                $msg = 'ยกเลิกสำเร็จ';
            } else {

                // if ($mesReviewIssueHeader->interface_status != null) {
                    // $mesReviewIssueHeader->cancel_flag = 'Y';
                    // $mesReviewIssueHeader->interface_status = null;
                    // $mesReviewIssueHeader->attribute1 = null;
                    // $mesReviewIssueHeader->issue_status = 2;
                    // $mesReviewIssueHeader->record_status = 'INSERT';
                    // $mesReviewIssueHeader->save();

                    // $mesReviewIssueHeader->mesReviewIssueLines()
                    //     ->update([
                    //         'attribute1' =>  null,
                    //         'interface_status'  => null,
                    //         'record_status' => 'UPDATE'
                    //     ]);
                // $err =  $newMesReviewIssueHeader->mesReviewIssueLines()->pluck('interface_msg' , 'interface_msg')->implode(',');
                $msg =  $newMesReviewIssueHeader->mesReviewIssueLines()->pluck('interface_msg', 'interface_msg')->implode(',');
            }





            // $newMesReviewIssueHeader->interface_status =='S' ?'ยกเลิกสำเร็จ' : 'ยกเลิกไม่สำเร็จ';
            $result = [
                'status' => $newMesReviewIssueHeader->interface_status,
                'msg'    => $msg,
                'interface_status' => $newMesReviewIssueHeader->interface_msg,
                'mesReviewIssueHeader' => $newMesReviewIssueHeader,
                'request_number'    => $newMesReviewIssueHeader->request_number,
                'header_status'     => $newMesReviewIssueHeader->issueStatus->description,
            ];
        }

        return response()->json([
            'result' => $result,
        ]);
    }

    public function updateData()
    {
        $mesReviewIssueHeader = PtpmMesReviewIssueHeaders::where('issue_header_id', request()->issue_header_id)
                                ->with('issueStatus')
                                ->first();

        if ($mesReviewIssueHeader->program_code == "PMP0048" || 
            $mesReviewIssueHeader->program_code == "PMP0049" ||
            $mesReviewIssueHeader->program_code == "PMP0007" || 
            $mesReviewIssueHeader->program_code == "PMP0051" || 
            $mesReviewIssueHeader->program_code == "PMP0059") {
            (new WipIssueRequestRepository)->updateLineCasingFlavor(request(), $mesReviewIssueHeader);
        }else {
            foreach (request()->lines as $line) {
                $mesReviewIssueLine = PtpmMesReviewIssueLines::where('formulaline_id', $line['formulaline_id'])
                                    ->where('issue_header_id', request()->issue_header_id)
                                    ->first();

                $mesReviewIssueLine->confirm_qty        = $line['input_quantity_summary'];
                $mesReviewIssueLine->attribute15        = $line['onhand_quantity'];
                $mesReviewIssueLine->updated_at         = now();
                $mesReviewIssueLine->updated_by_id      = auth()->user()->id;
                $mesReviewIssueLine->last_updated_by    = auth()->user()->id;
                $mesReviewIssueLine->last_update_date   = now();
                $mesReviewIssueLine->creation_date      = auth()->user()->id;
                $mesReviewIssueLine->save();

            }

        }

        $result = [
            'status' => 'S',
            'msg'    => 'บันทึกสำเร็จ'
        ];

        return response()->json([
            'result' => $result,
            'header'            => $mesReviewIssueHeader,
        ]);
    }

    public function searchHeader()
    {
        $startDate  = null;
        $endDate    = null;
        $oneDate    = null;
        // dd(request()->all());
        $casePmp0007 = request()->program_code == 'PMP0007' ? true : false;
        $casePmp0048 = request()->program_code == 'PMP0048' ? true : false;
        $casePmp0049 = request()->program_code == 'PMP0049' ? true : false;
        $casePmp0051 = request()->program_code == 'PMP0051' ? true : false;
        $casePmp0059 = request()->program_code == 'PMP0059' ? true : false;

        $profile =  getDefaultData(\Request::path());
        if (request()->start_date != "Invalid date" &&  request()->end_date != 'Invalid date') {
            if (request()->start_date == request()->end_date) {
                $oneDate = true;
            }
        }

        if (request()->start_date != "Invalid date") {
            $startDate  = Carbon::createFromFormat('d/m/Y', request()->start_date)->format('Y/m/d');
        }

        if (request()->end_date != 'Invalid date') {
            $endDate    = Carbon::createFromFormat('d/m/Y', request()->end_date)->format('Y/m/d');
        }

        $batchNo    = request()->batch_no;
        
        // dd($casePmp0007 && request()->product && $profile->organization_code == 'MP2');
        $mesReviewIssueHeaders = PtpmMesReviewIssueHeaders::where('organization_id', auth()->user()->organization_id)
            ->when(!$oneDate,  function ($e) use ($startDate, $endDate, $batchNo) {
                $e->when($startDate, function ($q) use ($startDate) {
                    $q->whereDate('issue_date', '>=',  $startDate);
                })
                    ->when($endDate, function ($q) use ($endDate) {
                        $q->whereDate('issue_date', '<=',  $endDate);
                    });
            })
            ->when($oneDate, function ($q) use ($startDate) {
                $q->whereDate('issue_date', $startDate);
            })
            ->when($batchNo, function ($q) use ($batchNo) {
                $q->where('request_number', 'like', '%' . $batchNo . '%');
            })
            ->when(request()->item_classification_code != 'undefined', function ($q) {
                $q->where('ingridient_group_code', request()->item_classification_code);
            })
            ->when(request()->status, function ($q) {
                $q->where('issue_status', request()->status);
            })
            ->when(($casePmp0049 || $casePmp0051 || $casePmp0059) && request()->product, function ($q) {
                $q->whereHas('mesReviewIssueView', function ($i) {
                    $i->where('item_number', request()->product);
                });
            })
            ->when(($casePmp0007 || $casePmp0048) && request()->product && $profile->organization_code != 'MP2', function($q) {
                $q->whereHas('mesPmp0007And48', function ($i) {
                    $i->where('item_number', request()->product);
                });
            })
            ->when($casePmp0007 && request()->product && $profile->organization_code == 'MP2', function($q) {
                $q->whereHas('mesReviewIssueView', function ($i) {
                    $i->where('item_number', request()->product);
                });
            })
            ->when(request()->job, function ($q) {
                $q->where('batch_no', request()->job);
            })
            ->when(request()->program_code, function ($q) {
                $q->where('program_code', request()->program_code);
            })
            ->where('attribute15', null)
            ->orderBy('issue_date')
            ->orderBy('request_number')
            // ->orderBy('issue_date', 'desc')
            ->get();

        // dd($mesReviewIssueHeaders);
        $headers = [];


        foreach ($mesReviewIssueHeaders as $header) {
            // dd($header->mesReviewIssueLines , $header->mesReviewIssueView);
            if (!$header->mesReviewIssueLines || !$header->mesReviewIssueView) {
                continue;
            }
            // dd(PtmpMesReviewIssueV::where('batch_id', $header->batch_id)->first());
            $formYear = Carbon::parse($header->issue_date)->format('Y');
            $formDate = Carbon::parse($header->issue_date)->format('d-m');

            $year = (int) $formYear + 543;
            $date = (string) $formDate . "-" . $year;
            $date = date('d-m-Y', strtotime($date));

            if (getDefaultData('/pm/wip-issue')->organization_code == 'M02') {
                $blend      = $header->mesReviewIssueVHasBlend;
                $item       = $header->mesReviewIssueVHasBlend;
            } else {
                $blend      = $header->mesReviewIssueView;
                $item       = $header->mesReviewIssueView;
            }
            if (!$blend ||  !$item) {
                continue;
            }
            // dd($item, $blend);
            // $blend =  PtmpMesReviewIssueV::where('batch_id', $header->batch_id)->first();
            // $item = $blend->mtlSystemItemB;
            $headers[] = [
                'request_number'    => $header->request_number,
                'issue_header_id'   => $header->issue_header_id,
                'status'            => $header->issueStatus->description,
                'department_code'   => $header->department_code,
                'batch_no'          => $header->batch_no,
                'issue_date'        => date('d/m/Y', strtotime($header->issue_date)),
                'complete_date'     => date('d/m/Y', strtotime($header->complete_date)),
                'report_date'       => date('Y-m-d', strtotime($header->complete_date)),
                'interface_status'  => $header->interface_status,
                'badge_status'      => $header->badgeStatus(),
                'wip_step'          => $header->wip_step,
                'issue_status'      => $header->issue_status,
                'show_date_th'      => $date,
                'blend'             => $blend,
                'item_number'       => $item->item_number,
                'item_description'  => $item->item_description,

                //  $header->mesReviewIssueView()->get(['']),

            ];
        }
        // dd( $headers);
        // $headers = (new WipIssueRequestRepository)->setHeader($mesReviewIssueHeaders);

        return response()->json([
            'mesReviewIssueHeaders' => $headers
        ]);
    }

    public function convDate($date)
    {

        $formYear = Carbon::createFromFormat('d/m/Y', request()->date)->format('Y');
        $formDate = Carbon::createFromFormat('d/m/Y', request()->date)->format('d-m');

        $year = (int) $formYear - 543;
        $date = (string) $formDate . "-" . $year;
        $date = date('Y/m/d', strtotime($date));

        return  $date;
    }

    public function findHeader($headerId)
    {

        $header  =  PtpmMesReviewIssueHeaders::find($headerId);
        // dd(getDefaultData('/pm/wip-issue')->organization_code);
        $wip = PtpmManufactureStep::where('owner_organization',  getDefaultData('/pm/wip-issue')->organization_code)
            ->where('wip_step', $header->mesReviewIssueView->wip_step)
            ->first();

        $formYear = Carbon::parse($header->issue_date)->format('Y');
        $formDate = Carbon::parse($header->issue_date)->format('d-m');

        $year = (int) $formYear + 543;
        $date = (string) $formDate . "-" . $year;
        $date = date('d-m-Y', strtotime($date));
        $wipStepDesc = null;



        if (getDefaultData('/pm/wip-issue')->organization_code == 'M02') {
            $blendNo    = $header->mesReviewIssueVHasBlend->blend_no;
            $blend      = $header->mesReviewIssueVHasBlend;
            $blendUom   = $header->mesReviewIssueVHasBlend->uom;
            $itemNumber = $header->mesReviewIssueVHasBlend->item_number;
        } else {
            $blendNo    = $header->mesReviewIssueView->blend_no;
            $blend      = $header->mesReviewIssueView;
            $blendUom   = $header->mesReviewIssueView->uom;
            $itemNumber = $header->mesReviewIssueView->item_number;
        }

        if ($header->program_code == 'PMP0051') {
            $batchV = PtmpProductBatchV::where('organization_id', auth()->user()->organization_id)
                ->where('wip_step', $header->wip_step)
                ->where('batch_no', $header->batch_no)
                ->whereDate('transaction_date', $header->issue_date)
                ->with('manufactureStep')
                ->first();
            // dd($batchV->manufactureStep, $wip );
            // dd($batchV->wip_id, $batchV->manufactureStep);
            if ($batchV->manufactureStep) {
                $wipStepDesc = $batchV->manufactureStep->wip_step_desc;
            } else {
                $wipStepDesc = $wip->wip_step_desc;
            }
        }

        if ($blend) {
            $freezeBatch = (new \App\Repositories\PM\CommonRepository)->freezeBatchStatus($blend->batch_no);
            $blend->is_freeze_flag = $freezeBatch->is_freeze_flag;
            $blend->freeze_msg = $freezeBatch->freeze_msg;
            $blend->freeze_flag_date = $freezeBatch->freeze_flag_date;
        }

        //================ TEST FREEZE ========================
        // if(getDefaultData('/pm/wip-issue')->organization_code == 'M02'){
        //     $blend->is_freeze_flag = "";
        //     $blend->freeze_msg ="";
        //     $blend->freeze_flag_date = "";
        // }


        $header =   [
            'request_number'    => $header->request_number,
            'issue_header_id'   => $header->issue_header_id,
            'status'            => $header->issueStatus->description,
            'department_code'   => $header->department_code,
            'batch_no'          => $header->batch_no,
            'issue_date'        => date('d/m/Y', strtotime($header->issue_date)),
            'complete_date'     => date('d/m/Y', strtotime($header->complete_date)),
            'report_date'       => date('Y-m-d', strtotime($header->complete_date)),
            'show_date_th'      => $date,
            'blend_no'          => $blendNo,
            'blend'             => $blend,
            'batch_id'          => $header->batch_id,
            'blend_uom'         => $blendUom,
            'wip'               => $wip ?? "",
            'opt_plan_qty'      => $header->opt_plan_qty,
            'total_qty'         => $header->childHeaders
                ? $header->childHeaders->sum('opt_plan_qty') + $header->opt_plan_qty
                : $header->opt_plan_qty,
            'opt'               => $header->opt,
            'interface_status'  => $header->interface_status,
            'child_headers'     => $header->childHeaders,
            'all_opt'           => $header->childHeaders->count() > 0
                ? true
                : false,
            'badge_status'      => $header->badgeStatus(),
            'item_number'       => $itemNumber,
            'wip_step'          => $header->wip_step,
            'wip_step_desc'     => $wipStepDesc,
            'issue_status'      => $header->issue_status,
        ];

        return response()->json([
            'header' => $header
        ]);
    }


    public function checkPeriod($date)
    {
        //     $productBatchV =  PtmpProductBatchV::where('batch_status', 'WIP')
        //                         ->where;
    }

    public function setLines($lines , $request)
    {
        // $lines = $lines->sortBy('ptctMfgFormula.item_cat_code')
        //                 ->sortBy('ptctMfgFormula.item_number');
        foreach ($lines   as $line) {
            $formula = $line->ptctMfgFormula;
            if (!$formula) {
                $formula = $line->mfgFormula;
            }

            if (!$formula) {
                continue;
            }

                $onHandQty = $formula->getOnhand()->count()  > 0
                            ? $formula->getOnhand()->first()->onhand_quantity
                            : 0;

                // $sumQ               =  $formula->itemConvUom()
                //                     ?  $formula->itemConvUom()->conversion_rate * $request['total_opt_quantity'] * $formula->ratio_qty_per_unit
                //                     :  $request['total_opt_quantity'] * $formula->ratio_qty_per_unit;
                $sumQ               =   $request['total_opt_quantity'] * $formula->ratio_qty_per_unit;

                // if( $formula->reference_item_number != null ){
                //     $groupLine = $formula->taxItem->formulaline_id.$formula->taxItem->leaf_fomula . '-1';
                //     $leafFormula = $formula->taxItem->leaf_fomula ?? $formula->taxItem->leaf_formula;
                //     $msgOnhandText  = $this->checkOnhandTex($formula);
                //     if($line->lot_number){
                //         $checkOnhand = $formula->getOnhand()->where('lot_number', $line->lot_number)->first();
                //         if($checkOnhand){
                //             $onHandQty = $checkOnhand->onhand_quantity;
                //         }
                //     }
                // } else {
                //     $groupLine = $formula->formulaline_id . $formula->leaf_fomula;
                //     $leafFormula = $formula->leaf_fomula ?? $formula->leaf_formula;
                //     $msgOnhandText = "";
                //     // $lotNumber =  $line->lot_number;
                // }

                if($line->lot_number){
                    $checkOnhand = $formula->getOnhand()->where('lot_number', $line->lot_number)->first();
                    if($checkOnhand){
                        $onHandQty = $checkOnhand->onhand_quantity;
                    }
                }
                $sumQ               =  $formula->itemConvUom()
                                        ?  $formula->itemConvUom()->conversion_rate * $request['total_opt_quantity'] * $formula->ratio_qty_per_unit
                                        :  $request['total_opt_quantity'] * $formula->ratio_qty_per_unit;


                $confirmQty = $line->confirm_qty;
                if($formula->reference_item_number != null){
                    $groupLine = $formula->taxItem->formulaline_id.$formula->taxItem->leaf_fomula .$formula->taxItem->casting_flavor_name. '-1';
                    $leafFormula = $formula->taxItem->leaf_fomula ?? $formula->taxItem->leaf_formula;
                    // $msgOnhandText  = $this->checkOnhandTex($formula);
                    

                    if($checkOnhand){
                        $onHandQty = $checkOnhand->onhand_quantity;
                    } else {
                        $onHandQty =0;
                        $confirmQty=0;
                    } 

                } else {
                    // dd('xxxx');
                    $msgOnhandText = "";
                    $groupLine = $formula->formulaline_id . $formula->leaf_fomula.$formula->casting_flavor_name;
                    $leafFormula = $formula->leaf_fomula ?? $formula->leaf_formula;
                    if($line->lot_number){

                        $checkOnhand = $formula->getOnhand()
                                ->where('lot_number', $line->lot_number)
                                ->first();

                    }
                }

                if(request()->program_code == 'PMP0048'){
                    $groupLine = $formula->group_line;
                }

                $linesV[] = $line->formulaline_id = [
                    'group_line'                => $groupLine,
                    'casting_flavor_name'       => $formula->casting_flavor_name,
                    'formulaline_id'            => $formula->formulaline_id,
                    'leaf_formula'              => $leafFormula,
                    'used_leaf_formula'         => $formula->used_leaf_formula,
                    'item_number'               => $formula->item_number,

                    'product_detail_uom'        => $formula->product_detail_uom,
                    'product_unit_of_measure'   => $line->uom->unit_of_measure  ?? $formula->product_unit_of_measure,
                    'from_subinventory'         => $line->subinventory_code,
                    'from_location_code'        => $formula->setupMfgDeptVLByUserOrg->from_location_code,
                    'default_lot_no'            => $line->lot_number,
                    'expiration_date'           => $line->expiration_date,
                    'line_quantity'             => $line->interface_status != null ? $line->attribute15 : $onHandQty,
                    'onhand_quantity'           => $onHandQty,
                    'onhand_quantity_display'   => $onHandQty,
                    'quantity_summary'          => $sumQ,
                    'input_quantity_summary'    => $line->confirm_qty,
                    'item_desc'                 => $formula->item_desc,
                    'interface_status'          => $line->interface_status,
                    'onhand_lists'              => $formula->getOnhand(),
                    'line_disabled'             => false,
                    'last_line'                 => false,
                    'tobacco_ingrident_type'    => $formula->tobacco_ingrident_type,
                    'new_key'                   => 0,
                    'header_interface_status'   => $line->header->issue_status == '2' ? 'S' : $line->header->interface_status,
                    'reference_item_number'     => $formula->reference_item_number,
                    'item_cat_code'             => $formula->item_cat_code,
                    'msg_onhand_tax'            => $msgOnhandText,
                    'line_id'                   => $line->issue_line_id,
                ];
            }
            // dd($linesV);
        return $linesV;
    }

    public function updateTaxFormula($lines)
    {
        // dd();
        if(count($lines) == 0){
            return ;
        }
        foreach ($lines as $key => $line) {
            $parentLine = PtpmMesReviewIssueLines::where('formulaline_id', $line->attribute10)
                            ->where('issue_header_id', $line->issue_header_id)
                            ->first();
            // dd($parentLine );
            $line->lot_number   = $parentLine->lot_number;
            $line->confirm_qty  = $parentLine->confirm_qty;
            $line->attribute12  = $parentLine->attribute12;
            $line->attribute15  = $parentLine->attribute15;
            $line->leaf_formula = $parentLine->leaf_formula;
            $line->save();
        }

        return $lines;

    }


    public function checkOnhandTex($formula)
    {

        return '';
        // if(!$formula->getOnhand()){
        //     return 'Item tax No Onhand..';
        // }

        // if(){

        // }

    }

    public function setLinesPmp0049($lines)
    {
        // $lines = PtpmMesReviewIssueLines::where('issue_header_id', request()->issue_header_id)->get();
        $linesV = [];
        $dataSummaryQty = false;
        foreach ($lines   as $key => $line) {

            $onhands =  $line->mfgFormula->getOnhand();
            $uOnhand = 0;
            if (!$onhands->first()) {
                $uOnhand  = $onhands->first() ? $onhands->first()->onhand_quantity : 0;
            }

            $request = [
                'oprn_no' => $line->header->wip_step,
                'blend_no' =>  $line->header->batch_no,
            ];
            $date = date('d-M-Y', strtotime($line->header->complete_date));
            $mfgFormula = $line->mfgFormula ? $line->mfgFormula : new PtctMfgFormulaV;

            if ($key == 0) {
                $dataSummaryQty = (new WipIssueRequestRepository)->getReqFml($request, $date);
            }
            $summaryQty =  (new WipIssueRequestRepository)->summaryQty($request, $mfgFormula, $date, $dataSummaryQty);
            $linesV[] = $line->formulaline_id = [
                'casting_flavor_name'       => $mfgFormula->casting_flavor_name,
                'formulaline_id'            => $mfgFormula->formulaline_id,
                'leaf_formula'              => $mfgFormula->leaf_fomula ?? $mfgFormula->leaf_formula,
                'used_leaf_formula'         => $mfgFormula->used_leaf_formula,
                'item_number'               => $mfgFormula->item_number,
                'item_desc'                 => $mfgFormula->item_desc,
                'product_detail_uom'        => $line->confirm_uom_code,
                'product_unit_of_measure'   => $line->uom->unit_of_measure  ?? $mfgFormula->product_unit_of_measure,
                'item_desc'                 => $mfgFormula->item_desc,
                // 'formula_uom'               =>
                'from_subinventory'         => $line->subinventory_code,
                'from_location_code'        => $line->organization_code,
                'default_lot_no'            => $line->lot_number,
                'expiration_date'           => $line->expiration_date,
                'line_quantity'             => $onhands->where('lot_number', $line->lot_number)->first()
                                                ? $onhands->where('lot_number', $line->lot_number)->first()->onhand_quantity
                                                : $uOnhand,
                'onhand_quantity'           => $onhands->where('lot_number', $line->lot_number)->first()
                                                ? $onhands->where('lot_number', $line->lot_number)->first()->onhand_quantity
                                                : $line->attribute15,
                'quantity_summary'          => $summaryQty,
                'input_quantity_summary'    => $line->confirm_qty * 1,
                'item_desc'                 => $mfgFormula->item_desc,
                'interface_status'          => $line->interface_status,
                'onhand_lists'              => $mfgFormula->getOnhand(),
                'line_disabled'             => false,
                'last_line'                 => false,
                'tobacco_ingrident_type'    => $mfgFormula->tobacco_ingrident_type,
                'new_key'                   => 0,
                'header_interface_status'   => $line->header->interface_status,
                'line_id'                   => $line->issue_line_id,
            ];
        }

        return $linesV;
    }

    public function setLinesPmp0051($lines)
    {
        $linesV = [];
        foreach ($lines   as $line) {
                $onhands = $line->mfgFormula 
                    ?  $line->mfgFormula->getOnhand() 
                    :  new PtinvOnhandQuantitiesV;
                $line->mfgFormula;
                $uOnhand = 0;
                if (count($onhands) == 0) {
                    $onhands = collect([]);
                }
                if (!$onhands->first()) {
                    $uOnhand  = $onhands->first() ? $onhands->first()->onhand_quantity : 0;
                }

            $request = [
                'oprn_no' => $line->header->wip_step,
                'blend_no' =>  $line->header->batch_no,
            ];

            $date = date('d-M-Y', strtotime($line->header->complete_date));
            $mfgFormula = $line->mfgFormula ? $line->mfgFormula : new PtctMfgFormulaV;
            $summaryQty = (float)request()->total_opt_quantity * $mfgFormula->ratio_qty_per_unit;

            $linesV[] = $line->formulaline_id = [
                'casting_flavor_name'       => $mfgFormula->casting_flavor_name,
                'formulaline_id'            => $mfgFormula->formulaline_id,
                'leaf_formula'              => $mfgFormula->leaf_fomula ?? $mfgFormula->leaf_formula,
                'used_leaf_formula'         => $mfgFormula->used_leaf_formula,
                'item_number'               => $mfgFormula->item_number,
                'item_desc'                 => $mfgFormula->item_desc,
                'product_detail_uom'        => $line->confirm_uom_code,
                // 'product_unit_of_measure'   => $mfgFormula->th_detail_unit_of_measure,
                'product_unit_of_measure'   => $line->uom->unit_of_measure  ?? $mfgFormula->product_unit_of_measure,
                // $line->uom->unit_of_measure ?? $formula->product_unit_of_measure
                'item_desc'                 => $mfgFormula->item_desc,
                'from_subinventory'         => $line->subinventory_code,
                'from_location_code'        => $line->organization_code,
                'default_lot_no'            => $line->lot_number,
                'expiration_date'           => $line->expiration_date,
                'line_quantity'             => $onhands->where('lot_number', $line->lot_number)->first()
                                                ? $onhands->where('lot_number', $line->lot_number)->first()->onhand_quantity
                                                : $uOnhand,
                'onhand_quantity'           => $onhands->where('lot_number', $line->lot_number)->first()
                                                ? $onhands->where('lot_number', $line->lot_number)->first()->onhand_quantity
                                                : $line->attribute15,
                'quantity_summary'          => $summaryQty,
                'input_quantity_summary'    => $line->confirm_qty * 1,
                'item_desc'                 => $mfgFormula->item_desc,
                'interface_status'          => $line->interface_status,
                'onhand_lists'              => $mfgFormula->getOnhand(),
                'line_disabled'             => false,
                'last_line'                 => false,
                'tobacco_ingrident_type'    => $mfgFormula->tobacco_ingrident_type,
                'new_key'                   => 0,
                'header_interface_status'   => $line->header->interface_status,
            ];
        }
        return $linesV;
    }

    public function setLinesPmp0059($lines)
    {
        // $lines = PtpmMesReviewIssueLines::where('issue_header_id', request()->issue_header_id)->get();
        $linesV = [];
        $dataSummaryQty = false;
        foreach ($lines   as $key => $line) {

            $onhands =  $line->mfgFormula->getOnhand();
            $uOnhand = 0;
            if (!$onhands->first()) {
                $uOnhand  = $onhands->first() ? $onhands->first()->onhand_quantity : 0;
            }

            $request = [
                'oprn_no' => $line->header->wip_step,
                'blend_no' =>  $line->header->batch_no,
            ];
            $date = date('d-M-Y', strtotime($line->header->complete_date));
            $mfgFormula = $line->mfgFormula ? $line->mfgFormula : new PtctMfgFormulaV;

            if ($key == 0) {
                $dataSummaryQty = (new WipIssueRequestRepository)->getReqFml($request, $date);
            }
            $summaryQty =  (new WipIssueRequestRepository)->summaryQty($request, $mfgFormula, $date, $dataSummaryQty);
            $linesV[] = $line->formulaline_id = [
                'casting_flavor_name'       => $mfgFormula->casting_flavor_name,
                'formulaline_id'            => $mfgFormula->formulaline_id,
                'leaf_formula'              => $mfgFormula->leaf_fomula ?? $mfgFormula->leaf_formula,
                'used_leaf_formula'         => $mfgFormula->used_leaf_formula,
                'item_number'               => $mfgFormula->item_number,
                'item_desc'                 => $mfgFormula->item_desc,
                'product_detail_uom'        => $line->confirm_uom_code,
                'product_unit_of_measure'   => $line->uom->unit_of_measure  ?? $mfgFormula->product_unit_of_measure,
                'item_desc'                 => $mfgFormula->item_desc,
                // 'formula_uom'               =>
                'from_subinventory'         => $line->subinventory_code,
                'from_location_code'        => $line->organization_code,
                'default_lot_no'            => $line->lot_number,
                'expiration_date'           => $line->expiration_date,
                'line_quantity'             => $onhands->where('lot_number', $line->lot_number)->first()
                                                ? $onhands->where('lot_number', $line->lot_number)->first()->onhand_quantity
                                                : $uOnhand,
                'onhand_quantity'           => $onhands->where('lot_number', $line->lot_number)->first()
                                                ? $onhands->where('lot_number', $line->lot_number)->first()->onhand_quantity
                                                : $line->attribute15,
                'quantity_summary'          => $summaryQty,
                'input_quantity_summary'    => $line->confirm_qty * 1,
                'item_desc'                 => $mfgFormula->item_desc,
                'interface_status'          => $line->interface_status,
                'onhand_lists'              => $mfgFormula->getOnhand(),
                'line_disabled'             => false,
                'last_line'                 => false,
                'tobacco_ingrident_type'    => $mfgFormula->tobacco_ingrident_type,
                'new_key'                   => 0,
                'header_interface_status'   => $line->header->interface_status,
                'line_id'                   => $line->issue_line_id,
            ];
        }

        return $linesV;
    }

    public function getWipStepListForIssue()
    {
        $data = OpmRoutingV::where('owner_organization_id', session('organization_id'))
                ->active()
                ->isWipIssue()
                ->get();

        return $data;
    }
}
