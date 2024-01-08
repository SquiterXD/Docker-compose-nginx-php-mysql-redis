<?php
namespace App\Repositories\QM;

use DB;
use Illuminate\Database\Eloquent\Collection;

use Carbon\Carbon;

class CommonRepository
{
    public static function getTHDate($data) {

        $thaiMonths = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
        $date = Carbon::parse($data);
        $month = $thaiMonths[$date->month];
        $year = $date->year + 543;

        return $date->format("j $month $year");

    }

    public static function getTHMoth($data) {

        $thaiMonths = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
        $date = Carbon::parse($data);
        $month = $thaiMonths[$date->month];
        $year = $date->year + 543;

        return $date->format("$month $year");

    }

    public static function getResultStatusLabel($resultStatus) {
        $label = "";
        if($resultStatus == "PENDING" || $resultStatus == "PD") {
            $label = "ยังไม่ลงผล";
        } else if($resultStatus == "PASSED" || $resultStatus == "CF") {
            $label = "ลงผลแล้ว ผลทดสอบปกติ";
        } else if($resultStatus == "FAILED" || $resultStatus == "NF") {
            $label = "ลงผลแล้ว พบค่าความผิดปกติ";
        } else if($resultStatus == "REJECTED" || $resultStatus == "RJ") {
            $label = "ปฏิเสธผล";
        }
        return $label;
    }

    public static function getApprovalStatusLabel($approvalStatus) {
        $label = "";
        if($approvalStatus == "PENDING") {
            $label = "รอการอนุมัติ";
        } else if($approvalStatus == "O_PENDING") {
            $label = "ยังไม่ส่งอนุมัติ";
        } else if($approvalStatus == "APPROVED") {
            $label = "อนุมัติแล้ว";
        } else if($approvalStatus == "O_APPROVED") {
            $label = "ส่งอนุมัติแล้ว";
        } else if($approvalStatus == "S_APPROVED") {
            $label = "Supervisor อนุมัติแล้ว";
        } else if($approvalStatus == "L_APPROVED") {
            $label = "หัวหน้ากองอนุมัติแล้ว";
        } else if($approvalStatus == "REJECTED") {    
            $label = "ไม่อนุมัติผลการตรวจสอบ";
        } else if($approvalStatus == "O_REJECTED") {
            $label = "ยกเลิกผลการตรวจสอบ";
        } else if($approvalStatus == "S_REJECTED") {
            $label = "Supervisor ไม่อนุมัติผลการตรวจสอบ";
        } else if($approvalStatus == "L_REJECTED") {
            $label = "หัวหน้ากองไม่อนุมัติผลการตรวจสอบ";
        }
        return $label;
    }

    public static function getApprovalRole($authUser, $approvalData) {

        $authUsername = $authUser->username ? strtoupper($authUser->username) : ""; 
        $authRoleName = "";
        foreach (auth()->user()->role_options ?? [] as $key => $roleId) {
            $role = \App\Models\Role::find($roleId);
            $authRoleName = $role ? $role->name : ""; 
        
            $approvalRolePrefixes = [];
            foreach($approvalData as $index => $item) {
                $approvalRolePrefixes[$index] = $item->toArray();
                $approvalRolePrefixes[$index]["username"] = $item->username;
                // $approvalRolePrefixes[$index]["username_prefix"] = str_replace("-%","-", $item->username);
                $approvalRolePrefixes[$index]["rolename_prefix"] = str_replace("-%","-", $item->username);
            }
            
            $foundApprovalRole = null;
            foreach($approvalRolePrefixes as $approvalRolePrefix) {
                // if(str_starts_with($authUsername, $approvalRolePrefix["username_prefix"])){
                if(str_starts_with($authRoleName, $approvalRolePrefix["rolename_prefix"])){
                    $foundApprovalRole = $approvalRolePrefix;
                    if ($foundApprovalRole) {
                        return $foundApprovalRole;
                    }
                }
            }
        }
            
            return $foundApprovalRole;

    }

