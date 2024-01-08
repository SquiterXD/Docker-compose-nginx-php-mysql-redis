<?php

namespace App\Http\Controllers\PM\Api;

use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ValidationErrorMessages;
use App\Models\PM\PtpmQrcodeReportDtlV;
use App\Models\PM\PtpmQrcodeReportV;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PM0022ApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $queryString = $request->all();
        $date = $queryString['date'] ?? null;

        if (!isset($date) || !Utils::isValidDate($date, 'Y-m-d')) {

            $date = date('Y-m-d');
        }

        $reports = PtpmQrcodeReportV::query()
            ->whereDate('request_date', '=', $date)
            ->get();

//        $mock00 = clone $reports[0];
//        $mock00['inventory_item_id'] = 10000;
//
//        $mock01 = clone $reports[0];
//        $mock01['inventory_item_id'] = 10001;
//
//        $reports[] = $mock00;
//        $reports[] = $mock01;

        $groupingReportByKey = [];
        foreach ($reports as $report) {
            $arrKey = $report['item_group'];

            $groupingReportByKey[$arrKey]['itemGroup'] = $arrKey;
            $groupingReportByKey[$arrKey]['reports'][] = $report;
        }

        $dailyRawMaterials = [];
        foreach (array_keys($groupingReportByKey) as $key) {
            $dailyRawMaterials[] = $groupingReportByKey[$key];
        }

        return response()->json([
            'dailyRawMaterials' => $dailyRawMaterials,
            'date' => $date,
        ]);
    }

//    private function getDailyRawMaterialValidation($date): \Illuminate\Contracts\Validation\Validator
//    {
//        $DATE = 'date';
//
//        $validatingData = [
//            $DATE => $date,
//        ];
//
//        $validatingRules = [
//            $DATE => 'required|date_format:Y-m-d',
//        ];
//
//        $attributeNames = [
//            $DATE => 'วันที่',
//        ];
//
//        return Validator::make(
//            $validatingData,
//            $validatingRules,
//            ValidationErrorMessages::TEMPLATES,
//            $attributeNames,
//        );
//    }

    public function showReport($id): JsonResponse
    {
        // validation id
        $id = trim($id);

        $validator = $this->showReportValidation($id);
        if ($validator->fails()) {
            return response()->json($validator->messages()->toArray(), 400);
        }

        $details = PtpmQrcodeReportDtlV::query()
            ->where('report_id', '=', $id)
            ->get();

        return response()->json([
            'reportDetails' => $details,
        ]);
    }

    private function showReportValidation($id): \Illuminate\Contracts\Validation\Validator
    {
        $REPORT_ID = 'reportId';

        $validatingData = [
            $REPORT_ID => $id,
        ];

        $validatingRules = [
            $REPORT_ID => 'required|numeric|integer',
        ];

        $attributeNames = [
            $REPORT_ID => 'รหัสรายงาน',
        ];

        return Validator::make(
            $validatingData,
            $validatingRules,
            ValidationErrorMessages::TEMPLATES,
            $attributeNames,
        );
    }

}
