<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Arr;

use App\Models\PM\PtpmMfgFormulaV;
use App\Models\PM\PtpmSetupMfgDepartmentsV;
use App\Models\PM\Lookup\PtinvOnhandQuantitiesV;
use App\Models\PD\Lookup\MtlUnitsOfMeasureVl;
use App\Models\PM\Lookup\PtpmItemConvUomV;
use App\Models\PM\PtpmRequestHeader;
use App\Models\PM\PtpmRequestLine;
use App\Models\PM\PtpmItemNumberV;

use App\Repositories\PM\MaterialRequestRepository;

class MaterialRequestController extends Controller
{

    public function lines(Request $request)
    {
        $lines = (new MaterialRequestRepository)->lines($request);
        $data = [
            'lines' => $lines,
        ];
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        try {
            $inputHeader = (object) $request->header;
            $profile = getDefaultData('/pm/material-requests');
            $organizationId = $profile->organization_id;
            $sysdate = now();
            $headerId = Arr::get(request()->header, 'request_header_id', false);

            if ($headerId) {
                $header = PtpmRequestHeader::find($headerId);
            } else {
                $header = new PtpmRequestHeader;
                $header->created_by         = $profile->fnd_user_id;
                $header->created_by_id      = $profile->user_id;
                $header->request_type       = 1; // เป็นการสร้างจากหน้า PMP0005
                $header->created_at         = $sysdate;
                $header->creation_date      = $sysdate;
            }


            $header->organization_id    = $organizationId;
            $header->ingredient_group   = Arr::get(request()->header, 'ingredient_group');
            $header->department_code    = Arr::get(request()->header, 'department_code');
            $header->inventory_item_id  = Arr::get(request()->header, 'inventory_item_id');
            $header->objective_code     = Arr::get(request()->header, 'objective_code');
            $header->request_status     = Arr::get(request()->header, 'request_status');
            $header->work_step          = Arr::get(request()->header, 'work_step');


            $programCode = $profile->program_code ?? 'PMP0005';
            if ($headerId) {
                $programCode = $header->program_code;
            }


            $header->send_date          = '';
            $header->request_date       = '';
            if (($sendDate = Arr::get(request()->header, 'send_date_format')) != '') {
                $header->send_date      = parseFromDateTh($sendDate, 'H:i:s');
            }
            if (($requestDate = Arr::get(request()->header, 'request_date_format')) != '') {
                $header->request_date   = parseFromDateTh($requestDate, 'H:i:s');
            }


            $header->request_quantity   = Arr::get(request()->header, 'request_quantity');
            $header->attribute1         = Arr::get(request()->header, 'attribute1'); // product_uon_code
            $header->attribute2         = Arr::get(request()->header, 'attribute2'); // case

            // item_cat_code วัตถุประสง 3 สิ้นเปลือง, วัตถุประสง 2 เพื่อผลิต
            $header->attribute3         = Arr::get(request()->header, 'attribute3');

            $header->program_code       = $programCode;

            $header->updated_by_id      = $profile->user_id;
            $header->last_updated_by    = $profile->fnd_user_id;

            $header->updated_at         = $sysdate;
            $header->last_update_date   = $sysdate;
            $header->save();

            $selectLineIdList = [];
            foreach (request()->lines as $key => $reqLine) {
                $reqLine = (object) $reqLine;
                $line = new PtpmRequestLine;
                if ($reqLine->request_line_id) {
                    $line = PtpmRequestLine::find($reqLine->request_line_id);
                }

                $line->request_header_id    = $header->request_header_id;
                $line->organization_id      = $reqLine->organization_id;
                $line->subinventory_code    = $reqLine->subinventory_code;
                $line->locator_id           = $reqLine->locator_id;
                $line->inventory_item_id    = $reqLine->inventory_item_id;
                $line->lot_number           = $reqLine->lot_number;
                $line->transaction_quantity = $reqLine->transaction_quantity;
                $line->transaction_uom      = $reqLine->transaction_uom;
                $line->remark_msg           = $reqLine->remark_msg;
                $line->secondary_qty        = $reqLine->secondary_qty;
                $line->secondary_uom        = $reqLine->secondary_uom;

                $line->attribute1           =  str_replace(',', '', $reqLine->sourcing_onhand);
                $line->attribute2           =  $reqLine->item_number;
                $line->attribute3           =  $reqLine->item_desc;
                $line->attribute4           =  $reqLine->transaction_uom_desc;
                $line->attribute5           =  $reqLine->tobacco_group_code;
                $line->attribute6           =  $reqLine->item_classification_code;
                $line->attribute7           =  $reqLine->tobacco_type_code;
                $line->attribute8           =  $reqLine->use_lose_qty;
                $line->attribute9           =  $reqLine->ratio_require_per_unit;
                $line->attribute10          =  $reqLine->require_qty;
                $line->attribute11          =  str_replace(',', '', $reqLine->production_onhand);

                $line->program_code         = $programCode;
                $line->created_by_id        = $profile->user_id;
                $line->updated_by_id        = $profile->user_id;
                $line->created_by           = $profile->fnd_user_id;
                $line->last_updated_by      = $profile->fnd_user_id;

                $line->created_at           = $sysdate;
                $line->updated_at           = $sysdate;
                $line->last_update_date     = $sysdate;
                $line->creation_date        = $sysdate;
                $line->creation_date        = $sysdate;
                $line->save();

                $selectLineIdList[] = $line->request_line_id;
            }

            // clear รายการที่ไม่เลือก
            $lines = PtpmRequestLine::where('request_header_id', $header->request_header_id)
                        ->whereNotIn('request_line_id', $selectLineIdList)
                        ->get();
            foreach ($lines as $key => $line) {
                $line->deleted_by_id = $profile->user_id;
                $line->save();
                $line->delete();
            }

            $header->refresh();
            $resHeader = request()->header;
            $resHeader['request_header_id'] = $header->request_header_id;
            $resHeader['request_number'] = $header->request_number;
            $resHeader['can'] = $header->can;



             $data = [
                'status' => 'S',
                'header' => $resHeader,
                'url_print_pdf' => "/pm/sample-report1-pdf/{$header->request_number}",
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

    public function setStatus(PtpmRequestHeader $requestHeader)
    {
        try {
            $status = request()->status;
            if ($status == 'confirmTransfer') {

                if ($requestHeader->request_status == 1 && $requestHeader->export_to_wms_flag != 'I') {

                    $result = $requestHeader->infWms();

                    $requestHeader->refresh();
                    if ($requestHeader->export_to_wms_flag == 'I') {
                        $requestHeader->request_status = 2;
                        $requestHeader->save();
                    } else {
                        throw new \Exception($result['status']);
                    }
                }
            } elseif($status == 'cancelTransfer') {
                $requestHeader->request_status = 4;
                $requestHeader->save();
            }

            $data = [
                'status' => 'S',
                'request_status' => $requestHeader->request_status,
                'can' => $requestHeader->can,
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
            $items = (new MaterialRequestRepository)->getItem($request);
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