    public static function convertMothUploadDateFromTH($dateTH, $isMultiMonthColumn) {

        // \Log::info("dateTH : ");
        // \Log::info($dateTH);
        
        $arrDate = explode(" ", trim($dateTH));
        $monthMappings = [
            [
                "date_no" => "01", 
                "date_th" => "ม.ค."
            ],[
                "date_no" => "02", 
                "date_th" => "ก.พ."
            ],[
                "date_no" => "03", 
                "date_th" => "มี.ค."
            ],[
                "date_no" => "04", 
                "date_th" => "เม.ย."
            ],[
                "date_no" => "05", 
                "date_th" => "พ.ค."
            ],[
                "date_no" => "06", 
                "date_th" => "มิ.ย."
            ],[
                "date_no" => "07", 
                "date_th" => "ก.ค."
            ],[
                "date_no" => "08", 
                "date_th" => "ส.ค."
            ],[
                "date_no" => "09", 
                "date_th" => "ก.ย."
            ],[
                "date_no" => "10", 
                "date_th" => "ต.ค."
            ],[
                "date_no" => "11", 
                "date_th" => "พ.ย."
            ],[
                "date_no" => "12", 
                "date_th" => "ธ.ค."
            ],
        ];

        $month = "";
        foreach($monthMappings as $monthMapping) {
            if($monthMapping["date_th"] == $arrDate[1]) {
                $month = $monthMapping["date_no"];
            }
        }

        $convertedDate = strval(intval($arrDate[2]) - 543) . '-' . $month . '-' . str_pad($arrDate[0], 2, "0", STR_PAD_LEFT);    

        return $convertedDate;

    }

    public static function getBrandLabelByLotNo($brandMappings, $lotNumber) {
        $result = "";
        foreach($brandMappings as $brandMapping){
            if($brandMapping->lot_no == $lotNumber) {
                $result = $brandMapping->product_name;
            }
        }
        return $result;
    }

    public static function getBrandDescByLotNo($brandMappings, $lotNumber) {
        $result = "";
        foreach($brandMappings as $brandMapping){
            if($brandMapping->lot_no == $lotNumber) {
                $result = $brandMapping->product_description;
            }
        }
        return $result;
    }

    public static function getBrandLotNo($brandMappings, $brand) {
        $result = "";
        foreach($brandMappings as $brandMapping){
            if($brandMapping->brand == $brand) {
                $result = $brandMapping->lot_no;
            }
        }
        return $result;
    }

    public static function getBrandCategoryName($brandMappings, $lotNumber) {
        $result = "";
        foreach($brandMappings as $brandMapping){
            if($brandMapping->lot_no == $lotNumber) {
                $result = $brandMapping->category_name;
            }
        }
        return $result;
    }

    public static function getOptByBatchId($batchId) {
        $result = $batchId;
        if($batchId) {
            $arrBatchId = explode("_", $batchId);
            if(count($arrBatchId) > 1){
                $result = $arrBatchId[1];
            }
        }
        return $result;
    }

    public static function getBlendYear($blendDate) {
        $result = null;
        if($blendDate) {
            $result = date("Y", strtotime($blendDate));
        }
        return $result;
    }

    public static function getPositionLeakShortName($positionLeak) {
        $result = "";
        if($positionLeak == "SIDE") {
            $result = "S";
        } else if($positionLeak == "TOP") {
            $result = "T";
        } else if($positionLeak == "BOTTOM") {
            $result = "B";
        } else if($positionLeak == "NONE") {
            $result = "N";
        }
        return $result;
    }

    public static function getPositionLeakDesc($listLeakPositions, $positionLeak) {
        $result = "";
        foreach($listLeakPositions as $listLeakPosition) {
            if($positionLeak == $listLeakPosition->lookup_code) {
                $result = $listLeakPosition->meaning;
            }
        }
        return $result;
    }

    public static function getMakerType($machineRelations, $maker) {
        $result = "";
        foreach($machineRelations as $machineRelation){
            if($machineRelation->maker == $maker) {
                $result = $machineRelation->machine_type;
            }
        }
        return $result;
    }

    public static function getConfirmStatus($confirmStatuses, $confirmCode) {
        $result = "";
        foreach($confirmStatuses as $confirmStatuse){
            if($confirmStatuse->confirm_code == $confirmCode) {
                $result = $confirmStatuse->confirm_status;
            }
        }
        return $result;
    }

    public static function getSampleOperationStatus($gmdSample, $sampleResults) {

        $sampleOperationStatus = "PD";
        
        $countItem = 0;
        $countCompletedItem = 0;
        $countIncompletedItem = 0;

        foreach($sampleResults as $sampleResult) {

            if($sampleResult->read_only != 'Y') {

                if ($sampleResult->result_value !== null && $sampleResult->result_value !== "") {
                    $countCompletedItem++;
                } else {
                    if($sampleResult->remark_no_result !== null && $sampleResult->remark_no_result !== "") { // remark_no_result
                        $countCompletedItem++;
                    } else {
                        $countIncompletedItem++;
                    }
                }
                $countItem++;
            }

        }

        if($countCompletedItem > 0) {
            if($countCompletedItem == $countItem) {
                $sampleOperationStatus = "CP";
            } else {
                $sampleOperationStatus = "IP";
            }
        }

        if($gmdSample->attribute13 == "12" || $gmdSample->attribute13 == "22" || $gmdSample->attribute13 == "32") {
            $sampleOperationStatus = "RJ";
        }
        
        return $sampleOperationStatus;

    }

