<?php
namespace App\Http\Controllers\PD\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Arr;
use App\Models\PM\PtpmWipRequestHeader;
use App\Repositories\PD\ExpFmlRepository;

class ExpFmlController extends Controller
{

    public function getLines(Request $request)
    {
        $lines = (new ExpFmlRepository)->getLines($request);

        $data = [
            'lines' => $lines,
        ];
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        try {
            if ($request->action == 'duplicate') {
                $header = (new ExpFmlRepository)->duplicate($request);
            } else {
                $header = (new ExpFmlRepository)->store($request);
            }

            // $header->refresh();
            // $resHeader = request()->header;
            // $resHeader['wip_req_header_id'] =  data_get($header, 'wip_req_header_id',  -1);
            // $resHeader['wip_request_no'] = data_get($header, 'wip_request_no', date('Ymd-His'));
            // $resHeader['can'] = $header->can;

             $data = [
                'status' => 'S',
                // 'header' => $resHeader
                'header' => $header
            ];

        } catch (\Exception $e) {
            \Log::error($e);
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function setStatus(PtpmWipRequestHeader $header)
    {
        try {
            $status = request()->status;

            if ($status == 'infWipCompleted') {

                if ($header->interface_status != 'S' && $header->wip_request_status) {
                    $result = $header->infWipComplete();
                    $header->refresh();
                    if ($result['status'] == 'S') {
                        $header->wip_request_status = 2;
                        $header->save();
                    } else {
                        throw new \Exception($result['msg']);
                    }
                }
            } elseif($status == 'infWipCompletedReturn') {
                $header->wip_request_status = 3;
                $header->save();
            } elseif($status == 'cancelTransfer') {
                $header->wip_request_status = 4;
                $header->save();
            }

            $profile = getDefaultData('/pm/wip-requests');
            $sysdate = now();
            $header->updated_by_id      = $profile->user_id;
            $header->last_updated_by    = $profile->fnd_user_id;
            $header->updated_at         = $sysdate;
            $header->last_update_date   = $sysdate;
            $header->save();

            $header->refresh();
            $data = [
                'status' => 'S',
                'wip_request_status' => $header->wip_request_status,
                'can' => $header->can,
                'msg' => ''
            ];

        } catch (\Exception $e) {
            \Log::error($e);
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }
        return response()->json(['data' => $data]);
    }

    public function getData(Request $request)
    {
        try {
            $data = (new ExpFmlRepository)->getData($request);
            $data['status'] = 'S';

        } catch (\Exception $e) {
            \Log::error($e);
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function compareData(Request $request)
    {
        try {
            $isEqual = (new ExpFmlRepository)->getCompareData($request);
            $data['status'] = 'S';
            $data['is_equal'] = $isEqual;


        } catch (\Exception $e) {
            \Log::error($e);
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json(['data' => $data]);
    }
}
