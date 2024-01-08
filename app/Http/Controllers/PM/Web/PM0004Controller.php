<?php

namespace App\Http\Controllers\PM\Web;

use App\Http\Controllers\PM\Api\PM0005ApiController;
use App\Models\PM\Lookup\PtpmRequestTransferStatus;
use App\Models\PM\PtpmRequestHeader;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PM0004Controller extends BaseController
{

    /**
     * @var PM0005ApiController
     */
    private $api;

    /**
     * RequestMaterialController constructor.
     * @param PM0005ApiController $api
     */
    public function __construct(PM0005ApiController $api)
    {
        $this->api = $api;
    }


    public function index(Request $request)
    {
        $headers = PtpmRequestHeader::with([
            'coaDeptCodeV',
            'requestTransferStatus',
        ]);

        if ($request_number = $request->get('request_number')) {
            $headers = $headers->where('request_number', 'like', "%$request_number%");
        }
        if ($request_date_from = $request->get('request_date_from')) {
            $headers = $headers->whereDate('request_date', '>=', $request_date_from);
        }
        if ($request_date_to = $request->get('request_date_to')) {
            $headers = $headers->whereDate('request_date', '<=', $request_date_to);
        }
        if ($send_date_from = $request->get('send_date_from')) {
            $headers = $headers->whereDate('send_date', '>=', $send_date_from);
        }
        if ($send_date_to = $request->get('send_date_to')) {
            $headers = $headers->whereDate('send_date', '<=', $send_date_to);
        }
        if ($request_status = $request->get('request_status')) {
            $headers = $headers->where('request_status', $request_status);
        }
        $headers = $headers->get();

//        print_r([
//            $request->all(),
//            $headers->toSql(),
//        ]);

        $btnTrans = trans('btn');
        $user = auth()->user();

        $requestTransferStatusList = PtpmRequestTransferStatus::all();

        return $this->vue('pm0004', [
            'init_headers' => $headers,
            'init_search_params' => [
                'request_number' => $request_number,
                'request_date_from' => $request_date_from,
                'request_date_to' => $request_date_to,
                'send_date_from' => $send_date_from,
                'send_date_to' => $send_date_to,
                'request_status' => $request_status,
            ],
            'user' => $user,
            "btn_trans" => $btnTrans,
            'request_status_list' => $requestTransferStatusList,
        ]);
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function show($id = null)
    {
        $user = auth()->user();

        if (intval($id)) {
            $info = $this->api->show($id)->getData();
            $data = [
                'header_id' => $id,
                'init_header' => $info->header,
                'init_lines' => $info->lines,
                'user' => $user,
            ];
        } else {
            $data = [
                'header_id' => null,
                'init_header' => (object)[],
                'init_lines' => (array)[],
                'user' => $user,
            ];
        }
        return $this->vue('pm0005', $data);
    }
}
