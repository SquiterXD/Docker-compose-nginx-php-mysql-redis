<?php

namespace App\Http\Controllers\PM\Api;

use App\Models\PM\PtpmJobWipStep;

use App\Models\PM\PtpmOpmRoutingV;
use App\Models\PM\PtpmProductBatchV;
use App\Models\PM\PtpmProductHeader;
use App\Models\PM\PtpmProductLine;
use App\Models\PM\PtpmSummaryBatchV;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\PM\Settings\SetupLayoutsV;
use Carbon\Carbon;

use App\Models\PM\PtpmProductTransferL;

class PM0031ApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $profile = getDefaultData('/pm/0031');
        $user = auth()->user();

        $batchId = $request->get('batch_id');
        $productDate = $request->get('product_date');
        $wipStep = $request->get('wip_step');

        $userId = optional(auth()->user())->user_id ?? -1;
        $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
        $departmentCode = optional(auth()->user())->department_code;
        $organizationId = optional(auth()->user())->organization_id;

        $header = null;
        $receiveWipHeader = null;
        $previousWipHeader = null;
        
        $lines = [];
        $receiveWipLines = [];
        $previousWipLines = [];
        $setupLayout = (object) [];
        $setupLayout->is_convers_set_layout = false;
        $setupLayout->data = false;

        if ($batchId && $productDate && $wipStep) {

            $headerBuilder = PtpmProductHeader::where("organization_id", $organizationId);
            if ($batchId) $headerBuilder->where('batch_id', $batchId);
            $headerBuilder->where('wip_step', $wipStep);
            $headerBuilder->whereDate('product_date', parse_from_date_th($productDate));
            $header = $headerBuilder->first();
            if($header) {
                $lines = PtpmProductLine::where("product_header_id", $header->product_header_id)->get();
            }

            // $receiveWipHeaderBuilder = PtpmProductHeader::where("organization_id", $organizationId);
            // if ($batchId) $receiveWipHeaderBuilder->where('batch_id', $batchId);
            // $receiveWipHeaderBuilder->where('wip_step', $wipStep);
            // $receiveWipHeaderBuilder->whereDate('product_date', date("Y-m-d", strtotime("-1 day", strtotime(parse_from_date_th($productDate)))));
            // $receiveWipHeader = $receiveWipHeaderBuilder->first();
            $receiveWipHeader = $this->getReceiveWipHeaderBuilder(
                                    $organizationId,
                                    $batchId,
                                    $wipStep,
                                    parse_from_date_th($productDate)
                                );
            if ($receiveWipHeader) {
                $receiveWipLines = PtpmProductLine::where("product_header_id", $receiveWipHeader->product_header_id)->get();
            }

            $previousWipStep = self::getPreviousWipStep($organizationId, $batchId, $wipStep);
            if($previousWipStep) {
                $previousWipHeaderBuilder = PtpmProductHeader::where("organization_id", $organizationId);
                if ($batchId) $previousWipHeaderBuilder->where('batch_id', $batchId);
                $previousWipHeaderBuilder->where('wip_step', $previousWipStep);
                $previousWipHeaderBuilder->whereDate('product_date', date("Y-m-d", strtotime(parse_from_date_th($productDate))));
                $previousWipHeader = $previousWipHeaderBuilder->first();
                if ($previousWipHeader) {
                    $previousWipLines = PtpmProductLine::where("product_header_id", $previousWipHeader->product_header_id)->get();
                }

            }

            $batchV = PtpmProductBatchV::whereNotNull('batch_no')
                ->where('batch_id', $batchId)
                ->first();
            if ($batchV && $productDate && $request->wip_step == 'WIP01') {
                $productDateTh = parse_from_date_th($productDate);
                $productDateTh = Carbon::parse($productDateTh)->format("Y-m-d");
                $setupLayoutData = SetupLayoutsV::whereRaw("TRUNC(to_date('{$productDateTh}', 'YYYY-MM-DD')) BETWEEN TRUNC(start_date) and TRUNC(nvl(end_date, sysdate)) ")
                                ->where('inventory_item_id', $batchV->inventory_item_id)
                                ->orderBy('layout_id', 'desc')
                                ->first();

                if (($profile->organization_code == 'M06') ) {
                    $setupLayout->is_convers_set_layout = true;
                    if ($setupLayoutData) {
                        $setupLayout->data = $setupLayoutData;
                    }
                }
            }

        }

        $preparedHeader = null;
        if($header) {
            $preparedHeader = [];
            $preparedHeader = $header->toArray();
            $preparedHeader['item_no'] = $header->attribute10;
            $preparedHeader['item_desc'] = $header->attribute11;
        }

        $preparedReceiveWipHeader = null;
        if ($receiveWipHeader) {
            $preparedReceiveWipHeader = [];
            $preparedReceiveWipHeader = $receiveWipHeader->toArray();
            $preparedReceiveWipHeader['item_no'] = $receiveWipHeader->attribute10;
            $preparedReceiveWipHeader['item_desc'] = $receiveWipHeader->attribute11;
        }

        $preparedPreviousWipHeader = null;
        if ($previousWipHeader) {
            $preparedPreviousWipHeader = [];
            $preparedPreviousWipHeader = $previousWipHeader->toArray();
            $preparedPreviousWipHeader['item_no'] = $previousWipHeader->attribute10;
            $preparedPreviousWipHeader['item_desc'] = $previousWipHeader->attribute11;
        }

        $preparedLines = [];
        foreach($lines as $index => $line) {

            $line->set_layout = '';
            $line->is_convers_set_layout = false;
            if ($setupLayout->is_convers_set_layout) {
                $setupLayout->custom_uom_name = optional($setupLayout->data)->custom_uom_name ?? '';
                $productQty = optional($setupLayout->data)->layout_qty ?? 1;
                $line->set_layout = optional($setupLayout)->data ?? false;
                $line->is_convers_set_layout = optional($setupLayout->data)->is_convers_set_layout;
                // $line->product_qty = ($line->product_qty) ? $line->product_qty / $setupLayout->layout_qty : 0;
                // $line->transfer_qty = ($line->transfer_qty) ? $line->transfer_qty / $setupLayout->layout_qty : 0;

                // $line->receive_wip      = ($line->receive_wip) ? $line->receive_wip / $productQty : 0;
                // $line->transfer_wip     = ($line->transfer_wip) ? $line->transfer_wip / $productQty : 0;
                // $line->product_qty      = ($line->product_qty) ? $line->product_qty / $productQty : 0;
                // $line->loss_qty         = ($line->loss_qty) ? $line->loss_qty / $productQty : 0;
                // $line->transfer_qty     = ($line->transfer_qty) ? $line->transfer_qty / $productQty : 0;
            }


            $preparedLines[$index] = $line->toArray();
            $preparedLines[$index]['item_no'] = $line->attribute10;
            $preparedLines[$index]['item_desc'] = $line->attribute11;
        }

        $preparedReceiveWipLines = [];
        foreach($receiveWipLines as $index => $receiveWipLine) {
            $preparedReceiveWipLines[$index] = $receiveWipLine->toArray();
            $preparedReceiveWipLines[$index]['item_no'] = $receiveWipLine->attribute10;
            $preparedReceiveWipLines[$index]['item_desc'] = $receiveWipLine->attribute11;


            $layout = $this->checkLayout($receiveWipLine->product_line_id);
            if ($layout) {
                $layoutQty = optional($layout)->layout_qty ?? 1;
                $receiveWip = data_get($preparedReceiveWipLines, "$index.receive_wip") ?? 0;
                $productQty = data_get($preparedReceiveWipLines, "$index.product_qty") ?? 0;
                $lossQty = data_get($preparedReceiveWipLines, "$index.loss_qty") ?? 0;
                $transferQty = data_get($preparedReceiveWipLines, "$index.transfer_qty") ?? 0;
                $transferWip = data_get($preparedReceiveWipLines, "$index.transfer_wip") ?? 0;

                data_set($preparedReceiveWipLines, "$index.receive_wip",    $receiveWip     ? $receiveWip  : 0);
                data_set($preparedReceiveWipLines, "$index.product_qty",    $productQty     ? $productQty  : 0);
                data_set($preparedReceiveWipLines, "$index.loss_qty",       $lossQty        ? $lossQty  : 0);
                data_set($preparedReceiveWipLines, "$index.transfer_qty",   $transferQty    ? $transferQty  : 0);
                data_set($preparedReceiveWipLines, "$index.transfer_wip",   $transferWip    ? $transferWip  : 0);
            }
        }

        if (count($preparedLines) == 0 && $batchId && $productDate && $wipStep && false) {
            $getBatch = PtpmSummaryBatchV::where('batch_id', $batchId)->first();
            $defaultTransferQty = 0;
            if ($profile->organization_code == 'MPG' && $getBatch) {
                $wipList = self::getListWipSteps(data_get($getBatch, 'organization_id'), data_get($getBatch, 'batch_id'));
                $maxWip = $wipList->sortByDesc('wip_step')->first();

                if ($wipStep == $maxWip->wip_step) {
                    $pmp0041 = PtpmProductTransferL::where('inventory_item_id', data_get($getBatch, 'inventory_item_id'))
                                ->whereHas('header', function ($query) use ($getBatch, $productDate) {
                                    $query->whereDate('product_date', parseFromDateTh($productDate))
                                        ->where('organization_id', data_get($getBatch, 'organization_id'))
                                        ->where('transfer_status', 2) // ส่งข้อมูลสำเร็จ
                                        ->where('program_code', 'PMP0041');
                                })
                                ->where('program_code', 'PMP0041')
                                ->sum('transaction_qty');
                    $defaultTransferQty = $pmp0041 ?? 0;
                }
            }

            if ($defaultTransferQty > 0) {
                $preparedLines[0]['receive_wip'] = 0;
                $preparedLines[0]['product_qty'] = 0;
                $preparedLines[0]['loss_qty'] = 0;
                $preparedLines[0]['transfer_qty'] = $defaultTransferQty;
                $preparedLines[0]['transfer_wip'] = 0;
                $preparedLines[0]['item_no'] = data_get($preparedHeader, 'item_no');
                $preparedLines[0]['item_desc'] = data_get($preparedHeader, 'item_desc');
            }
        }

        $preparedPreviousWipLines = [];
        foreach($previousWipLines as $index => $previousWipLine) {
            $preparedPreviousWipLines[$index] = $previousWipLine->toArray();
            $preparedPreviousWipLines[$index]['item_no'] = $previousWipLine->attribute10;
            $preparedPreviousWipLines[$index]['item_desc'] = $previousWipLine->attribute11;
            $layout = $this->checkLayout(data_get($preparedPreviousWipLines[$index], 'product_line_id'));
            if ($layout) {
                $layoutQty = optional($layout)->layout_qty ?? 1;
                $transferQty = data_get($preparedPreviousWipLines, "$index.transfer_qty") ?? 0;
                data_set($preparedPreviousWipLines, "$index.transfer_qty",      $transferQty    ? $transferQty * $layoutQty : 0);
            }
        }

        if ($preparedHeader) {
            $startDateFormatted = data_get($preparedHeader, 'start_date') ? parseToDateTh(data_get($preparedHeader, 'start_date')) : null;
            $endDateFormatted = data_get($preparedHeader, 'end_date') ? parseToDateTh(data_get($preparedHeader, 'end_date')) : null;
            data_set($preparedHeader, 'start_date_formatted', $startDateFormatted);
            data_set($preparedHeader, 'end_date_formatted', $endDateFormatted);
        }

        return response()->json([

            'header'                => $preparedHeader,
            'receive_wip_header'    => $preparedReceiveWipHeader,
            'previous_wip_header'   => $preparedPreviousWipHeader,

            'lines'                 => $preparedLines,
            'receive_wip_lines'     => $preparedReceiveWipLines,
            'previous_wip_lines'    => $preparedPreviousWipLines,
            'setup_layout'          => $setupLayout,

        ]);

    }

    public function getListBatchHeaders(Request $request): JsonResponse
    {
        $user = auth()->user();

        $userId = optional(auth()->user())->user_id ?? -1;
        $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
        $departmentCode = optional(auth()->user())->department_code;
        $organizationId = optional(auth()->user())->organization_id;

        $listBatchHeaders = [];
            
        $listBatchHeaders = PtpmProductBatchV::select(DB::raw("batch_no || ' : ' || item_desc as batch_full_desc, organization_id, batch_no, batch_id, inventory_item_id, item_no, item_desc, actual_start_date, wip_step"))
            ->whereNotNull('batch_no')
            ->where('organization_id', $organizationId)
            ->forUserProcess()
            ->orderBy('batch_no')
            ->distinct()
            // ->where('batch_id', 187752)
            ->get();

        return response()->json([
            'batch_header_list'      => $listBatchHeaders,
        ]);

    }

    public function getBatches(Request $request): JsonResponse
    {
        $user = auth()->user();

        $batchId = $request->get('batch_id');

        $userId = optional(auth()->user())->user_id ?? -1;
        $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
        $departmentCode = optional(auth()->user())->department_code;
        $organizationId = optional(auth()->user())->organization_id;

        $batchHeader = null;
        $batchLines = [];

        if ($batchId) {
            
            $queryBuilder = PtpmProductBatchV::where('organization_id', $organizationId);
            if ($batchId) $queryBuilder->where('batch_id', $batchId);
            // $queryBuilder->whereDate('product_date', parse_from_date_th($productDate));
            
            $batchHeader = $queryBuilder->getHeader()->first();
            $batchLines = $queryBuilder->get();

        }

        if ($batchHeader) {
            $startDateFormatted = data_get($batchHeader, 'start_date') ? parseToDateTh(data_get($batchHeader, 'start_date')) : null;
            $endDateFormatted = data_get($batchHeader, 'end_date') ? parseToDateTh(data_get($batchHeader, 'end_date')) : null;
            data_set($batchHeader, 'start_date_formatted', $startDateFormatted);
            data_set($batchHeader, 'end_date_formatted', $endDateFormatted);
        }

        return response()->json([
            'batch_header'      => $batchHeader,
            'batch_lines'       => $batchLines,
        ]);

    }

    public function getWipSteps(Request $request): JsonResponse
    {
        $batchId = $request->get('batch_id');

        $user = auth()->user();
        $organizationId = $user->organization_id;

        // GET JOB_WIP_STEPS
        $preJobWipSteps = self::getListWipSteps($organizationId, $batchId);

        $jobWipSteps = [];
        foreach($preJobWipSteps as $index => $preJobWipStep) {
            $jobWipSteps[$index] = $preJobWipStep->toArray();
            // $jobWipSteps[$index]["wip_step"] = $preJobWipStep->oprn_class_desc;
            // $jobWipSteps[$index]["wip_step_desc"] = $preJobWipStep->oprn_desc;
        }

        return response()->json([
            'job_wip_steps'     => $jobWipSteps,
        ]);

    }

    public static function getListWipSteps($organizationId, $batchId) {

        // GET JOB_WIP_STEPS

        $jobWipSteps = [];

        // $jobWipSteps = PtpmOpmRoutingV::query()
        //     ->select(['owner_organization_id', 'organization_code', 'oprn_class_desc', 'oprn_desc'])
        //     ->where('owner_organization_id', $organizationId)
        //     ->where('oprn_no', 'like', '%WIP%')
        //     ->distinct()
        //     ->orderBy('oprn_class_desc')
        //     ->get();
        
        if($batchId) {

            $jobWipSteps = PtpmJobWipStep::query()
                // ->select(['batch_id', 'wip_id', 'wip_step', 'wip_step_desc'])
                ->selectRaw("batch_id, wip_id, wip_step, wip_step_desc, wip_step || ' : ' || wip_step_desc as label")
                ->where('batch_id', $batchId)
                ->distinct()
                ->orderBy('wip_step')
                ->get();

        }

        return $jobWipSteps;

    }

    public static function getPreviousWipStep($organizationId, $batchId, $wipStep) {

        $previousWipStep = null;
        $wipStepIndex = 0;

        // GET JOB_WIP_STEPS
        $preJobWipSteps = self::getListWipSteps($organizationId, $batchId);

        $jobWipSteps = [];
        foreach($preJobWipSteps as $index => $preJobWipStep) {
            $jobWipSteps[$index] = $preJobWipStep->toArray();
            // $jobWipSteps[$index]["wip_step"] = $preJobWipStep->oprn_class_desc;
            // $jobWipSteps[$index]["wip_step_desc"] = $preJobWipStep->oprn_desc;
            if($preJobWipStep->wip_step == $wipStep) {
                $wipStepIndex = $index;
            }
        }

        if($wipStepIndex > 0) {
            $previousWipStep = $jobWipSteps[$wipStepIndex - 1]["wip_step"];
        }

        return $previousWipStep;

    }

    public static function getNextWipStep($organizationId, $batchId, $wipStep) {

        $nextWipStep = null;
        $wipStepIndex = 0;

        // GET JOB_WIP_STEPS
        $preJobWipSteps = self::getListWipSteps($organizationId, $batchId);

        $jobWipSteps = [];
        foreach($preJobWipSteps as $index => $preJobWipStep) {
            $jobWipSteps[$index] = $preJobWipStep->toArray();
            // $jobWipSteps[$index]["wip_step"] = $preJobWipStep->oprn_class_desc;
            // $jobWipSteps[$index]["wip_step_desc"] = $preJobWipStep->oprn_desc;
            if($preJobWipStep->wip_step == $wipStep) {
                $wipStepIndex = $index;
            }
        }
        $lastIndex = count($preJobWipSteps) - 1;
        if($lastIndex > $wipStepIndex) {
            $nextWipStep = $jobWipSteps[$wipStepIndex + 1]["wip_step"];
        }

        return $nextWipStep;

    }

    public static function getLastWipStep($organizationId, $batchId, $wipStep) {

        $LastWipStep = null;

        // GET JOB_WIP_STEPS
        $preJobWipSteps = self::getListWipSteps($organizationId, $batchId);

        $jobWipSteps = [];
        foreach($preJobWipSteps as $index => $preJobWipStep) {
            $jobWipSteps[$index] = $preJobWipStep->toArray();
            // $jobWipSteps[$index]["wip_step"] = $preJobWipStep->oprn_class_desc;
            // $jobWipSteps[$index]["wip_step_desc"] = $preJobWipStep->oprn_desc;
        }

        $lastIndex = count($preJobWipSteps) - 1;
        $LastWipStep = $jobWipSteps[$lastIndex]["wip_step"];

        return $LastWipStep;

    }

    public function search(Request $request)
    {
        $user = auth()->user();
        $userId = optional(auth()->user())->user_id ?? -1;
        $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;

        $departmentCode = optional(auth()->user())->department_code;
        $organizationId = optional(auth()->user())->organization_id;

        $profile = getDefaultData('/pm/0031');

        // organization_code
        // dd('xx', $profile);

        $batchNo = $request->get('batch_no');
        $itemNo = $request->get('item_no');
        $wipStep = $request->get('wip_step');
        $productDateFrom = $request->get('product_date_from_formatted');
        $productDateTo = $request->get('product_date_to_formatted');
        $startDateFrom = $request->get('start_date_from_formatted');
        $startDateTo = $request->get('start_date_to_formatted');
        // $endDateFrom = $request->get('end_date_from_formatted');
        // $endDateTo = $request->get('end_date_to_formatted');
        // $productStatusQty = $request->get('product_status_qty');

        $headerBuilder = PtpmProductHeader::where("organization_id", $organizationId);

        // if ($departmentCode) $headerBuilder->where('department_code', $departmentCode);
        if ($batchNo) $headerBuilder->where('batch_no', 'like' ,'%'.$batchNo.'%');
        if ($itemNo) $headerBuilder->where('attribute10', $itemNo);
        if ($wipStep) $headerBuilder->where('wip_step', $wipStep);
        if ($productDateFrom) $headerBuilder->whereDate('product_date', '>=', parse_from_date_th($productDateFrom));
        if ($productDateTo) $headerBuilder->whereDate('product_date', '<=', parse_from_date_th($productDateTo));
        if ($startDateFrom) $headerBuilder->whereDate('start_date', '>=', parse_from_date_th($startDateFrom));
        if ($startDateTo) $headerBuilder->whereDate('start_date', '<=', parse_from_date_th($startDateTo));

        // if ($endDateFrom) $headerBuilder->whereDate('end_date', '>=', parse_from_date_th($endDateFrom));
        // if ($endDateTo) $headerBuilder->whereDate('end_date', '<=', parse_from_date_th($endDateTo));
        // if ($productStatusQty === 'isnotnull') $headerBuilder->whereNotNull('product_status_qty');
        // if ($productStatusQty === 'isnull') $headerBuilder->whereNull('product_status_qty');

        $preHeaders = $headerBuilder->whereNotNull('batch_no')
            // ->where('department_code', $departmentCode)
            ->where("organization_id", $organizationId);

        $uomSql = clone $preHeaders;
        $uomData = clone $preHeaders;
        $preHeaders = $preHeaders->orderBy('product_date', 'DESC')
            ->orderBy('wip_step')
            ->orderBy('batch_no')
            ->get();

        $uomDetail = collect([]);
        if ($uomData->selectRaw("distinct uom")->whereNotNull('uom')->count() > 0) {
            $uomSql = $uomSql->selectRaw("distinct uom")->whereNotNull('uom');
            $sql = vsprintf(str_replace('?', "'%s'", $uomSql->toSql()), $uomSql->getBindings());
            $uomDetail = \App\Models\PM\PtInvUomV::whereRaw("uom_code in ($sql)")->get();
        }

        $headers = [];
        foreach($preHeaders as $index => $preHeader) {
            $headers[$index] = $preHeader->toArray();
            $headers[$index]['product_date_formatted'] = parse_to_date_th($preHeader->product_date);
            $headers[$index]['item_no'] = $preHeader->attribute10;
            $headers[$index]['item_desc'] = $preHeader->attribute11;
            $uomDesc = optional(optional(optional($uomDetail)->where('uom_code', $preHeader->uom))->first())->unit_of_measure ?? '' ;

            $headers[$index]['custom_uom_code'] = '';
            $headers[$index]['custom_uom_name'] = '';
            $wipStep = $headers[$index]['wip_step'];
            if (($profile->organization_code == 'M06') && $wipStep == 'WIP01') {
                $productDate = Carbon::parse($preHeader->product_date)->format("Y-m-d");
                $setupLayoutData = SetupLayoutsV::whereRaw("TRUNC(to_date('{$productDate}', 'YYYY-MM-DD')) BETWEEN TRUNC(start_date) and TRUNC(nvl(end_date, sysdate)) ")
                                ->where('inventory_item_id', $preHeader->inventory_item_id)
                                ->orderBy('layout_id', 'desc')
                                ->first();
                $headers[$index]['uom_desc'] = optional($setupLayoutData)->custom_uom_name ?? '';
                $headers[$index]['custom_uom_code'] = optional($setupLayoutData)->custom_uom_code ?? '';
                $headers[$index]['custom_uom_name'] = optional($setupLayoutData)->custom_uom_name ?? '';

                if ($setupLayoutData) {
                    $productQty = optional($setupLayoutData)->layout_qty ?? 1;
                    $headers[$index]['product_qty'] = ($headers[$index]['product_qty']) ? $headers[$index]['product_qty'] : 0;
                }

            } else {
                $headers[$index]['uom_desc'] = $uomDesc;
            }
        }

        return response()->json([
            'headers' => $headers,
        ]);

    }

    public function save(Request $request)
    {
        $wipStep = $request->input('wip_step');

        $inputHeader = $request->input('header');
        $inputLines = $request->input('lines');

        $userId = optional(auth()->user())->user_id ?? -1;
        $fndUserId = optional(auth()->user())->fnd_user_id ?? -1;
        $departmentCode = optional(auth()->user())->department_code;
        $organizationId = optional(auth()->user())->organization_id;
        $nowDate = Carbon::now();

        DB::beginTransaction();

        try {

            // SAVE HEADER
            if ($inputHeader["product_header_id"]) {
                $productHeader = PtpmProductHeader::where('product_header_id', $inputHeader["product_header_id"])->first();
            } else {
                $productHeader = new PtpmProductHeader;
                $productHeader->created_by_id         = $userId;
                $productHeader->created_by            = $fndUserId;
            }

            $productHeader->batch_id                = $inputHeader['batch_id'];
            $productHeader->batch_no                = $inputHeader['batch_no'];
            $productHeader->blend_no                = $inputHeader['blend_no'];
            $productHeader->department_code         = $departmentCode;
            $productHeader->wip_step                = $wipStep;
            $productHeader->organization_id         = $inputHeader['organization_id'];
            $productHeader->inventory_item_id       = $inputHeader['inventory_item_id'];
            $productHeader->attribute10             = $inputHeader['item_no'];
            $productHeader->attribute11             = $inputHeader['item_desc'];
            $productHeader->uom                     = $inputHeader['uom'];
            $productHeader->request_qty             = $inputHeader['plan_qty'];
            // $productHeader->dtl_um                  = $inputHeader['dtl_um'];
            $productHeader->product_date            = parse_from_date_th($inputHeader['product_date_formatted']);
            // $productHeader->start_date              = parse_from_date_th($inputHeader['start_date_formatted']);
            // $productHeader->end_date                = parse_from_date_th($inputHeader['end_date_formatted']);
            $productHeader->start_date              = Carbon::parse($inputHeader['start_date'])->format("Y-m-d");
            $productHeader->end_date                = Carbon::parse($inputHeader['end_date'])->format("Y-m-d");
            $productHeader->product_qty             = (float)(str_replace(',', '', $inputHeader['product_qty']) ?? 0);
            $productHeader->updated_by_id           = $userId;
            $productHeader->last_updated_by         = $fndUserId;
            $productHeader->updated_at              = $nowDate;
            $productHeader->last_update_date        = $nowDate;

            $productHeader->save();            

            if($productHeader) {

                // SAVE LINES
                foreach ($inputLines as $inputLine) {

                    if ($inputLine["product_line_id"]) {
                        $productLine = PtpmProductLine::where('product_line_id', $inputLine["product_line_id"])->first();
                    } else {
                        $productLine = new PtpmProductLine;
                        $productLine->product_header_id     = $productHeader->product_header_id;
                        $productLine->created_by_id         = $userId;
                        $productLine->created_by            = $fndUserId;
                    }

                    $productLine->batch_id              = $productHeader->batch_id;
                    $productLine->inventory_item_id     = $productHeader->inventory_item_id;
                    $productLine->attribute10           = $inputLine['item_no'];
                    $productLine->attribute11           = $inputLine['item_desc'];
                    $productLine->organization_id       = $productHeader->organization_id;
                    $productLine->wip_step              = $wipStep;
                    $productLine->program_id            = 'PMP0014';

                    $productLine->product_date          = $productHeader->product_date;
                    $productLine->receive_wip           = str_replace(',', '', $inputLine['receive_wip']) ?? 0;
                    $productLine->transfer_wip          = str_replace(',', '', $inputLine['transfer_wip']) ?? 0;
                    $productLine->product_qty           = str_replace(',', '', $inputLine['product_qty']) ?? 0;
                    $productLine->loss_qty              = str_replace(',', '', $inputLine['loss_qty']) ?? 0;
                    $productLine->transfer_qty          = str_replace(',', '', $inputLine['transfer_qty']) ?? 0;

                    if (data_get($inputLine, 'is_convers_set_layout', false)) {
                        $setLayout = (object) $inputLine['set_layout'];
                        $layoutQty = $setLayout->layout_qty;
                        // $productLine->receive_wip       = $productLine->receive_wip ? ($productLine->receive_wip * $layoutQty) : $productLine->receive_wip;
                        // $productLine->transfer_wip      = $productLine->transfer_wip ? ($productLine->transfer_wip * $layoutQty) : $productLine->transfer_wip;
                        // $productLine->product_qty       = $productLine->product_qty ? ($productLine->product_qty * $layoutQty) : $productLine->product_qty;
                        // $productLine->loss_qty          = $productLine->loss_qty ? ($productLine->loss_qty * $layoutQty) : $productLine->loss_qty;
                        // $productLine->transfer_qty      = $productLine->transfer_qty ? ($productLine->transfer_qty * $layoutQty) : $productLine->transfer_qty;

                        $productLine->receive_wip       = $productLine->receive_wip ? ($productLine->receive_wip) : $productLine->receive_wip;
                        $productLine->transfer_wip      = $productLine->transfer_wip ? ($productLine->transfer_wip) : $productLine->transfer_wip;
                        $productLine->product_qty       = $productLine->product_qty ? ($productLine->product_qty) : $productLine->product_qty;
                        $productLine->loss_qty          = $productLine->loss_qty ? ($productLine->loss_qty) : $productLine->loss_qty;
                        $productLine->transfer_qty      = $productLine->transfer_qty ? ($productLine->transfer_qty) : $productLine->transfer_qty;

                        $productHeader->product_qty     = $productLine->product_qty;
                        $productHeader->save();
                    }


                    $productLine->uom                   = $inputLine['uom'];
                    $productLine->updated_by_id         = $userId;
                    $productLine->last_updated_by       = $fndUserId;
                    $productLine->updated_at            = $nowDate;
                    $productLine->last_update_date      = $nowDate;

                    $productLine->save();

                }

            }

            DB::commit();
            
            $updatedHeader = PtpmProductHeader::where('product_header_id', $productHeader->product_header_id)->first();
            $updatedLines = PtpmProductLine::where('product_header_id', $productHeader->product_header_id)->get();

            // RECONSILE CONSEQUENCES 
            self::reconcileWipQty($updatedHeader, $updatedLines);

            return response()->json([
                'header'    => $updatedHeader,
                'lines'     => $updatedLines,
            ]);

        } catch (\Exception $e) {
            \Log::info($e);
            DB::rollBack();
            
            return response()->json([
                'message' => $e->getMessage() . "\n\n" . json_encode([
                    'header' => $inputHeader,
                    'lines' => $inputLines,
                ]),
            ], 500);

        }

    }

    public static function reconcileWipQty($firstProductHeader, $firstProductLines) {
        
        $organizationId = $firstProductHeader->organization_id;
        $batchId = $firstProductHeader->batch_id;
        $firstProductDate = $firstProductHeader->product_date;
        $firstWipStep = $firstProductHeader->wip_step;
        
        $wipStep = $firstWipStep;

        $productLines = [];
        foreach($firstProductLines as $index => $firstProductLine) {
            $productLines[$index]['inventory_item_id'] = $firstProductLine->inventory_item_id;
            $productLines[$index]['transfer_wip'] = $firstProductLine->transfer_wip;
            $productLines[$index]['transfer_qty'] = $firstProductLine->transfer_qty;
        }

        // NEXT DAY PRODUCT (SAME WIP)
        // $nextDayProductDate = date("Y-m-d", strtotime("+1 day", strtotime($firstProductDate)));
        // $nextDayProductHeader = PtpmProductHeader::where("organization_id", $organizationId)
        //     ->where('batch_id', $batchId)
        //     ->where('wip_step', $wipStep)
        //     ->whereDate('product_date', $nextDayProductDate)
        //     ->first();

        // $nextDayProductDate = date("Y-m-d", strtotime("+1 day", strtotime($firstProductDate)));
        $nextDayProductHeader = PtpmProductHeader::where("organization_id", $organizationId)
            ->where('batch_id', $batchId)
            ->where('wip_step', $wipStep)
            ->whereDate('product_date', '>', $firstProductDate)
            ->orderBy('product_date')
            ->first();
        $organizationCode = optional(getDefaultData())->organization_code;
        
        do {
            
            if($nextDayProductHeader) {

                $nextDayProductLines = PtpmProductLine::where('product_header_id', $nextDayProductHeader->product_header_id)->get();
                foreach($nextDayProductLines as $index => $nextDayProductLine) {
                    $inputLine = self::findProductLine($productLines, $nextDayProductLine->inventory_item_id);
                    $nextDayProductLine->receive_wip = $inputLine['transfer_wip'];
                    $sumReceiveWipProductQty = $nextDayProductLine->receive_wip + $nextDayProductLine->product_qty;
                    $nextDayProductLine->transfer_wip = $sumReceiveWipProductQty - ($nextDayProductLine->transfer_qty);
                    if ($organizationCode == "M12" || $organizationCode == "M06") {
                        $nextDayProductLine->transfer_wip = $sumReceiveWipProductQty - ($nextDayProductLine->transfer_qty + $nextDayProductLine->loss_qty);
                    }

                    // if($sumReceiveWipProductQty > $nextDayProductLine->transfer_qty) {
                    // } else {
                    //     // $nextDayProductLine->transfer_wip = 0;
                    //     $nextDayProductLine->transfer_wip = $sumReceiveWipProductQty - $nextDayProductLine->transfer_qty;
                    //     // $nextDayProductLine->transfer_qty = $sumReceiveWipProductQty;
                    // }
                    $nextDayProductLine->save();
                    $productLines[$index]['transfer_wip'] = $nextDayProductLine->transfer_wip;
                }

                // $nextDayProductDate = date("Y-m-d", strtotime("+1 day", strtotime($nextDayProductHeader->product_date)));
                // $nextDayProductHeader = PtpmProductHeader::where("organization_id", $organizationId)
                //     ->where('batch_id', $batchId)
                //     ->where('wip_step', $wipStep)
                //     ->whereDate('product_date', $nextDayProductDate)
                //     ->first();
                $nextDayProductHeader = PtpmProductHeader::where("organization_id", $organizationId)
                    ->where('batch_id', $batchId)
                    ->where('wip_step', $wipStep)
                    ->whereDate('product_date', '>', $nextDayProductHeader->product_date)
                    ->orderBy('product_date')
                    ->first();

            }

        } while ($nextDayProductHeader);



        return;
        // A12 => CAN BE MANUALLY ENTERED
        // M06 => CAN BE MANUALLY ENTERED
        $organizationCode = optional(auth()->user())->organization_code;
        if ($organizationCode != "M12" && $organizationCode != "M06") {

            // SAME DAY + NEXT WIP PRODUCT
            $nextWipStep = self::getNextWipStep($organizationId, $batchId, $wipStep);
            $nextWipDayProductDate = date("Y-m-d", strtotime($firstProductDate));
            $nextWipProductHeader = PtpmProductHeader::where("organization_id", $organizationId)
                ->where('batch_id', $batchId)
                ->where('wip_step', $nextWipStep)
                ->whereDate('product_date', $nextWipDayProductDate)
                ->first();
        
            do {
                if ($nextWipProductHeader) {
                    $nextWipProductLines = PtpmProductLine::where('product_header_id', $nextWipProductHeader->product_header_id)->get();
                    foreach ($nextWipProductLines as $index => $nextWipProductLine) {
                        $inputLine = self::findProductLine($productLines, $nextWipProductLine->inventory_item_id);
                        if ($inputLine['transfer_qty'] > $nextWipProductLine->product_qty) {
                            $nextWipProductLine->loss_qty = $inputLine['transfer_qty'] - $nextWipProductLine->product_qty;
                        } else {
                            $nextWipProductLine->loss_qty = 0;
                        }
                        $nextWipProductLine->save();
                        $productLines[$index]['transfer_qty'] = $nextWipProductLine->transfer_qty;
                    }
                    $wipStep = $nextWipStep;

                    $nextWipStep = self::getNextWipStep($organizationId, $batchId, $wipStep);
                    $nextWipDayProductDate = date("Y-m-d", strtotime($nextWipProductHeader->product_date));
                    $nextWipProductHeader = PtpmProductHeader::where("organization_id", $organizationId)
                        ->where('batch_id', $batchId)
                        ->where('wip_step', $nextWipStep)
                        ->whereDate('product_date', $nextWipDayProductDate)
                        ->first();
                }
            } while ($nextWipProductHeader);
            
        }

    }

    public static function findProductLine($productLines, $inventoryItemId) {
        $result = [];
        foreach($productLines as $productLine) {
            if($productLine['inventory_item_id'] = $inventoryItemId) {
                $result = $productLine;
            }
        }
        return $result;
    }

    public function deleteLines(Request $request)
    {
        $lines = $request->input('lines');

        $deletedLines = [];
        foreach ($lines as $line) {
            $deletedLines[] = PtpmProductLine::query()
                ->where('wip_step', $line['wip_step'])
                ->where('product_date', parse_from_date_th($line['product_date']))
                ->delete();
        }

        return response()->json([
            'deletedLines' => $deletedLines,
        ]);
    }


    public function checkLayout($productLineId)
    {
        $data = false;
        $line = PtpmProductLine::where('product_line_id', $productLineId)->first();

        if (!$line) {
            return $data;
        }

        $org = collect(DB::select("
            SELECT  ORGANIZATION_CODE
            FROM    ORG_ORGANIZATION_DEFINITIONS
            WHERE  1=1
            AND    ORGANIZATION_ID = '{$line->organization_id}'
        "));
        if (!$org) {
            return $data;
        }
        $org = $org->first();

        if (($org->organization_code == 'M06') && $line->wip_step == 'WIP01') {
            $productDate = Carbon::parse($line->product_date)->format("Y-m-d");
            $layout = SetupLayoutsV::whereRaw("TRUNC(to_date('{$productDate}', 'YYYY-MM-DD')) BETWEEN TRUNC(start_date) and TRUNC(nvl(end_date, sysdate)) ")
                    ->where('inventory_item_id', $line->inventory_item_id)
                    ->orderBy('layout_id', 'desc')
                    ->first();

            if (!$layout) {
                return $data;
            }
            return $layout;
        }
        return $data;
    }

    public function getReceiveWipHeaderBuilder($organizationId, $batchId, $wipStep, $productDate)
    {
        // $organizationId  = "185"
        // $batchId         = "69497"
        // $wipStep         = "WIP01"
        // $productDate     = "2022-02-02"
        $data = false;
        $productDateFormat  = Carbon::parse($productDate)->format("Ymd");
        $lastReceiptWip     = PtpmProductHeader::where("organization_id", $organizationId)
                                ->when($batchId != '', function ($q) use ($batchId) {
                                    return $q->where('batch_id', $batchId);
                                })
                                ->where('wip_step', $wipStep);
        $receiptWip         = clone $lastReceiptWip;
        $lastReceiptWip     = $lastReceiptWip
                                ->whereRaw("to_char(product_date, 'YYYYMMDD') < '$productDateFormat'")
                                ->orderByRaw("to_char(product_date, 'YYYYMMDD') desc")
                                ->first();
        if (!$lastReceiptWip) {
            return $data;
        }

        $receiptWip = $receiptWip->where('product_header_id', $lastReceiptWip->product_header_id)->first();
        return $receiptWip;
        // $receiveWipHeaderBuilder = PtpmProductHeader::where("organization_id", $organizationId);
        // if ($batchId) $receiveWipHeaderBuilder->where('batch_id', $batchId);
        // $receiveWipHeaderBuilder->where('wip_step', $wipStep);
        // $receiveWipHeaderBuilder->whereDate('product_date', date("Y-m-d", strtotime("-1 day", strtotime(parse_from_date_th($productDate)))));
        // $receiveWipHeader = $receiveWipHeaderBuilder->first();
    }

}
