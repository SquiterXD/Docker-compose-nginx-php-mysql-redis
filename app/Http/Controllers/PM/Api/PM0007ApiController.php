<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DbLookupController;
use App\Http\Controllers\ModulePaths;
use App\Models\Lookup\PtglCoaDeptCodeVLookup;
use App\Models\Lookup\PtpmItemConvUomVLookup;
use App\Models\Lookup\PtpmItemNumberVLookup;
use App\Models\Lookup\PtpmMachineRelationLookup;
use App\Models\Lookup\PtpmMesReviewIssuesVLookup;
use App\Models\Lookup\PtpmMesReviewJobHeadersLookup;
use App\Models\Lookup\PtpmMesReviewJobLinesLookup;
use App\Models\Lookup\PtpmMfgFormulaV;
use App\Models\Lookup\PtpmOperationOfBatchVLookup;
use App\Models\PM\Lookup\PtinvOnhandQuantitiesV;
use App\Models\PM\PtpmItemNumberV;
use App\Models\PM\PtpmMesReviewIssueHeaders;
use App\Models\PM\PtpmMesReviewIssueLines;
use App\Models\PM\PtpmSetupMfgDepartmentsV;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;

class PM0007ApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([

        ]);
    }

    public function show(Request $request): JsonResponse
    {
        $debugs = [];

        $user = auth()->user();
        $batchNo = $request->get('batch_no');
        $opt = $request->get('opt');
        $wipStep = $request->get('wip_step');
        $viewNo = $request->get('v', null);
        $departmentCode = $request->get('department_code');

        $debugs[] = [
            'params' => [
                'batchNo' => $batchNo,
                'opt' => $opt,
                'wip_step' => $wipStep,
                'v' => $viewNo,
                'department_code' => $departmentCode,
            ],
        ];

        if ($viewNo === '01' || $viewNo === '02') {
            $headerRow = PtpmMesReviewIssuesVLookup::with([
                'operationOfBatchV',])
                ->where('batch_no', $batchNo)
                ->where('opt', $opt)
                ->where('wip_step', $wipStep)
                ->where('trial_flag', 'N')
                ->first();

            $debugs[] = [
                'Ptpm_Mes_Review_Issues_V' => [
                    'batch_no' => $batchNo,
                    'opt' => $opt,
                    'wip_step' => $wipStep,
                    'trial_flag' => 'N',
                ],
            ];
        } else {
            $headerRow = PtpmMesReviewIssuesVLookup::with([
                'operationOfBatchV',])
                ->where('batch_no', $batchNo)
                ->where('wip_step', $wipStep)
                ->where('trial_flag', 'N')
                ->first();

            $debugs[] = [
                'Ptpm_Mes_Review_Issues_V' => [
                    'batch_no' => $batchNo,
                    'wip_step' => $wipStep,
                    'trial_flag' => 'N',
                ],
            ];
        }

        if ($headerRow) {
            $headerRow->operation_of_batch_v = PtpmOperationOfBatchVLookup::query()
                ->where('organization_id', $headerRow->organization_id)
                ->where('batch_no', $batchNo)
                ->first();

            $headerRow->job_type = DB::selectOne("
                SELECT  DESCRIPTION
                FROM OAPM.PTPM_JOB_TYPE
                WHERE LOOKUP_CODE = '{$headerRow->job_type_code}' -- จาก PTPM_MES_REVIEW_ISSUES_V > คอลัมน์ JOB_TYPE_CODE
            ");

            $debugs[] = [
                'Ptpm_Operation_Of_Batch_V' => [
                    'organization_id' => $headerRow->organization_id,
                    'batch_no' => $batchNo,
                ],
            ];
        }

        if ($headerRow && $headerRow->operation_of_batch_v) {
            $headerRow->machine_relation = PtpmMachineRelationLookup::query()
                ->where('step_description', $headerRow->operation_of_batch_v->oprn_desc)
                ->get();

            $debugs[] = [
                'Ptpm_Machine_Relation' => [
                    'step_description' => $headerRow->operation_of_batch_v->oprn_desc,
                ],
            ];
        }

        $coaDeptCodeV = PtglCoaDeptCodeVLookup::query()
            ->where('department_code', $user->department_code)
            ->first();

        $debugs[] = [
            'Ptgl_Coa_Dept_Code_V' => [
                'department_code' => $user->department_code,
            ],
        ];

        if (!$headerRow) return response()->json([
            'header' => null,
            'lines' => [],
            'coaDeptCodeV' => $coaDeptCodeV,
            'debugs' => $debugs,
        ], 404);

        $headerBuilder = PtpmMesReviewIssueHeaders::query()
            ->where('batch_no', $batchNo)
            ->where('opt', $opt)
            ->where('wip_step', $wipStep);
        if (in_array($viewNo, ['01', '02'])) {
            $headerBuilder->where('ingridient_group_code', $viewNo);
            $debugs[] = [
                'Ptpm_Mes_Review_Issue_Headers' => [
                    'batch_no' => $batchNo,
                    'opt' => $opt,
                    'wip_step' => $wipStep,
                    'ingridient_group_code' => $viewNo,
                ],
            ];
        } else {
            $headerBuilder->whereNull('ingridient_group_code');
            $debugs[] = [
                'Ptpm_Mes_Review_Issue_Headers' => [
                    'batch_no' => $batchNo,
                    'opt' => $opt,
                    'wip_step' => $wipStep,
                    'ingridient_group_code' => null,
                ],
            ];
        }
        $header = $headerBuilder->first();
        $headerRow->header = $header;

        $headerRow->item_number_v = PtpmItemNumberV::query()
            ->where('inventory_item_id', $headerRow->inventory_item_id)
            ->where('organization_id', $headerRow->organization_id)
            ->first();
        $debugs[] = [
            'Ptpm_Item_Number_V' => [
                'inventory_item_id' => $headerRow->inventory_item_id,
                'organization_id' => $headerRow->organization_id,
            ],
        ];

        $headerRow->mes_review_job_header = PtpmMesReviewJobHeadersLookup::query()
            ->where('batch_no', $batchNo)
            ->where('opt', $opt)
            ->first();
        $debugs[] = [
            'Ptpm_Mes_Review_Job_Headers' => [
                'batch_no' => $batchNo,
                'opt' => $opt,
            ],
        ];

        $headerRow->mes_review_job_lines = PtpmMesReviewJobLinesLookup::query()
            ->where('review_header_id', $headerRow->mes_review_job_header->review_header_id)
            ->where('wip_step', $wipStep)
            ->first();
        $debugs[] = [
            'Ptpm_Mes_Review_Job_Lines' => [
                'review_header_id' => $headerRow->mes_review_job_header->review_header_id,
                'wip_step' => $wipStep,
            ],
        ];


        //print_r($headerRow->toArray());

        $lineRowsBuilder = PtpmMfgFormulaV::query()
            ->where('organization_id', $headerRow->organization_id)
            ->where('product_item_id', $headerRow->inventory_item_id);

        if (in_array($viewNo, ['01', '02'])) {
            $lineRowsBuilder->where('item_classification_code', $viewNo);
            $debugs[] = [
                'Ptpm_Mfg_Formula_V' => [
                    'organization_id' => $headerRow->organization_id,
                    'product_item_id' => $headerRow->inventory_item_id,
                    'item_classification_code' => $viewNo,
                ],
            ];
        } else {
            $debugs[] = [
                'Ptpm_Mfg_Formula_V' => [
                    'organization_id' => $headerRow->organization_id,
                    'product_item_id' => $headerRow->inventory_item_id,
                ],
            ];
        }

        $lineRows = $lineRowsBuilder->get()
            ->map(function ($mfg) use ($headerRow, $header, $viewNo, $wipStep, &$debugs) {

                if ($viewNo === '03') {

                    $mfg->setup_mfg_department_v = PtpmSetupMfgDepartmentsV::query()
                        ->where('tobacco_group_code', $mfg->tobacco_group_code)
                        ->where('department_code', $headerRow->department_code)
                        ->first();
                } else {
                    $mfg->setup_mfg_department_v = PtpmSetupMfgDepartmentsV::query()
                        ->where('tobacco_group_code', $mfg->tobacco_group_code)
                        ->where('department_code', $headerRow->department_code)
                        ->first();
                }

                if ($viewNo === '01') {
                    $mfg->onhand_quantities_v = PtinvOnhandQuantitiesV::query()
                        ->where('subinventory_code', $mfg->setup_mfg_department_v->from_subinventory)
                        ->where('locator_id', $mfg->setup_mfg_department_v->from_locator_id)
                        ->where('organization_id', $mfg->setup_mfg_department_v->from_organization_id)
                        ->where('inventory_item_id', $mfg->inventory_item_id)
                        ->where('lot_number', $mfg->default_lot_no)
                        ->first();
                    $debugs[] = [
                        'Ptinv_Onhand_Quantities_V' => [
                            'subinventory_code' => $mfg->setup_mfg_department_v->from_subinventory,
                            'locator_id' => $mfg->setup_mfg_department_v->from_locator_id,
                            'organization_id' => $mfg->setup_mfg_department_v->from_organization_id,
                            'inventory_item_id' => $mfg->inventory_item_id,
                            'lot_number' => $mfg->default_lot_no,
                        ],
                    ];
                } else {
                    $mfg->onhand_quantities_v = PtinvOnhandQuantitiesV::query()
                        ->where('subinventory_code', $mfg->setup_mfg_department_v->from_subinventory)
                        ->where('locator_id', $mfg->setup_mfg_department_v->from_locator_id)
                        ->where('organization_id', $mfg->setup_mfg_department_v->from_organization_id)
                        ->where('inventory_item_id', $mfg->inventory_item_id)
                        ->first();
                    $debugs[] = [
                        'Ptinv_Onhand_Quantities_V' => [
                            'subinventory_code' => $mfg->setup_mfg_department_v->from_subinventory,
                            'locator_id' => $mfg->setup_mfg_department_v->from_locator_id,
                            'organization_id' => $mfg->setup_mfg_department_v->from_organization_id,
                            'inventory_item_id' => $mfg->inventory_item_id,
                        ],
                    ];
                }


                $mfg->onhand_quantities_v_list = PtinvOnhandQuantitiesV::query()
                    ->where('subinventory_code', $mfg->setup_mfg_department_v->from_subinventory)
                    ->where('locator_id', $mfg->setup_mfg_department_v->from_locator_id)
                    ->where('organization_id', $mfg->setup_mfg_department_v->from_organization_id)
                    ->where('inventory_item_id', $mfg->inventory_item_id)
                    ->get();

                if ($header) {
                    $line = PtpmMesReviewIssueLines::query()
                        ->where('issue_header_id', $header->issue_header_id)
                        ->where('inventory_item_id', $mfg->inventory_item_id)
                        ->where('organization_id', $mfg->setup_mfg_department_v->from_organization_id);
                    //if ($viewNo === '01') $line->where('lot_number', $mfg->lot_number);

                    $debugs[] = [
                        ':Ptpm_Mes_Review_Issue_Lines' => [
                            'issue_header_id' => $header->issue_header_id,
                            'inventory_item_id' => $mfg->inventory_item_id,
                            'organization_id' => $mfg->setup_mfg_department_v->from_organization_id,
                        ],
                    ];
                    $mfg->line = $line->first();
                } else {
                    $mfg->line = null;
                }

                $mfg->debug_query_where = [
                    'issue_header_id' => $header ? $header->issue_header_id : null,
                    'inventory_item_id' => $mfg->inventory_item_id,
                    'organization_id' => $mfg->organization_id,
                    'lot_number' => $mfg->lot_number,
                    'v' => $viewNo,
                ];

                if ($viewNo === '03') {

                    if ($header) {
                        $issueDate = $header->issue_date;
                    } else {
                        $issueDate = date('Y-m-d');
                    }

                    $mfg->pgk_get_item_onhand = DB::select("
                        select apps.PTINV_onhand_qty_pkg.GET_ITEM_ONHAND(
                            P_AS_OF_DATE => TO_DATE(:cur_date, 'yyyy-mm-dd')-1
                            ,P_ORGANIZATION_ID  => 227
                            ,P_ITEM_ID  => 20102
                            ,P_SUBINVENTORY_CODE => 'FC6ROJ01'
                            ,P_LOT_NUMBER => 'A3'
                            ,P_LOCATOR_ID => 9805
                        ) as col from dual
                    ", [
                        'cur_date' => date('Y-m-d', strtotime($issueDate))
                    ])[0]->col;

                    $mfg->pgk_get_issue_qty = DB::select("
                        select apps.ptpm_main.get_issue_qty(
                            p_organization_id => 166,
                            p_subinv  =>  'FC6ROJ01',
                            p_locator_id => 486,
                            p_inventory_item_id => 19598,
                            p_tran_date => TO_DATE(:cur_date, 'yyyy-mm-dd')
                        ) as col from dual
                    ", [
                        'cur_date' => date('Y-m-d', strtotime($issueDate))
                    ])[0]->col;

                    $mfg->item_conv_uom_lookup = PtpmItemConvUomVLookup::query()
                        ->where('organization_id', $mfg->organization_id)
                        ->where('inventory_item_id', $mfg->inventory_item_id)
                        ->get();
                }

                return $mfg;
            });

        return response()->json([
            'header' => $headerRow,
            'lines' => $lineRows,
            'coaDeptCodeV' => $coaDeptCodeV,
            'debugs' => $debugs,
        ]);
    }

    public function save(Request $request)
    {
        $user = auth()->user();

        $defaultDate = getDefaultData(ModulePaths::PM_0007);
        $user_id = $defaultDate->user_id;
        $program_code = $defaultDate->program_code ?? 'PM0007';

        $headerRowData = $request->input('header');
        $lineRowsData = $request->input('lines');
        $itemClassification = $request->input('item_classification');

        $webBatchNo = $this->generateWebBatchNo();
        //echo "webBatchNo=[$webBatchNo]";
        $RECORD_STATUS_INSERT = 'INSERT';
        $RECORD_STATUS_UPDATE = 'UPDATE';

//        $x = [
//            'h' => $headerRowData,
//            'l' => $lineRowsData,
//            '$itemClassification' => $itemClassification,
//            'web_batch_no' => $webBatchNo,
//        ];
        //return $x;

        $headerUpsertData = array_filter([
            'organization_id' => $headerRowData['organization_id'],
            'department_code' => $headerRowData['department_code'],
            'batch_no' => $headerRowData['batch_no'],
            'batch_id' => $headerRowData['batch_id'],
            'opt' => $headerRowData['opt'],
            'inventory_item_id' => $headerRowData['inventory_item_id'],
            'ingridient_group_code' => $itemClassification['item_classification_code'],
            'opt_plan_qty' => $headerRowData['mes_review_job_header']['opt_plan_qty'],
            'wip_qty' => $headerRowData['mes_review_job_lines']['confirm_qty'],
            //'request_number' => $headerRowData[''],
            'job_type_code' => $headerRowData['job_type_code'],
            'wip_step' => $headerRowData['wip_step'],
            'issue_date' => $headerRowData['issue_date'],
            'complete_date' => $headerRowData['mes_review_job_lines']['transaction_date'],
            'trial_flag' => 'N',
        ]);

        $at = DB::raw("to_date('" . date('Y-m-d') . "', 'yyyy-mm-dd')");
        foreach (['issue_date', 'complete_date'] as $col) {
            if (isset($headerUpsertData[$col]))
                $headerUpsertData[$col] = DB::raw("to_date('" . date('Y-m-d', strtotime($headerUpsertData[$col])) . "', 'yyyy-mm-dd')");
        }

        if (isset($headerRowData['header']) && isset($headerRowData['header']['issue_header_id'])) {

            $headerUpsertData = array_merge($headerUpsertData, [
                'web_batch_no' => $webBatchNo,
                'record_status' => $RECORD_STATUS_UPDATE,
                'last_update_date' => $at,
                'last_updated_by' => $user_id,
            ]);

            $headerData = $headerRowData['header'];
            $header = PtpmMesReviewIssueHeaders::query()
                ->where('issue_header_id', $headerData['issue_header_id'])
                ->first();
            $header->fill($headerUpsertData);
            $header->save();

        } else {

            $headerUpsertData = array_merge($headerUpsertData, [
                'web_batch_no' => $webBatchNo,
                'record_status' => $RECORD_STATUS_INSERT,
                'creation_date' => $at,
                'created_by' => $user_id,
            ]);

            PtpmMesReviewIssueHeaders::query()->create($headerUpsertData);
            $header = PtpmMesReviewIssueHeaders::query()
                ->where('web_batch_no', $webBatchNo)
                ->first();
        }


        $lines = [];
        foreach ($lineRowsData as $group) {
            foreach ($group['items'] as $lineRowData) {

                //print_r($lineRowData);

                $lineUpsertData = [
                    'issue_header_id' => $header->issue_header_id,
                    'leaf_formula' => $lineRowData['leaf_fomula'],
                    'organization_id' => $lineRowData['setup_mfg_department_v']['from_organization_id'], //$lineRowData['organization_id'],
                    'subinventory_code' => $lineRowData['setup_mfg_department_v']['from_subinventory'],
                    'locator_id' => $lineRowData['setup_mfg_department_v']['from_locator_id'],
                    'confirm_qty' => $lineRowData['line']['confirm_qty'],
                    'confirm_uom_code' => $lineRowData['detail_uom'],
                    'inventory_item_id' => $lineRowData['inventory_item_id'],
                    'formula_id' => $lineRowData['formula_id'],
                    'formula_vers' => $lineRowData['formula_vers'],
                    'formulaline_id' => $lineRowData['formulaline_id'],
                    'line_num' => $lineRowData['line_no'],
                    'lot_number' => isset($lineRowData['default_lot_no']) ? $lineRowData['default_lot_no'] : 0,
                    'program_code' => $program_code,
                    'transaction_type_id' => $lineRowData['setup_mfg_department_v']['transaction_type_id'],
                ];

                if (isset($lineRowData['line']) && isset($lineRowData['line']['issue_line_id'])) {

                    $lineUpsertData = array_merge($lineUpsertData, [
                        'web_batch_no' => $webBatchNo,
                        'record_status' => $RECORD_STATUS_UPDATE,
                        'last_update_date' => $at,
                        'last_updated_by' => $user_id,
                    ]);

                    $line = PtpmMesReviewIssueLines::query()
                        ->where('issue_line_id', $lineRowData['line']['issue_line_id'])
                        ->first();
                    $line->fill($lineUpsertData);
                    $line->save();
                    $lines[] = $line;
                } else {

                    $lineUpsertData = array_merge($lineUpsertData, [
                        'web_batch_no' => $webBatchNo,
                        'record_status' => $RECORD_STATUS_INSERT,
                        'creation_date' => $at,
                        'created_by' => $user_id,
                    ]);

                    //print_r($lineUpsertData);

                    $lines[] = PtpmMesReviewIssueLines::query()->create($lineUpsertData);
                }
            }
        }

        //$lines = PtpmMesReviewIssueLines::query()->where('issue_header_id', $header->issue_header_id)->get();

        return response()->json([
            'header' => $header,
            'lines' => $lines,
            'web_batch_no' => $webBatchNo,
        ]);
    }

    public function cutIssue(Request $request)
    {
        $data = $this->save($request)->getData();
        $web_batch_no = $data->web_batch_no;

        $sql = "
            declare
                v_status    varchar2(10);
                v_err_msg   varchar2(2000);
            begin
                apps.ptpm_main.mes_issue_qty(
                    p_program_code => 'PMP0007',
                    p_web_batch_no => '$web_batch_no',
                    p_user_name => 'MERCURY',
                    p_status => :v_status,
                    p_err_msg => :v_err_msg
                );
                dbms_output.put_line(:v_status);
                dbms_output.put_line(:v_err_msg);
            end;
        ";

        $response = [];

        $stmt = DB::connection('oracle')->getPdo()->prepare($sql);
        $stmt->bindParam(":v_status", $response['v_status'], PDO::PARAM_STR, 10);
        $stmt->bindParam(":v_err_msg", $response['v_err_msg'], PDO::PARAM_STR, 2000);
        $stmt->execute();

        return response()->json([
            'status' => $response['v_status'] === 'S',
            'err_msg' => $response['v_err_msg'],
            '$response' => $response,
        ]);
    }

    private function generateWebBatchNo()
    {
        return date('YmdHis') . substr(strval(round(microtime(true) * 1000)), -4);
    }
}
