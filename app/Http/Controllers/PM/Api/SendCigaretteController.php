<?php
namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Arr;
use App\Models\PM\PtpmSendCigaretteHT;
use App\Repositories\PM\SendCigaretteRepository;

class SendCigaretteController extends Controller
{

    public function getLines(Request $request)
    {
        $data = (new SendCigaretteRepository)->getLines($request);
        $lines = $data->lines;
        $biweekly = $data->biweekly;

        $data = [
            'lines' => $lines,
            'biweekly' => $biweekly,
        ];
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        try {
            $header = (new SendCigaretteRepository)->store($request);


            $result = (new SendCigaretteRepository)->asrsPkg($header);

            $header->refresh();
            $resHeader = request()->header;
            $resHeader['storage_header_id'] = data_get($header, 'storage_header_id',  -1);
            $resHeader['mfg_order_number'] =  data_get($header, 'mfg_order_number',  -1);
            $resHeader['lot_number'] = data_get($header, 'lot_number', '');
            $resHeader['attribute1'] = data_get($header, 'attribute1');
            $resHeader['can'] = $header->can;


             $data = [
                'status' => 'S',
                'header' => $resHeader
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
                'mfg_status' => $header->mfg_status,
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

            $items = (new SendCigaretteRepository)->searchItem($request);
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