    public static function getSampleTobaccoOperationStatus($gmdSample, $sampleResults) {

        $sampleOperationStatus = "PD";
        
        $countItem = 0;
        $countCompletedItem = 0;
        $countIncompletedItem = 0;

        foreach($sampleResults as $sampleResult) {

            if($sampleResult->read_only != 'Y' || ($sampleResult->read_only == 'Y' && $sampleResult->evaluation_flag == 'Y')) {

                if ($sampleResult->result_value !== null && $sampleResult->result_value !== "") {
                    $countCompletedItem++;
                } else {
                    if($sampleResult->remark_no_result !== null && $sampleResult->remark_no_result !== "") { // remark_no_result
                        $countCompletedItem++;
                    } else {
                        $countIncompletedItem++;
                    }
                }
                $countItem++;
            }

        }

        if($countCompletedItem > 0) {
            if($countCompletedItem == $countItem) {
                $sampleOperationStatus = "CP";
            } else {
                $sampleOperationStatus = "IP";
            }
        }

        if($gmdSample->attribute13 == "12" || $gmdSample->attribute13 == "22" || $gmdSample->attribute13 == "32") {
            $sampleOperationStatus = "RJ";
        }
        
        return $sampleOperationStatus;

    }

    public static function getSampleLeakOperationStatus($gmdSample, $sampleResults) {

        $sampleOperationStatus = "PD";
        
        $countItem = 0;
        $countCompletedItem = 0;
        $countIncompletedItem = 0;

        foreach($sampleResults as $sampleResult) {

            if($sampleResult->read_only != 'Y' || ($sampleResult->read_only == 'Y' && $sampleResult->evaluation_flag == 'Y')) {

                if ($sampleResult->result_value !== null && $sampleResult->result_value !== "") {
                    $countCompletedItem++;
                } else {
                    if($sampleResult->remark_no_result !== null && $sampleResult->remark_no_result !== "") { // remark_no_result
                        $countCompletedItem++;
                    } else {
                        $countIncompletedItem++;
                    }
                }
                $countItem++;
            }

        }

        if($countCompletedItem > 0) {
            if($countCompletedItem == $countItem) {
                $sampleOperationStatus = "CP";
            } else {
                $sampleOperationStatus = "IP";
            }
        }

        if($gmdSample->attribute13 == "12" || $gmdSample->attribute13 == "22" || $gmdSample->attribute13 == "32") {
            $sampleOperationStatus = "RJ";
        }
        
        return $sampleOperationStatus;

    }

    public static function getSampleOperationStatusDesc($status) {
        $label = "";
        if($status == "PD") {
            $label = "ยังไม่ลงผล";
        } else if($status == "IP") {
            $label = "อยู่ระหว่างลงผล";
        } else if($status == "CP") {
            $label = "ลงผลเสร็จแล้ว";
        } else if($status == "RJ") {
            $label = "ปฏิเสธผล";
        }
        return $label;
    }

    public static function getSampleResultStatus($gmdSample, $sampleResults) {

        $sampleResultStatus = "PD";
        
        $countItem = 0;
        $countPassedResult = 0;
        $countFailedResult = 0;

        foreach($sampleResults as $sampleResult) {

            // if($sampleResult->read_only != 'Y') {

            $dataTypeCode = $sampleResult->data_type_code;
            $resultValue = (float)$sampleResult->result_value;
            $minValue = (float)$sampleResult->min_value;
            $maxValue = (float)$sampleResult->max_value;

            if (($dataTypeCode == "N" || $dataTypeCode == "E") && ($resultValue < $minValue || $resultValue > $maxValue)) {
                if($sampleResult->remark_no_result !== null && $sampleResult->remark_no_result !== "") { // remark_no_result
                    $countPassedResult++;
                } else {
                    $countFailedResult++;
                }
            } else {
                $countPassedResult++;
            }

            $countItem++;

            // }

        }

        if($countPassedResult == $countItem) {
            $sampleResultStatus = "CF";
        } else {
            $sampleResultStatus = "NC";
        }

        if($gmdSample->attribute13 == "12" || $gmdSample->attribute13 == "22" || $gmdSample->attribute13 == "32") {
            $sampleResultStatus = "RJ";
        }
        
        return $sampleResultStatus;

    }

