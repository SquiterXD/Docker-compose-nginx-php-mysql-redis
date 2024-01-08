<?php

namespace App\Http\Controllers\PD\Web;

use App\Http\Controllers\PD\Api\PD0005ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PD0005Controller extends BaseController
{
    /**
     * @var PD0005ApiController
     */
    private $api;

    /**
     * RequestMaterialController constructor.
     * @param PD0005ApiController $api
     */
    public function __construct(PD0005ApiController $api)
    {
        $this->api = $api;
    }

    /** @noinspection DuplicatedCode */
    public function index()
    {
        $sequenceSql = "SELECT APPS.PTPD_MAIN_PKG.MAX_SEQ_BY_CAT('1590') AS sequence FROM DUAL";
        $dbSequence = DB::select(DB::raw($sequenceSql))[0];
        $nextSequence = ($dbSequence->sequence) + 1;

        $exampleCigarette = [];
        $exampleCigarette['inventory_item_code'] = null;
        $exampleCigarette['description'] = "บุหรี่ทดลอง $nextSequence";

        $dataModel = [
            'example_cigarette' => $exampleCigarette,
            'is_create_new' => true,

            // common button
            'btn_trans' => trans('btn'),
        ];

        return $this->vue('pd0005', $dataModel);
    }

    public function show($inventoryItemId)
    {
        $response = $this->api->show($inventoryItemId);
        if ($response->isNotFound()) {
            return view('404');
        }
        if (!$response->isOk()) {
            return view('500', $response->getData());
        }

        $data = $response->getData();
        $dataModel = [
            'example_cigarette' => $data->example_cigarette,
            'is_create_new' => false,

            // common button
            'btn_trans' => trans('btn'),
        ];

        return $this->vue('pd0005', $dataModel);
    }
}
