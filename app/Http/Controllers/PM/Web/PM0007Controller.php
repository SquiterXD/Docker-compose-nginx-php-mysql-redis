<?php

namespace App\Http\Controllers\PM\Web;


use App\Http\Controllers\PM\Api\PM0007ApiController;
use App\Models\Lookup\PtglCoaDeptCodeVLookup;
use App\Models\Lookup\PtpmItemClassificationsVLookup;
use App\Models\Lookup\PtpmMachineRelationLookup;
use App\Models\Lookup\PtpmMesReviewIssuesVLookup;
use App\Models\PM\Lookup\PtglCoaDeptCodeV;
use App\Models\PM\PtpmMesReviewIssueHeaders;
use App\Models\PM\PtpmMesReviewIssueLines;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PM0007Controller extends BaseController
{
    /**
     * @var PM0007ApiController
     */
    private $api;

    /**
     * PM0007Controller constructor.
     * @param PM0007ApiController $api
     */
    public function __construct(PM0007ApiController $api)
    {
        $this->api = $api;
    }

    public function index(Request $request, $issueHeaderId = null)
    {
        //print_r(getDefaultData('/pm/request-materials'));

        $viewNo = $request->get('v', '01');

        switch ($viewNo) {
            case '01':
                return $this->index01($request, $issueHeaderId);
            case '02':
                return $this->index02($request, $issueHeaderId);
            case '03':
                return $this->index03($request, $issueHeaderId);
        }

        return null;
    }

    // 01

    public function index01(Request $request, $issueHeaderId = null)
    {
        $user = auth()->user();

        $coaDeptCode = PtglCoaDeptCodeV::query()
            ->where('department_code', $user->department_code)
            ->whereIn('description', ['กองผลิตยาเส้น', 'กองผลิตยาเส้นพอง', 'หน่วยยาเส้นภูมิภาค'])
            ->first();

        return $this->displayView($request, '01', $coaDeptCode, $issueHeaderId);
    }

    // 02

    public function index02(Request $request, $issueHeaderId = null)
    {
        $user = auth()->user();

        $coaDeptCode = PtglCoaDeptCodeV::query()
            ->where('department_code', $user->department_code)
            ->where('description', 'กองผลิตยาเส้น')
            ->first();

        return $this->displayView($request, '02', $coaDeptCode, $issueHeaderId);
    }

    // 03

    public function index03(Request $request, $issueHeaderId = null)
    {
        $user = auth()->user();

        $coaDeptCode = PtglCoaDeptCodeV::query()
            //->where('department_code', $user->department_code)
            ->where('department_code', '62000200')
            ->whereIn('description', ['กองมวนและบรรจุ', 'กองพิมพ์', 'หน่วยบรรจุภูมิภาค'])
            ->first();

        return $this->displayView($request, '03', $coaDeptCode, $issueHeaderId);
    }

    // index

    public function displayView(Request $request, $viewNo, $coaDeptCode, $issueHeaderId = null)
    {
        $user = auth()->user();

        $departmentCode = $request->get('department_code', $coaDeptCode->department_code);

        switch ($viewNo) {
            case '01' :
            case '02' :
            case '03' :
                $mesReviewIssueDepartmentCode = $departmentCode;//'62000200';
//                $mesReviewIssueDepartmentCode = '62000200';
                break;
            default:
                return response()->json([
                    'msg' => "{$user->department_code} not exists for view",
                ], 401);
        }

        $info = $this->api->show($request)->getData();

        $mesReviewIssueLookupList = PtpmMesReviewIssuesVLookup::query()
            ->where('department_code', $mesReviewIssueDepartmentCode)
            ->where('trial_flag', 'N')
            ->get();

        $itemClassification = PtpmItemClassificationsVLookup::query()
            ->where('item_classification_code', $viewNo)
            ->first();

        if ($info->header) {
            $itemClassificationList = DB::select("
                SELECT      OPRN_CLASS_DESC, OPRN_DESC, BATCH_NO
                FROM        OAPM.PTPM_OPERATION_OF_BATCH_V
                WHERE      ORGANIZATION_ID    = '{$info->header->organization_id}'        --> จากเลขที่คำสั่งผลิต,OPT ที่เลือก
                -- AND        BATCH_NO           = '64-4-0001'  --> จากเลขที่คำสั่งผลิต,OPT ที่เลือก
            ");
        } else {
            $itemClassificationList = DB::select("
                SELECT      OPRN_CLASS_DESC, OPRN_DESC, BATCH_NO
                FROM        OAPM.PTPM_OPERATION_OF_BATCH_V
            ");
        }

        return $this->vue('pm0007', [
            'v' => $viewNo,
            'user' => $user,
            'coa_dept_code_v' => $info->coaDeptCodeV,
            'department_code' => $departmentCode,
            'init_header' => $info->header,
            'init_lines' => $info->lines,
            'mes_review_issue_lookup_list' => $mesReviewIssueLookupList,
            //'machine_relation_list' => $machineRelationList,
            'item_classification' => $itemClassification ? $itemClassification : (object)[],
            'item_classification_list' => $itemClassificationList,
            'debugs' => $info->debugs,
        ]);
    }
}