    public static function getSampleTobaccoResultStatus($gmdSample, $evaluationTestIds, $sampleResults) {

        $sampleResultStatus = "PD";
        
        $countItem = 0;
        $countPassedResult = 0;
        $countFailedResult = 0;

        $filteredSampleResults = [];
        foreach($sampleResults as $sampleResult) {
            if(in_array($sampleResult->test_id, $evaluationTestIds)) {
                $filteredSampleResults[] = $sampleResult;
            }
        }

        foreach($filteredSampleResults as $filteredSampleResult) {

            $dataTypeCode = $filteredSampleResult->data_type_code;
            $resultValue = (float)$filteredSampleResult->result_value;
            $minValue = (float)$filteredSampleResult->min_value;
            $maxValue = (float)$filteredSampleResult->max_value;

            if (($dataTypeCode == "N" || $dataTypeCode == "E") && ($resultValue < $minValue || $resultValue > $maxValue)) {
                if($filteredSampleResult->remark_no_result !== null && $filteredSampleResult->remark_no_result !== "") { // remark_no_result
                    $countPassedResult++;
                } else {
                    $countFailedResult++;
                }
            } else {
                $countPassedResult++;
            }

            $countItem++;

        }

        if($countItem > 0) {
            if($countPassedResult == $countItem) {
                $sampleResultStatus = "CF";
            } else {
                $sampleResultStatus = "NC";
            }
        }

        if($gmdSample->attribute13 == "12" || $gmdSample->attribute13 == "22" || $gmdSample->attribute13 == "32") {
            $sampleResultStatus = "RJ";
        }
        
        return $sampleResultStatus;

    }

    public static function getSampleLeakResultStatus($gmdSample, $evaluationTestIds, $sampleResults) {

        $sampleResultStatus = "PD";
        
        $countItem = 0;
        $countPassedResult = 0;
        $countFailedResult = 0;

        $filteredSampleResults = [];
        foreach($sampleResults as $sampleResult) {
            if(in_array($sampleResult->test_id, $evaluationTestIds)) {
                $filteredSampleResults[] = $sampleResult;
            }
        }

        foreach($filteredSampleResults as $filteredSampleResult) {

            $dataTypeCode = $filteredSampleResult->data_type_code;
            $resultValue = (float)$filteredSampleResult->result_value;
            $minValue = (float)$filteredSampleResult->min_value;
            $maxValue = (float)$filteredSampleResult->max_value;

            if (($dataTypeCode == "N" || $dataTypeCode == "E") && ($resultValue < $minValue || $resultValue > $maxValue)) {
                if($filteredSampleResult->remark_no_result !== null && $filteredSampleResult->remark_no_result !== "") { // remark_no_result
                    $countPassedResult++;
                } else {
                    $countFailedResult++;
                }
            } else {
                $countPassedResult++;
            }

            $countItem++;

        }
        
        if($countItem > 0) {
            if($countPassedResult == $countItem) {
                $sampleResultStatus = "CF";
            } else {
                $sampleResultStatus = "NC";
            }
        }

        if($gmdSample->attribute13 == "12" || $gmdSample->attribute13 == "22" || $gmdSample->attribute13 == "32") {
            $sampleResultStatus = "RJ";
        }
        
        return $sampleResultStatus;

    }

    public static function getSampleCigResultStatus($gmdSample, $sampleResults) {

        $sampleResultStatus = "PD";
        
        $countItem = 0;
        $countPassedResult = 0;
        $countFailedResult = 0;

        foreach($sampleResults as $sampleResult) {

            // if($sampleResult->read_only != 'Y') {

            $dataTypeCode = $sampleResult->data_type_code;
            $resultValue = (float)$sampleResult->result_value;
            $minValue = (float)$sampleResult->min_value;
            $maxValue = (float)$sampleResult->max_value;

            if (($dataTypeCode == "N" || $dataTypeCode == "E") && ($resultValue > 0)) {
                if($sampleResult->remark_no_result !== null && $sampleResult->remark_no_result !== "") { // remark_no_result
                    $countPassedResult++;
                } else {
                    $countFailedResult++;
                }
            } else {
                $countPassedResult++;
            }

            $countItem++;

            // }

        }

        if($countPassedResult == $countItem) {
            $sampleResultStatus = "CF";
        } else {
            $sampleResultStatus = "NC";
        }

        if($gmdSample->attribute13 == "12" || $gmdSample->attribute13 == "22" || $gmdSample->attribute13 == "32") {
            $sampleResultStatus = "RJ";
        }
        
        return $sampleResultStatus;

    }

    public static function getSampleResultStatusDesc($status) {
        $label = "";
        if($status == "PD") {
            $label = "ผลยังไม่ออก";
        } else if($status == "CF") {
            $label = "ผลทดสอบปกติ";
        } else if($status == "NC") {
            $label = "พบค่าความผิดปกติ";
        } else if($status == "RJ") {
            $label = "ปฏิเสธผล";
        }
        return $label;
    }

}
