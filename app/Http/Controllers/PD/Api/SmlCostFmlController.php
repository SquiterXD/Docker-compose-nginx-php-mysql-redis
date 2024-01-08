<?php
namespace App\Http\Controllers\PD\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Arr;
use App\Repositories\PD\SmlCostFmlRepository;

class SmlCostFmlController extends Controller
{

    public function store(Request $request)
    {
        try {
            $repo = new SmlCostFmlRepository;
            if ($request->action == 'validate') {
                $result = $repo->validate($request);
                return response()->json(['data' => $result]);
            } else if ($request->action == 'copyToPd08') {
                $header = $repo->copyToPd08($request);
            } else if ($request->action == 'duplicate') {
                $header = $repo->duplicate($request);
            } else if ($request->action == 'checkVersion') {
                $header = $repo->checkVersion($request);
            } else if ($request->action == 'storeFromPd08') {
                $header = $repo->storeFromPd08($request);
            } else if ($request->action == 'reCalCost') {
                $header = $repo->reCalCost($request);
            }  else if ($request->action == 'confirmSave') {
                $header = $repo->confirmSave($request);
            } else {
                $header = $repo->store($request);
            }

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
            $data = (new SmlCostFmlRepository)->getData($request);
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
            $isEqual = (new SmlCostFmlRepository)->getCompareData($request);
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
