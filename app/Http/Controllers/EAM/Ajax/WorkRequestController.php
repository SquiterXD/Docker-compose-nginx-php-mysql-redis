<?php

namespace App\Http\Controllers\EAM\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Requests\EAM\StoreWorkRequestRequest;
use App\Models\EAM\ApproverV;
use App\Models\EAM\WorkRequest;
use App\Models\EAM\WorkRequestV;
use App\Models\EAM\HierarchyV;
use App\Models\EAM\WorkRequestInterface;
use App\Models\EAM\WorkRequestImage;
use App\Models\EAM\LOV\WorkRequestStatus;
use App\Models\EAM\LOV\WorkReceiptStatus;
use App\Models\EAM\LOV\WorkRequest as WorkRequestView;
use App\Models\EAM\LOV\WorkRequestReport as WorkRequestReportView;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\EAM\LOV\PTWUsers;

class WorkRequestController extends Controller
{
    protected $imageFolder = 'attachments/2020/';

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWorkRequestRequest $request)
    {
        try {
            $params = $request->all();
            if (isset($params['approved_date']) && $params['approved_date'] != "") {
                $params['approved_date'] = parseFromDateTh($params['approved_date']);
            } else {
                $params = Arr::except($params, ['confirm-password']);
            }
            $workRequest = WorkRequest::saveData($params);
            $interface = $this->interface($workRequest->web_batch_no);
            if ($interface['status'] == 'E') {
                $code = 400;
            } else {
                $code = 200;
            }
            $response = WorkRequest::where('work_request_id', $workRequest->work_request_id)->first();
            $response->expected_start_date      = parseToDateTh($response->expected_start_date);
            $response->approved_date = parseToDateTh($response->approved_date);
            return response()->json(
                [
                    'code' => $code,
                    'data' => $response,
                    'message' => $interface['message']
                ],
                $code
            );
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($workRequestNumber)
    {
        $workRequest = WorkRequestV::whereRaw("pteam_work_req_v.work_request_number = '{$workRequestNumber}' ")
                                    ->leftJoin('pteam_asset_number_v', 'pteam_work_req_v.asset_number', '=', 'pteam_asset_number_v.asset_number')
                                    ->leftJoin('pteam_wip_class_v', 'pteam_asset_number_v.department', '=', 'pteam_wip_class_v.department')
                                    ->select('pteam_work_req_v.*', 'pteam_asset_number_v.department', 'pteam_wip_class_v.class_code', 'pteam_asset_number_v.asset_group_desc')
                                    ->first();
        $workRequest->expected_resolution_date = parseToDateTh($workRequest->expected_resolution_date);
        $workRequest->expected_start_date = parseToDateTh($workRequest->expected_start_date);
        $workRequest->approved_date = parseToDateTh($workRequest->approved_date, 'H:i:s');
        if (isset($workRequest->wo_reference)) {
            $workRequest->wo_reference_name = $workRequest->wo_reference . ':' . WorkReceiptStatus::getName($workRequest->wo_reference);
        } else {
            $workRequest->wo_reference_name = '';
        }
        return response()->json(['data' => $workRequest]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        try {
            $result = (new WorkRequestV())->SearchWorkReq($request->all());
            return response()->json(['data' => $result]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function searchWithHierarchyV(Request $request)
    {
        try {
            $userId         = optional(auth()->user())->user_id ?? -1;
            $attribute1     =  HierarchyV::where('attribute2', $userId)->pluck('attribute1');
            $result         = (new WorkRequestV())->SearchWorkReqWithHierarchyV($request->all(), $attribute1);
            return response()->json(['data' => $result]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function sendApprove($workRequestId)
    {
        try {
            $userId         = auth()->user()->user_id;
            $checked        = ApproverV::checkUser($userId);
            $statusId       = ($checked) ? '8' : '3';
            $status         = WorkRequestStatus::where('lookup_code', $statusId)->first();
            $workRequest    = WorkRequest::where('work_request_id', $workRequestId)->first();

            $workRequest->approver_desc             = '';
            $workRequest->approved_date             = '';
            $workRequest->work_request_status_id    = $status->lookup_code;
            $workRequest->work_request_status_desc  =  $status->meaning;
            $workRequest->web_batch_no              = WorkRequest::getWebBatchNo();
            $workRequest->updated_by_id             = $userId;
            $workRequest->save();

            $interface = $this->interface($workRequest->web_batch_no);
            if ($interface['status'] == 'E') {
                $code = 400;
            } else {
                $code = 200;
            }
            $response = WorkRequestV::where('work_request_number', $workRequest->work_request_number)->first();
            return response()->json(
                [
                    'code' => $code,
                    'data' => $response,
                    'message' => $interface['message']
                ],
                $code
            );
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function uploadImage(Request $request, $workRequestId)
    {
        try {
            $webBatchNo = WorkRequest::where('work_request_number', $workRequestId)->first();
            if (!$webBatchNo) {
                return response()->json(['message' => 'กรุณาบันทึกการแจ้งซ่อมก่อน'], 400);
            }
            $programCode = $request->program_code;
            /* store image file */
            $imageName = uniqid() . '.' . $request->image->extension();
            $originalName = $request->image->getClientOriginalName();
            $imagePath = $this->imageFolder;
            $request->image->storeAs($imagePath, $imageName);
            /* store image name in database */
            $image = new WorkRequestImage();
            $image->ema_program_code = $programCode;
            $image->tran_id = $workRequestId;
            $image->line_no = WorkRequestImage::getNextLineNo($workRequestId, $programCode);
            $image->original_name = $originalName;
            $image->path = $imagePath;
            $image->mime_type = $request->image->extension();
            $image->file_name = $imageName;
            $image->program_code = $programCode;
            $image->created_by = auth()->user()->fnd_user_id;
            $image->created_by_id = auth()->user()->user_id;
            $image->last_updated_by = auth()->user()->fnd_user_id;
            $image->web_batch_no = $webBatchNo->web_batch_no;
            $image->save();

            return response()->json(['data' => $image]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function showImage($imageId)
    {
        $image = WorkRequestImage::find($imageId);
        $filename = $image->file_name;
        $path = storage_path('app/' . $image->path . $filename);
        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    public function images($workRequestId)
    {
        $images = WorkRequestImage::select([
                                        'attachment_id',
                                        'original_name',
                                    ])
                                ->where('ema_program_code', 'EAM0007')
                                ->where('tran_id', $workRequestId)
                                ->orderBy('line_no')
                                ->get();
        return response()->json(['data' => $images]);
    }

    public function deleteImage($imageId)
    {
        $image = WorkRequestImage::find($imageId);
        if (Storage::exists($image->path . $image->file_name)) {
            Storage::delete($image->path . $image->file_name);
            $image->delete();
            return response()->json(['message' => 'Success.', 'code' => 200]);
        } else {
            return response()->json(['message' => 'File does not exists.', 'code' => 400]);
        }
    }

    public function interface($batchNo)
    {
        $result = (new WorkRequestInterface)->workReqImport($batchNo);
        return $result;
    }

    public function updateStatus(Request $request)
    {
        try {
            $user = Auth::user();
            $userName = $user->name;
            $statusId = $request->work_request_status_id;
            $workRequests = $request->data;
            foreach ($workRequests as $value) {
                $value['work_request_status_id'] = $statusId;
                $value['work_request_status_desc'] = WorkRequestStatus::getName($statusId);
                if($request['work_request_status_id'] == '5'){
                    $value['approver_desc'] = '';
                    $value['approved_date'] = '';
                }else{
                    $value['approver_desc'] = $userName;
                    $value['approved_date'] = Carbon::now();
                }
                $value['program_code'] = 'EAM0008';

                $workRequest = WorkRequest::saveData($value);
                $interface = $this->interface($workRequest->web_batch_no);
                if ($interface['status'] == 'E') {
                    return response()->json(['code' => 400, 'message' => $interface['message']], 400);
                }
            }
            return response()->json(['code' => 200]);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function report(Request $request)
    {
        $workReqNo =            trim($request->p_work_request_number ?? '%');
        $workReqNoTo =          trim($request->p_work_request_number_to ?? $workReqNo);
        $expResDate =           parseFromDateTh($request->p_expected_resolution_date) ?? null;
        $expResDateTo =         parseFromDateTh($request->p_expected_resolution_date_to) ?? null;
        $assetNo =              trim($request->p_asset_number ?? '%');
        $statusDesc =           trim($request->p_work_request_status_desc ?? '%');
        $owningDeptCode =       trim($request->p_owning_dept_code ?? '%');
        $receivingDeptCode =    trim($request->p_receiving_dept_code ?? '%');

        if ($workReqNo != '%') {
            $data = WorkRequestReportView::whereBetween('work_request_number', [$workReqNo, $workReqNoTo])->get();
        } else {
            $query = WorkRequestReportView::where('asset_number', 'like', $assetNo)
                                        ->where('owning_dept_code', 'like', $owningDeptCode)
                                        ->where('work_request_status_desc', 'like', $statusDesc)
                                        ->where('receiving_dept_code', 'like', $receivingDeptCode)
                                        ->orderBy('work_request_number');
            if ($expResDate != null) {
                $query = $query->whereRaw(" trunc(expected_start_date) >= to_date('{$expResDate}', 'YYYY-MM-DD') ");
            }
            if ($expResDateTo != null) {
                $query = $query->whereRaw(" trunc(expected_start_date) <= to_date('{$expResDateTo}', 'YYYY-MM-DD') ");
            }
            $data = $query->get();
        }
        foreach ($data as $item) {
            $images = WorkRequestImage::index($item->work_request_id);
            $item->images = $images;
        }
        $pdf = \PDF::loadView('eam.exports.pdf', ['workRequests' => $data])
                    ->setPaper('a4')
                    ->setOption('margin-top', '0.5cm')
                    ->setOption('margin-bottom', '0.5cm')
                    ->setOption('margin-left', '0.7cm')
                    ->setOption('margin-right', '0.7cm')
                    ->setOption('encoding', 'utf-8');

        return $pdf->inline();
    }

    public function checkPermissionApprove()
    {
        try {
            $profile = getDefaultData();
            $checked = (ApproverV::checkUser($profile->user_id)) ? 'Y' : 'N' ;
            $checked = (ApproverV::checkUser($profile->user_id)) ? 'N' : 'Y';

            if($checked == 'N'){
                $attribute1 = ApproverV::where('attribute1', $profile->user_id)->get();
                $attribute2 = ApproverV::where('attribute2', $profile->user_id)->get();
                if($attribute1 && $attribute2){
                    $checked = '';
                }else{
                    $checked = 'N';
                }
            }

            $response = ['permission' => $checked];
            return response()->json(['data' => $response], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function cancel($workRequestNumber)
    {
        try {
            $programCode = request('program_code');
            $reason = request('reason');
            $statusId = 7;
            $statusDesc = 'Cancelled';
            $workRequest = WorkRequest::cancel($workRequestNumber, $programCode, $reason, $statusId, $statusDesc);
            $interface = $this->interface($workRequest->web_batch_no);
            $code = ($interface['status'] == 'E') ? 400 : 200;

            return response()->json(['message' => $interface['message']], $code);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function cancelApproval($workRequestNumber)
    {
        try {
            $programCode = request('program_code');
            $statusId = 1;
            $statusDesc = 'Open';
            $workRequest = WorkRequest::cancel($workRequestNumber, $programCode, '', $statusId, $statusDesc);
            $interface = $this->interface($workRequest->web_batch_no);
            $code = ($interface['status'] == 'E') ? 400 : 200;

            return response()->json(['message' => $interface['message']], $code);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function awaitingWorkOrderWorkRequests($workRequestNumber)
    {
        try {
            $programCode    = request('program_code');
            $statusId       = 3;
            $statusDesc     = 'Awaiting Work Order';
            $workRequest    = WorkRequest::cancel($workRequestNumber, $programCode, '', $statusId, $statusDesc);
            $interface      = $this->interface($workRequest->web_batch_no);
            $code           = ($interface['status'] == 'E') ? 400 : 200;
            
            return response()->json(['message' => $interface['message']], $code);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function rejecteWorkRequests($workRequestNumber)
    {
        try {
            $programCode = request('program_code');
            $statusId = 5;
            $statusDesc = 'Rejected';
            $workRequest = WorkRequest::cancel($workRequestNumber, $programCode, '', $statusId, $statusDesc);
            $interface = $this->interface($workRequest->web_batch_no);
            $code = ($interface['status'] == 'E') ? 400 : 200;

            return response()->json(['message' => $interface['message']], $code);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }
}
