<?php
namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Arr;
use App\Models\PM\PtpmSendCigaretteHT;
use App\Repositories\PM\JamRepository;

class JamController extends Controller
{

    public function getLines(Request $request)
    {
        $data = (new JamRepository)->getLines($request);
        $lines = $data->lines;

        $data = [
            'lines' => $lines,
        ];
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        try {
            $header = (new JamRepository)->store($request);
            // $header->refresh();
            // $resHeader = request()->header;
            // $resHeader['storage_header_id'] = data_get($header, 'storage_header_id',  -1);
            // $resHeader['mfg_order_number'] =  data_get($header, 'mfg_order_number',  -1);
            // $resHeader['lot_number'] = data_get($header, 'lot_number', 'Lot: '. date('Ymd-His'));
            // $resHeader['attribute1'] = data_get($header, 'attribute1');
            // $resHeader['can'] = $header->can;

            $result = (new JamRepository)->asrsPkg($header);

            $header->refresh();
            if ($header->interface_status == 'S') {
            } else {
                $msg = $result['msg'];
                $lines = \App\Models\PM\PtpmSendCigaretteLT::where('storage_header_id', $header->storage_header_id)->get();
                foreach ($lines as $key => $line) {
                    if ($line->interface_msg && $line->interface_status != 'S') {
                        $msg .= "\n {$line->interface_msg}";
                    }
                }

                throw new \Exception($msg);
            }

             $data = [
                'status' => 'S',
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

    public function setStatus(PtpmSendCigaretteHT $header)
    {
        try {
            $status = request()->status;

            if ($status == 'confirmTransfer') {

                // if ($header->wip_request_status == 1 && $header->export_to_wms_flag != 'I') {

                //     $result = $header->infWms();

                //     $header->refresh();
                //     if ($header->export_to_wms_flag == 'I') {
                //         $header->wip_request_status = 2;
                //         $header->save();
                //     } else {
                //         throw new \Exception($result['status']);
                //     }
                // }
                $header->mfg_status = 2;
                $header->save();
            } elseif($status == 'cancelTransfer') {
                $header->mfg_status = 4;
                $header->save();
            }

            $profile = getDefaultData('/pm/wip-requests');
            $sysdate = now();
            $header->updated_by_id      = $profile->user_id;
            $header->last_updated_by    = $profile->fnd_user_id;
            $header->updated_at         = $sysdate;
            $header->last_update_date   = $sysdate;
            $header->save();

            $data = [
                'status' => 'S',
                'request_status' => $header->wip_request_status,
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

    public function getItem(Request $request)
    {
        try {

            $items = (new JamRepository)->searchItem($request);
            $data = [
                'status' => 'S',
                'items' => $items
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
}
